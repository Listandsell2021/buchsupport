<template>
    <div class="ls-edit-section">
        <h6 class="m-b-20">{{ $t('Add Lead Status') }}</h6>
        <div class="form-group">
            <label for="name">{{ $t('Name') }}</label>
            <input type="text" class="form-control form-control-sm" v-model="form.name" id="name"/>
        </div>
        <div class="form-group">
            <label for="code">{{ $t('Code') }}</label>
            <input type="text" class="form-control form-control-sm" v-model="form.code" id="code"/>
        </div>
        <div class="form-group">
            <label for="default">{{ $t('Default') }}</label>
            <StatusSwitcher :is_active="form.default"
                            @toggle="setDefaultStatus"
                            :key="generateRandomString()"
            ></StatusSwitcher>
        </div>
        <div class="clearfix ls-edit-btn">
            <button class="btn btn-danger btn-sm pull-left"
                    @click.prevent="clearForm"
            ><i class="fa fa-remove m-r-5"></i> {{ $t('Clear') }}</button>
            <button class="btn btn-primary btn-sm pull-right" @click.prevent="addLeadStatus">
                <i class="fa fa-save m-r-5"></i> {{ $t('Save') }}
            </button>
        </div>


    </div>
</template>

<script setup>
import {ref} from "vue";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import Notifier from "@/libraries/utils/Notifier";
import StatusSwitcher from "@/components/widgets/form/StatusSwitcher";
import PasswordGenerator from "@/libraries/utils/helpers/PasswordGenerator";
import { useLeadStatusStore } from "@/storage/store/lead_status";

const emit = defineEmits(['refresh']);

const form = ref({
    name: '',
    code: '',
    default: 0,
});

function addLeadStatus() {
    axios.post(route('admin.lead_status.create'), form.value)
        .then((response) => {
            if (response.status === 200) {
                useLeadStatusStore().refreshLeadStatus();
                Notifier.toastSuccess(response.data.message);
                emit('refresh');
                clearForm();
            }
    });
}

function clearForm() {
    form.value = {
        name: '',
        code: '',
        default: 0,
    };
}

function setDefaultStatus(status) {
    form.value.default = status;
}

function generateRandomString() {
    return PasswordGenerator.generate(6);
}


</script>

<style scoped lang="scss">

</style>
