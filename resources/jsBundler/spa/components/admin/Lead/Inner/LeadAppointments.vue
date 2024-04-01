<template>

    <div>
        <Transition>
            <AddAppointmentModal
                @close="closeAddAppointmentModal"
                @reload="getAppointmentList(1, false)"
                v-if="addAppointmentModal"
                :lead-id="props.leadId"
            ></AddAppointmentModal>
        </Transition>

        <Transition>
            <EditAppointmentModal
                @close="closeEditAppointment"
                @reload="getAppointmentList(1, false)"
                v-if="editAppointmentModal"
                :appointment="editAppointment"
            ></EditAppointmentModal>
        </Transition>

        <div class="lead-detail-box">
            <div class="lbd-header clearfix">
                <h4 class="ldb-title pull-left">{{ $t('Appointments') }}</h4>
                <button class="btn btn-primary btn-xs pull-right"
                        @click.prevent="openAddAppointmentModal"
                        v-if="!isConverted()"
                >
                    <i class="fa fa-plus"></i>
                </button>
            </div>
            <div class="ldb-body">
                <div class="ldb-item" v-for="appointment in appointments.data">
                    <div class="ldb-appointment-item">
                        <div v-html="HelperUtils.truncate(appointment.description, 80)"></div>
                        <div class="clearfix">
                            <span class="ldb-appointment-date pull-left">
                                <strong class="m-r-5">{{ appointment.created_by }}</strong>
                                {{ HelperUtils.getDateTimeInGerman(appointment.start_at) }}
                            </span>
                            <div class="pull-right" v-if="!isConverted()">
                                <a href="#" class="btn btn-primary btn-xs"
                                   @click.prevent="openEditAppointment(appointment)"
                                >
                                    <i class="fa fa-edit"></i>
                                </a>
                                <a href="#" class="btn btn-danger btn-xs m-l-5"
                                   @click.prevent="deleteAppointment(appointment.id)"
                                >
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="m-t-30 text-center">
                <Bootstrap5Pagination :data="appointments"
                                      class="pagination-sm"
                                      @pagination-change-page="getAppointmentList"
                                      :limit="3"
                ></Bootstrap5Pagination>
            </div>

        </div>


    </div>


</template>

<script setup>
import {onMounted, ref} from "vue";
import AddAppointmentModal from "@/components/admin/Lead/Inner/AddAppointmentModal";
import EditAppointmentModal from "@/components/admin/Lead/Inner/EditAppointmentModal";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import BtModalHelper from "@/libraries/utils/BtModalHelper";
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import HelperUtils from "@/libraries/utils/helpers/HelperUtils";
import Notifier from "@/libraries/utils/Notifier";
import {useI18n} from "vue-i18n";
import {useRouter} from "vue-router";

const emit = defineEmits(['close']);
const props = defineProps({
    leadId: {
        required: true,
    },
    lead: {
        required: true,
    }
});

const { t: $t } = useI18n();
const router = useRouter();

const appointments = ref({});
const addAppointmentModal = ref(false);
const editAppointmentModal = ref(false);
const editAppointment = ref(null);

const form = ref({
    page: 1,
    lead_id: props.leadId,
});

function openAddAppointmentModal() {
    addAppointmentModal.value = true;
    BtModalHelper.open();
}

function closeAddAppointmentModal() {
    addAppointmentModal.value = false;
    BtModalHelper.close();
}

function openEditAppointment(appointment) {
    editAppointment.value = appointment;
    editAppointmentModal.value = true;
    BtModalHelper.open();
}

function closeEditAppointment() {
    editAppointment.value = null;
    editAppointmentModal.value = false;
    BtModalHelper.close();
}

function deleteAppointment(appointmentId) {
    Notifier.toastConfirm($t('Delete Lead Appointment'), $t('Do you want to delete this lead appointment?'), () => {
        axios.post(route('admin.lead.appointment.destroy'), { appointment_id: appointmentId})
            .then((response) => {
                Notifier.toastSuccess(response.data.message);
                getAppointmentList();
            });
    }, $t('Yes'), $t('No'));
}

async function getAppointmentList(page = 1, setPage = true) {

    if (setPage) {
        setPageNumber(page);
    }

    await axios.post(route('admin.lead.appointment.list'), form.value)
        .then((response) => {
            if (response.status === 200) {
                appointments.value = response.data.data;
            }
        });
}

function setPageNumber(page) {
    if (typeof page === 'number') {
        form.value.page = page;
    } else {
        form.value.page = 1;
    }
}

function isConverted() {
    return props.lead.is_converted;
}

onMounted(async () => {
    await getAppointmentList();
})

</script>

<style scoped lang="scss">

</style>
