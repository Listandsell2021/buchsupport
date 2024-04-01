<template>
    <div>

        <InquiryBtModal :data="activeInquiry"
                        v-if="inquiryModal"
                        @close="hideInquiryDescription"
        ></InquiryBtModal>

        <Breadcrumbs :menu-items="breadcrumbConfig.comment.list()" :title="$t('Inquiry List')"/>

        <div class="container-fluid">

            <div class="mb-2 sm:mb-0">
                <PaginationBar
                    :data="inquiries"
                    @change="getInquiriesList"
                ></PaginationBar>
            </div>

            <div class="card">
                <div class="card-body">
                    <table class="table">
                        <thead>
                        <tr>
                            <th class="col-select-all">
                                <input type="checkbox"
                                       class="checkbox_animated"
                                       v-model="form.selection.all"
                                       @change="selectAll()"
                                />
                            </th>
                            <th>
                                <div v-if="isDataSelected()">
                                    <div class="btn-group">
                                        <select class="form-control form-control-sm"
                                                style="width: 200px;"
                                                v-model="form.selection.action"
                                        >
                                            <option value="">{{ $t('Action') }}</option>
                                            <option value="delete">{{ $t('Delete') }}</option>
                                        </select>
                                        <button class="btn btn-secondary btn-sm"
                                                @click.prevent="submitBulkAction()"
                                        >{{ $t('Submit') }}
                                        </button>
                                    </div>
                                </div>
                            </th>
                            <th class="fixed-t-right">{{ $t('Action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <template v-if="hasInquiries()">
                            <tr v-for="(inquiry) in inquiries.data"
                                :key="PasswordGenerator.generate()"
                            >
                                <td>
                                    <input type="checkbox"
                                           class="checkbox_animated"
                                           v-model="form.selection.data_ids"
                                           :value="inquiry.id"
                                    />
                                </td>
                                <td>
                                    <template v-if="inquiry.user">
                                        <strong>User:</strong> {{ inquiry.user.first_name }}
                                        {{ `${inquiry.user.last_name} (${inquiry.user.id})` }}
                                        <br/>
                                    </template>
                                    <template v-if="HelperUtils.isNotNullOrEmpty(inquiry.first_name)">
                                        <strong>Absender:</strong> {{ inquiry.first_name }} {{ inquiry.last_name }}<br/>
                                    </template>
                                    <template v-if="inquiry.phone">
                                        <strong>Telefonnummer:</strong>
                                        <a class="ml-1" :href="`tel:${inquiry.phone}`">{{ inquiry.phone }}</a>
                                        <br/>
                                    </template>
                                    <template v-if="inquiry.email">
                                        <strong>E-Mail: </strong>
                                        <a class="ml-1" :href="`mailto:${inquiry.email}`">{{ inquiry.email }}</a>
                                        <br/>
                                    </template>
                                    <template v-if="HelperUtils.isNotNullOrEmpty(inquiry.price)">
                                        <strong>Budget: </strong> &euro; {{ inquiry.price }}
                                        <br/>
                                    </template>
                                    <strong>Notiz:</strong>
                                    <template v-if="HelperUtils.isNotNullOrEmpty(inquiry.note)">
                                        {{ HelperUtils.truncate(inquiry.note, 200) }}
                                    </template>
                                    <br/>
                                    <strong>Angefordert:</strong> {{ DateFormatter.inGerman(inquiry.created_at) }}
                                </td>
                                <td>
                                    <button class="btn btn-primary btn-xs ms-1"
                                            @click.prevent="showInquiryDescription(inquiry)"
                                            v-tooltip="$t('View Inquiry')"
                                    >
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    <button class="btn btn-danger btn-xs ms-1"
                                            @click.prevent="deleteInquiry(inquiry.id)"
                                            v-tooltip="$t('Delete Inquiry')"
                                    >
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                        </template>
                        <template v-else>
                            <tr>
                                <td colspan="4">
                                    <div class="alert alert-danger alert-t-box">
                                        {{ $t('No Inquiries found') }}
                                    </div>
                                </td>
                            </tr>
                        </template>
                        </tbody>
                    </table>
                </div>

                <div class="m-4">
                    <PaginationBar
                        :data="inquiries"
                        @change="getInquiriesList"
                    ></PaginationBar>
                </div>

            </div>
        </div>
    </div>
</template>
<script setup>
import {onMounted, ref} from "vue";
import axios from '@/libraries/utils/clientapi/axios';
import PaginationBar from "@/components/widgets/form/PaginationBar"
import breadcrumbConfig from "@/storage/data/breadcrumbs";
import Notifier from "@/libraries/utils/Notifier";
import PaginationSetting from "@/storage/data/paginationSetting";
import route from '@/libraries/utils/ZiggyRoute';
import {useRouter} from "vue-router";
import {useI18n} from "vue-i18n";
import __Has from "lodash/has";
import InquiryBtModal from "@/components/admin/Inquiry/InquiryModal.vue";
import BtModalHelper from "@/libraries/utils/BtModalHelper";
import PasswordGenerator from "@/libraries/utils/helpers/PasswordGenerator";
import HelperUtils from "@/libraries/utils/helpers/HelperUtils";
import DateFormatter from "../../../libraries/utils/helpers/DateFormatter";
import {useMeta} from "vue-meta";


const router = useRouter();
const { t: $t } = useI18n();
useMeta({title: $t('Inquiry List')});

const form = ref({
    page: 1,
    per_page: PaginationSetting.per_page,
    filters: {
        name: '',
    },
    selection: {
        all: false,
        data_ids: [],
        action: '',
    }
});

const inquiries = ref({});
const inquiryModal = ref(false);
const activeInquiry = ref(null);

const getInquiriesList = async (page = 1, per_page = 0) => {

    setPageNumber(page, per_page);

    await axios.get(route('admin.user_inquiries.all'), form.value, {}, true).then(response => {
        inquiries.value = response.data.data;
    });
}

function hasInquiries() {
    return __Has(inquiries.value, 'data') ? (inquiries.value.data.length > 0) : inquiries.value;
}

function showInquiryDescription(comment) {
    activeInquiry.value = comment;
    inquiryModal.value = true;
    BtModalHelper.open();
}

function hideInquiryDescription() {
    inquiryModal.value = false;
    BtModalHelper.close();
}

function deleteInquiry(inquiryId) {
    Notifier.toastConfirm($t('Delete Inquiry'), $t('Do you want to delete this inquiry #{id}?', {id: inquiryId}), () => {
        axios.delete(route('admin.user_inquiries.destroy', {id: inquiryId}))
            .then((response) => {
                Notifier.toastSuccess(response.data.message);
                getInquiriesList();
            });
    }, $t('Yes'), $t('No'));
}

function selectAll() {
    if (form.value.selection.all) {
        form.value.selection.data_ids = inquiries.value.data.map(data => data.id)
    } else {
        form.value.selection.data_ids = [];
    }
}

function isDataSelected() {
    return form.value.selection.data_ids.length > 0;
}

function submitBulkAction() {
    Notifier.toastConfirm($t('Do you want to perform bulk action?'), '', () => {
        axios.post(route('admin.user_inquiries.bulk_action'), {
            data_ids: form.value.selection.data_ids,
            action: form.value.selection.action,
        }).then((response) => {
            if (response.status === 200) {
                form.value.selection = {action: '', data_ids: [], all: false};
                getInquiriesList();
                Notifier.toastSuccess(response.data.message);
            }
        });
    },)

}

function setPageNumber(page, per_page) {
    if (typeof page === 'number') {
        form.value.page = page;
    } else {
        form.value.page = 1;
    }

    if (typeof per_page === 'number' && per_page > 0) {
        form.value.per_page = per_page;
    }
}


onMounted(async () => {
    await getInquiriesList();
})

</script>