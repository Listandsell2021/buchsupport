<template>

    <div>
        <div class="top-smart-list contract-box">
            <div class="ts-list-header">
                <a href="#" class="ts-list-close" @click.prevent="closeModal"><i class="fa fa-close"></i></a>
                <h3 class="ts-list-title">{{ $t('Lead Contract') }}</h3>
            </div>
            <div class="ts-list-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="document">{{ $t('Contract Document') }}</label>
                            <div>
                                <input type="file"
                                       value=""
                                       placeholder="Document"
                                       ref="documentFile"
                                       @change="updateContractDocument"
                                />
                                <template v-if="hasDocument()">
                                    <div class="m-t-10">
                                        <a href="#" @click.prevent="downloadDocument">
                                            <i class="fa fa-file"></i>
                                            {{ form.document_name }}
                                        </a>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="m-t-20 m-b-20">
                    <table class="table contract-add-table">
                        <thead>
                        <tr>
                            <th>{{ $t('Product Name') }}</th>
                            <th>{{ $t('Quantity') }}</th>
                            <th>{{ $t('Price') }}</th>
                            <th>{{ $t('Note') }}</th>
                            <th>{{ $t('Action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr :key="service.service_id" v-for="(service, serviceIndex) in form.services">
                            <td class="col-service-name">
                                <BsSelect
                                    class="contract-fs"
                                    v-model="service.service_id"
                                    :options="useServiceStore().services"
                                    label="name"
                                    :reduce="service => service.id"
                                    :clearable="false"
                                    :placeholder="$t('Select Service')"
                                ></BsSelect>
                            </td>
                            <td class="col-service-quantity">
                                <input class="form-control"
                                       v-model="service.quantity"
                                       type="number"
                                       min="1"
                                       :placeholder="$t('Enter Quantity')"
                                />
                            </td>
                            <td class="col-service-price">
                                <input class="form-control"
                                       v-model="service.price"
                                       type="number"
                                       min="1"
                                       :placeholder="$t('Enter Price')"
                                />
                            </td>
                            <td class="col-service-note">
                                <textarea class="form-control"
                                          v-model="service.note"
                                          type="number"
                                          :placeholder="$t('Enter Note')"
                                ></textarea>
                            </td>
                            <td class="col-service-action">
                                <a href="#"
                                   class="btn btn-xs btn-danger"
                                   @click.prevent="deleteProduct(serviceIndex)"
                                >
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                <div class="clearfix">
                                    <a href="#"
                                       @click.prevent="addService"
                                       class="btn btn-primary btn-xs pull-right"
                                    >
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="clearfix">
                    <button v-if="false" @click.prevent="updateContract" class="btn btn-primary m-t-30">{{ $t('Update') }}</button>
                    <button @click.prevent="requestForNewCustomer" class="btn btn-primary pull-right m-t-30">
                        {{ $t('Request New Customer') }}
                    </button>
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
import {onClickOutside} from '@vueuse/core';
import {useServiceStore} from "@/storage/store/services";
import {useNotificationStore} from '@/storage/store/notifications';
import HelperUtils from "@/libraries/utils/helpers/HelperUtils";
import {useI18n} from "vue-i18n";
import {useRouter} from "vue-router";

const emit = defineEmits(['close', 'reload-lead']);
const props = defineProps({
    leadId: {
        required: true
    }
});

const {t: $t} = useI18n();
const router = useRouter();

const modalDialog = ref(null);
const contract = ref(null);
const documentFile = ref(null);

const form = ref({
    lead_id: props.leadId,
    document: "",
    document_name: "",
    services: [],
});

onClickOutside(modalDialog, () => {
    closeModal();
})

function updateContract() {
    axios.post(route('admin.leads.update_contract_products'), {
        lead_id: form.value.lead_id,
        services: form.value.services
    })
        .then((response) => {
            if (response.status === 200) {
                Notifier.toastSuccess(response.data.message);
            }
        });
}

function requestForNewCustomer() {

    let formData = new FormData();
    formData.append('lead_id', props.leadId);
    formData.append('document', form.value.document);

    let serviceIndex = 0;
    for (const service of form.value.services) {
        Object.entries(service).forEach(([key, value]) => {
            formData.append('services['+serviceIndex+']['+key+']', value);
        });
        ++serviceIndex;
    }

    axios.post(route('admin.leads.request_new_customer'), formData)
        .then((response) => {
            if (response.status === 200) {
                Notifier.toastSuccess(response.data.message);
                useNotificationStore().refreshNotifications();
                closeModalAndReload();
            }
        });
}

function getContractDetail() {
    axios.post(route('admin.leads.get_contract'), {
        lead_id: props.leadId
    })
        .then((response) => {
            if (response.status === 200) {
                if (!HelperUtils.isEmptyArray(response.data.data)) {
                    contract.value = response.data.data;
                }
            }
        });
}

function downloadDocument() {
    axios.postDownload(route('admin.leads.download_contract_doc'), {
        contract_id: form.value.contract_id
    })
        .then((response) => {
            if (response.status === 200) {
                HelperUtils.blobFileDownload(response, form.value.document_name);
            }
        });
}

function updateContractDocument(event) {
    form.value.document = event.target.files[0];
}



function addService() {
    form.value.services.push({
        service_id: null,
        quantity: 1,
        note: 1,
        price: 0,
    });
}

function deleteProduct(serviceIndex) {
    form.value.services.splice(serviceIndex, 1);
}

function closeModal() {
    emit('close');
}

function closeModalAndReload() {
    emit('reload-lead');
    emit('close');
}

function hasDocument() {
    return form.value.document_name !== "" && form.value.document_name !== null;
}

async function reloadServices() {
    await useServiceStore().refreshServices();
}

onMounted(async () => {
    getContractDetail();
    await reloadServices();
})

</script>

<style scoped lang="scss">

</style>
