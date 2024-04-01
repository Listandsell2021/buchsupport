<template>
    <div class="modal fade show modal-show" id="add-lead-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" ref="modalDialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ $t('Lead Status') }}</h5>
                    <a href="#" @click.prevent="closeModal" class="close close-modal" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-8">
                            <div class="ls-search-filters row">
                                <div class="col-md-4">
                                    <input type="text"
                                           class="form-control form-control-sm"
                                           v-model="filters.name"
                                           :placeholder="$t('Search name')"
                                           @input="inputChanged"
                                    />
                                </div>
                                <div class="col-md-4">
                                    <input type="text"
                                           class="form-control form-control-sm"
                                           v-model="filters.code"
                                           :placeholder="$t('Search code')"
                                           @input="inputChanged"
                                    />
                                </div>
                                <div class="col-md-4">
                                    <select name=""
                                            class="form-control form-control-sm"
                                            id=""
                                            v-model="filters.default"
                                            @change="inputChanged"
                                    >
                                        <option value="">{{ $t('Search by default') }}</option>
                                        <option value="1">{{ $t('Yes') }}</option>
                                        <option value="0">{{ $t('No') }}</option>
                                    </select>
                                </div>
                            </div>

                            <table class="table">
                                <thead>
                                <tr>
                                    <th>{{ $t('Name') }}</th>
                                    <th>{{ $t('Code') }}</th>
                                    <th>{{ $t('Default') }}</th>
                                    <th>{{ $t('Action') }}</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr :key="generateRandomString()"
                                    v-for="indLeadStatus in leadStatus.data"
                                >
                                    <td>{{ indLeadStatus.name }}</td>
                                    <td>{{ indLeadStatus.code }}</td>
                                    <td>
                                        <StatusSwitcher :is_active="indLeadStatus.default"
                                                        class="switch-sm"
                                                        @toggle="setDefaultStatus(indLeadStatus.id, $event)"
                                        ></StatusSwitcher>
                                    </td>
                                    <td>
                                        <button class="btn btn-success btn-xs m-r-5"
                                                @click.prevent="openEditLeadStatus(indLeadStatus)"
                                                v-tooltip="$t('Edit Lead Status')"
                                        >
                                            <i class="fa fa-edit"></i>
                                        </button>

                                        <button class="btn btn-danger btn-xs ms-1"
                                                @click.prevent="removeLeadStatus(indLeadStatus.id, indLeadStatus.name)"
                                                v-tooltip="$t('Delete Lead Status')"
                                        >
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                                </tbody>
                            </table>

                            <div class="m-t-30">
                                <PaginationBar
                                    :data="leadStatus"
                                    :class="'pagination-bar-sm'"
                                    @change="getAllLeadStatus"
                                ></PaginationBar>
                            </div>

                        </div>
                        <div class="col-md-4">
                            <AddLeadStatus @refresh="getAllLeadStatus"
                                           v-if="!editLeadStatus.show"
                            ></AddLeadStatus>
                            <EditLeadStatus @refresh="getAllLeadStatus"
                                            v-if="editLeadStatus.show"
                                            @close="closeEditLeadStatus"
                                            :leadStatus="editLeadStatus.data"
                                            :key="generateRandomString()"
                            ></EditLeadStatus>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {onMounted, ref} from "vue";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import Notifier from "@/libraries/utils/Notifier";
import StatusSwitcher from "@/components/widgets/form/StatusSwitcher";
import { onClickOutside } from '@vueuse/core';
import AddLeadStatus from './AddLeadStatus';
import EditLeadStatus from "./EditLeadStatus";
import PaginationBar from "@/components/widgets/form/PaginationBar"
import debounce from "lodash/debounce";
import PasswordGenerator from "@/libraries/utils/helpers/PasswordGenerator";
import { useLeadStatusStore } from "@/storage/store/lead_status";
import {useI18n} from "vue-i18n";
import {useRouter} from "vue-router";


const emit = defineEmits(['close', 'refresh']);

const { t: $t } = useI18n();
const router = useRouter();
const modalDialog = ref(null);
const leadStatus = ref({});
const editLeadStatus = ref({
    show: false,
    data: {},
});

const filters = ref({
    name: '',
    code: '',
    default: '',
});

function removeLeadStatus(leadStatusId, leadStatusName) {
    /*Notifier.toastConfirm('Delete Lead Status', 'Do you want to delete '+leadStatusName+'?', () => {

    });*/
    axios.post(route('admin.lead_status.destroy'), {
        status_id: leadStatusId
    }).then((response) => {
        if (response.status === 200) {
            Notifier.toastSuccess(response.data.message);
            getAllLeadStatus();
            useLeadStatusStore().refreshLeadStatus();
            emit('refresh');
        }
    });

}

function getAllLeadStatus(page = 1) {
    axios.post(route('admin.lead_status.all'), {...filters.value, ...{page: page}})
        .then((response) => {
            if (response.status === 200) {
                leadStatus.value = response.data.data;
            }
    });
}

const inputChanged = debounce(() => {
    getAllLeadStatus();
}, 500);

function setDefaultStatus(leadStatusId, status) {
    axios.post(route('admin.lead_status.set_default'), {
        status_id: leadStatusId,
        default: status
    }).then((response) => {
        if (response.status === 200) {
            Notifier.toastSuccess(response.data.message);
        }
        getAllLeadStatus();
    });
}

function generateRandomString() {
    return PasswordGenerator.generate(6);
}

function closeModal() {
    emit('close');
}

function openEditLeadStatus(leadStatus) {
    editLeadStatus.value.show = true;
    editLeadStatus.value.data = leadStatus;
}

function closeEditLeadStatus() {
    editLeadStatus.value.show = false;
    editLeadStatus.value.data = {};
}

onClickOutside(modalDialog, () => {
    closeModal();
})

onMounted(async () => {
    getAllLeadStatus();
})

</script>

<style scoped lang="scss">

</style>
