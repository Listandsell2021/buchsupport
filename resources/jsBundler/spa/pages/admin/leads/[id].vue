<template>
    <div>
        <Breadcrumbs :menu-items="breadcrumbConfig.leads.edit(leadId)" :title="$t('Lead Management')"/>

        <Transition>
            <EditLeadModal :lead="lead"
                           @close="closeEditLeadModal"
                           @reload-lead="getLeadData"
                           v-if="editLeadModal"
            ></EditLeadModal>
        </Transition>

        <Transition>
            <ContractTopSection
                :lead-id="leadId"
                @close="closeContractModal"
                @reload-lead="getLeadData"
                v-if="contractModal"
            ></ContractTopSection>
        </Transition>

        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="lead-detail-header clearfix">
                        <h4 class="ldh-title pull-left m-r-45">
                            {{ lead.first_name + ' ' + lead.last_name }}
                        </h4>
                        <template v-if="!isConverted()">
                            <button class="btn btn-light m-r-20"
                                    @click.prevent="openEditLeadModal"
                            >
                                {{ $t('Edit') }}
                            </button>
                            <button class="btn btn-primary m-r-20 " 
                                    v-if="!hasConversionRequest()"
                                    @click.prevent="openContractModal"
                            >
                                {{ $t('Convert') }}
                            </button>
                            <button v-else
                                    class="btn btn-primary m-r-20"
                                    @click.prevent="convertToCustomer"
                            >
                                {{ $t('Add to New Customer') }}
                            </button>
                        </template>
                        <template v-else>
                            <button class="btn btn-light m-r-20"
                                    @click.prevent="goToCustomer()"
                            >
                                {{ $t('Go to Customer') }}
                            </button>
                        </template>
                    </div>
                    <div class="lead-detail-body">
                        <div class="row">

                            <div class="col-md-4">

                                <div class="lead-quick-edit-box">
                                    <div class="lead-quick-edit clearfix">
                                        <label class="pull-left lde-label">{{ $t('Salesperson') }} :</label>
                                        <div class="lqe-editable">
                                            <template v-if="!editSalesperson">
                                                {{ lead.salesperson ?? '--' }}
                                            </template>
                                            <template v-if="editSalesperson && !isConverted()">
                                                <div class="lde-salesperson-edit">
                                                    <BsSelect
                                                        class="v-select-sm"
                                                        v-model="form.salesperson_id"
                                                        :options="salespersons"
                                                        label="fullname"
                                                        :reduce="salesperson => salesperson.id"
                                                        :clearable="false"
                                                        @update:model-value="updateSalesperson"
                                                        :placeholder="$t('Select Salesperson')"
                                                    />
                                                    <a href="#"
                                                       class="lde-se-close"
                                                       @click.prevent="closeEditSalesperson"
                                                    >
                                                        <i class="fa fa-close"></i>
                                                    </a>
                                                </div>

                                            </template>

                                            <template v-if="!editSalesperson && !isConverted()">
                                                <a href="#" class="edit-ls-link" @click.prevent="openEditSalesperson">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </template>
                                        </div>
                                    </div>

                                    <div class="lead-quick-edit clearfix">
                                        <label class="pull-left lde-label">{{ $t('Status') }} :</label>
                                        <div class="lqe-editable">
                                            <template v-if="!editLeadStatus">
                                                {{ lead.lead_status_name ?? '--' }}
                                            </template>
                                            <template v-if="editLeadStatus && !isConverted()">
                                                <div class="lde-salesperson-edit">
                                                    <BsSelect
                                                        class="v-select-sm"
                                                        v-model="form.lead_status_id"
                                                        :options="leadStatus"
                                                        label="name"
                                                        :reduce="status => status.id"
                                                        :clearable="false"
                                                        @update:model-value="changeLeadStatus"
                                                        :placeholder="$t('Select Lead Status')"
                                                    />
                                                    <a href="#"
                                                       class="lde-se-close"
                                                       @click.prevent="closeEditLeadStatus"
                                                    >
                                                        <i class="fa fa-close"></i>
                                                    </a>
                                                </div>

                                            </template>

                                            <template v-if="!editLeadStatus && !isConverted()">
                                                <a href="#" class="edit-ls-link" @click.prevent="openEditLeadStatus">
                                                    <i class="fa fa-edit"></i>
                                                </a>
                                            </template>
                                        </div>
                                    </div>
                                </div>

                                <LeadDetail :lead="lead"
                                            @openEditLead="openEditLeadModal"
                                            @reload="getLeadData"
                                ></LeadDetail>

                                <LeadContractDetail :lead="lead.contract" v-if="lead.contract"></LeadContractDetail>
                            </div>

                            <div class="col-md-4">
                                <LeadNotes :lead="lead"></LeadNotes>
                            </div>

                            <div class="col-md-4">
                                <LeadAppointments :lead-id="leadId"
                                                  :lead="lead"
                                ></LeadAppointments>

                                <LeadTasks :lead-id="leadId"
                                           :lead="lead"
                                ></LeadTasks>

                                <LeadDocuments :lead-id="leadId"
                                               :lead="lead"
                                ></LeadDocuments>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import {onMounted, ref} from "vue";
