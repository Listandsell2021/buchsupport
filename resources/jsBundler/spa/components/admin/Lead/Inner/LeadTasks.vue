<template>

    <div>
        <Transition>
            <AddLeadTaskModal
                @close="closeAddTaskModal"
                @reload="getLeadTaskList(1, false)"
                v-if="addTaskModal"
                :lead-id="props.leadId"
            ></AddLeadTaskModal>
        </Transition>

        <Transition>
            <EditLeadTaskModal
                @close="closeEditLeadTask"
                @reload="getLeadTaskList(1, false)"
                v-if="editTaskModal"
                :lead-task="editTask"
            ></EditLeadTaskModal>
        </Transition>

        <div class="lead-detail-box">
            <div class="lbd-header clearfix">
                <h4 class="ldb-title pull-left">{{ $t('Tasks') }}</h4>
                <button class="btn btn-primary btn-xs pull-right"
                        @click.prevent="openAddTaskModal"
                        v-if="!isConverted()"
                >
                    <i class="fa fa-plus"></i>
                </button>
            </div>
            <div class="ldb-body">

                <template v-if="hasLeadTasks()">
                    <div class="ldb-item" v-for="leadTask in leadTasks.data">
                        <div class="ldb-appointment-item">
                            <div v-html="HelperUtils.truncate(leadTask.description, 80)"></div>
                            <div class="clearfix">
                            <span class="ldb-appointment-date pull-left">
                                <strong class="m-r-5">{{ leadTask.created_by }}</strong>
                                {{ HelperUtils.getDateTimeInGerman(leadTask.due_at) }}
                            </span>
                                <div class="pull-right" v-if="!isConverted()">
                                    <a href="#" class="btn btn-primary btn-xs"
                                       @click.prevent="openEditLeadTask(leadTask)"
                                    >
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-danger btn-xs m-l-5"
                                       @click.prevent="deleteLeadTask(leadTask.id)"
                                    >
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </template>
                <template v-else>
                    <div class="alert alert-danger">{{ $t('No lead task') }}</div>
                </template>

            </div>

            <div class="m-t-30 text-center">
                <Bootstrap5Pagination :data="leadTasks"
                                      class="pagination-sm"
                                      @pagination-change-page="getLeadTaskList"
                                      :limit="3"
                ></Bootstrap5Pagination>
            </div>

        </div>


    </div>


</template>

<script setup>
import {onMounted, ref} from "vue";
import AddLeadTaskModal from "@/components/admin/Lead/Inner/AddLeadTaskModal";
import EditLeadTaskModal from "@/components/admin/Lead/Inner/EditLeadTaskModal";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import BtModalHelper from "@/libraries/utils/BtModalHelper";
import HelperUtils from "@/libraries/utils/helpers/HelperUtils";
import Notifier from "@/libraries/utils/Notifier";
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
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

const leadTasks = ref({
    data: [],
});
const addTaskModal = ref(false);
const editTaskModal = ref(false);
const editTask = ref(null);

const form = ref({
    page: 1,
    lead_id: props.leadId,
});

function openAddTaskModal() {
    addTaskModal.value = true;
    BtModalHelper.open();
}

function closeAddTaskModal() {
    addTaskModal.value = false;
    BtModalHelper.close();
}

function openEditLeadTask(appointment) {
    editTask.value = appointment;
    editTaskModal.value = true;
    BtModalHelper.open();
}

function closeEditLeadTask() {
    editTask.value = null;
    editTaskModal.value = false;
    BtModalHelper.close();
}

function deleteLeadTask(taskId) {
    Notifier.toastConfirm($t('Delete Lead Task'), $t('Do you want to delete this task?'), () => {
        axios.post(route('admin.lead.task.destroy'), { task_id: taskId})
            .then((response) => {
                Notifier.toastSuccess(response.data.message);
                getLeadTaskList();
            });
    }, $t('Yes'), $t('No'));
}

async function getLeadTaskList(page = 1, setPage = true) {

    if (setPage) {
        setPageNumber(page);
    }

    await axios.post(route('admin.lead.task.list'), form.value)
        .then((response) => {
            if (response.status === 200) {
                leadTasks.value = response.data.data;
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

function hasLeadTasks() {
    return leadTasks.value.data.length > 0;
}

function isConverted() {
    return props.lead.is_converted;
}

onMounted(async () => {
    await getLeadTaskList();
})

</script>

<style scoped lang="scss">

</style>
