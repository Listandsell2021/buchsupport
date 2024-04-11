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

                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>{{ $t('Service') }}</label>
                            <BsSelect
                                class=""
                                v-model="form.service_id"
                                :options="useServiceStore().services"
                                label="name"
                                :reduce="service => service.id"
                                :clearable="false"
                                :placeholder="$t('Select Service')"
                            ></BsSelect>
                        </div>
                    </div>
                    <div class="col-md-5 offset-md-1">
                        <div class="form-group">
                            <label>{{ $t('Price') }}</label>
                            <input class="form-control"
                                   v-model="form.price"
                                   type="number"
                                   min="1"
                                   :placeholder="$t('Enter Price')"
                            />
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-5">
                        <div class="form-group">
                            <label>{{ $t('Quantity') }}</label>
                            <input class="form-control"
                                   v-model="form.quantity"
                                   type="number"
                                   min="1"
                                   :placeholder="$t('Enter Quantity')"
                            />
                        </div>
                    </div>
                    <div class="col-md-5 offset-md-1">
                        <div class="form-group">
                            <label>{{ $t('Note') }}</label>
                            <textarea class="form-control"
                                      v-model="form.note"
                                      rows="2"
                                      :placeholder="$t('Enter Note')"
                            ></textarea>
                        </div>
                    </div>
                </div>

                <div class="clearfix">
                    <button @click.prevent="createOrder" class="btn btn-primary pull-left">
                        {{ $t('Create order') }}
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
    service_id: null,
    quantity: 0,
    price: 0,
    note: "",
});

onClickOutside(modalDialog, () => {
    closeModal();
})

function createOrder() {

    let formData = new FormData();
    formData.append('lead_id', props.leadId);
    formData.append('document', form.value.document);
    formData.append('service_id', form.value.service_id);
    formData.append('price', form.value.price);
    formData.append('quantity', form.value.quantity);
    formData.append('note', form.value.note);

    axios.post(route('admin.leads.create_order'), formData)
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