import breadcrumbConfig from "@/storage/data/breadcrumbs";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import Notifier from "@/libraries/utils/Notifier";
import EditLeadModal from "@/components/admin/Lead/EditLeadModal";
import BtModalHelper from "@/libraries/utils/BtModalHelper";
import {useSalespersonsStore} from '@/storage/store/salespersons';
import {useLeadStatusStore} from "@/storage/store/lead_status";
import ContractTopSection from "@/components/admin/Lead/ContractTopSection";
import LeadNotes from "@/components/admin/Lead/Inner/LeadNotes";
import LeadTasks from "@/components/admin/Lead/Inner/LeadTasks";
import LeadAppointments from "@/components/admin/Lead/Inner/LeadAppointments";
import LeadContractDetail from "@/components/admin/Lead/Inner/LeadContractDetail";
import LeadDocuments from "@/components/admin/Lead/Inner/LeadDocuments";
import LeadDetail from "@/components/admin/Lead/Inner/LeadDetail";
import {useRoute, useRouter} from "vue-router";
import {useI18n} from "vue-i18n";
import {useMeta} from "vue-meta";

const props = defineProps({
    data: {
        required: true,
        type: Object,
    }
});

const router = useRouter();
const routes = useRoute();
const {t: $t} = useI18n();
useMeta({title: $t('Lead Management')});

const leadId = routes.params.id;
let editLeadModal = ref(false);
let editSalesperson = ref(false);
let editLeadStatus = ref(false);
let contractModal = ref(false);
const dropzoneUploader = ref(null);

const lead = ref(null);

const form = ref({
    salesperson_id: null,
    lead_status_id: '',
});

lead.value = props.data.value;
updateFormData(props.data.value);

let salespersons = await useSalespersonsStore().getSalespersonsByRefresh();
const leadStatus = await useLeadStatusStore().getLeadStatusByRefresh();

async function getLeadData() {
    await axios.get(route('admin.leads.show', {id: leadId}))
        .then((response) => {
            if (response.status === 200) {
                lead.value = response.data;
                updateFormData(lead.value);
            }
        });
}

function updateFormData(lead) {
    form.value.status = lead.status;
    form.value.salesperson_id = lead.salesperson_id;
}

function isConverted() {
    return lead.value.is_converted;
}

function openEditLeadModal() {
    editLeadModal.value = true;
    BtModalHelper.open();
}

function closeEditLeadModal() {
    editLeadModal.value = false;
    BtModalHelper.close();
}

function openEditSalesperson() {
    editSalesperson.value = true;
}

function closeEditSalesperson() {
    editSalesperson.value = false;
}

function openEditLeadStatus() {
    editLeadStatus.value = true;
}

function closeEditLeadStatus() {
    editLeadStatus.value = false;
}


function openContractModal() {
    contractModal.value = true;
}

function closeContractModal() {
    contractModal.value = false;
}


function convertToCustomer() {
    axios.post(route('admin.leads.approve_new_customer'), { lead_id: lead.value.id })
        .then(async (response) => {
            if (response.status === 200) {
                Notifier.toastSuccess(response.data.message);
                await getLeadData();
            }
        });
}

function updateSalesperson(salespersonId) {

    if (salespersonId === null) {
        salespersonId = 0;
    }

    axios.post(route('admin.leads.update_salesperson'), {
        salesperson_id: salespersonId,
        lead_id: leadId
    })
        .then(async (response) => {
            if (response.status === 200) {
                Notifier.toastSuccess(response.data.message);
                await getLeadData();
                closeEditSalesperson();
            }
        });
}

function changeLeadStatus(leadStatus) {

    axios.post(route('admin.leads.change_status'), {
        lead_status_id: leadStatus,
        lead_id: leadId
    })
        .then(async (response) => {
            if (response.status === 200) {
                Notifier.toastSuccess(response.data.message);
                await getLeadData();
                closeEditLeadStatus();
            }
        });
}

function goToCustomer() {
    return router.push('/admin/customers/' + lead.value.converted_to);
}

function hasConversionRequest() {
    return lead.value.has_conversion_request;
}


onMounted(() => {

});

</script>