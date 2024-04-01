<template>
    <div>

        <AddPipelineModal v-if="addPipelineModal"
                          @close="closeAddPipelineModal"
                          @refresh="closeAddPipelineModalAndRefresh"
        ></AddPipelineModal>

        <AddCustomerToPipelineModal v-if="addCustomerToPipelineModal"
                          @close="closeAddCustomerToPipelineModal"
                          @refresh="closeAddCustomerTOPipelineModalAndRefresh"
        ></AddCustomerToPipelineModal>

        <Breadcrumbs :menu-items="breadcrumbConfig.customer.pipeline()" :title="$t('Customer Pipeline')"/>

        <div class="container-fluid">

            <div class="clearfix mb-3">
                <a href="#"
                   class="btn btn-primary pull-right"
                   @click.prevent="openAddPipelineModal"
                >
                    <i class="fa fa-plus"></i> {{ $t('Add Pipeline') }}
                </a>
                <a href="#"
                   class="btn btn-primary pull-right m-r-15"
                   @click.prevent="openAddCustomerToPipelineModal"
                >
                    <i class="fa fa-plus"></i> {{ $t('Add Customer') }}
                </a>
            </div>

            <div class="card">
                <div class="card-body">

                    <div class="pipeline-container" v-if="true">
                        <div class="pipeline-card">
                            <div class="pipeline-title">
                                {{ $t('Pending Lead') }}
                            </div>
                            <div class="list-group pipeline-group">
                                <div class="list-group-item"
                                     v-for="lead in pendingLeads"
                                     :key="lead.id"
                                >
                                    {{ lead.first_name + ' ' + lead.last_name }}
                                </div>
                            </div>
                        </div>
                        <div class="pipeline-card" v-for="(pipeline, pipelineIndex) in pipelines" :key="pipeline.name">
                            <div class="pipeline-title">
                                {{ pipeline.name }}
                            </div>
                            <VueDraggableNext
                                class="list-group pipeline-group"
                                :list="pipeline.users"
                                group="people"
                                :item-key="'pipeline_'+pipeline.name"
                                @change="sortPipeline(pipelineIndex, pipeline.id, $event)"
                            >
                                <li class="list-group-item draggable-item"
                                    :key="pipeline.name+user.id"
                                    v-for="user in pipeline.users"
                                >
                                    {{ user.first_name }} {{ user.last_name }}
                                </li>
                            </VueDraggableNext>
                        </div>
                    </div>

                    <div class="table-responsive" v-if="false">
                        <table class="table timeline-table">
                            <thead>
                            <tr>
                                <th>{{ $t('Pending Lead') }}</th>
                                <th v-for="pipeline in pipelines" :key="'header_'+pipeline.name"
                                > {{ pipeline.name }}
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>
                                        <div class="list-group pipeline-group">
                                            <div class="list-group-item">Pending</div>
                                        </div>
                                    </td>
                                    <td v-for="(pipeline, pipelineIndex) in pipelines" :key="pipeline.name">
                                        <VueDraggableNext
                                            class="list-group pipeline-group"
                                            :list="pipeline.users"
                                            group="people"
                                            :item-key="'pipeline_'+pipeline.name"
                                            @change="sortPipeline(pipelineIndex, pipeline.id, $event)"
                                        >
                                            <li class="list-group-item draggable-item"
                                                :key="pipeline.name+user.id"
                                                v-for="user in pipeline.users"
                                            >
                                                {{ user.first_name }} {{ user.last_name }}
                                            </li>
                                        </VueDraggableNext>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import {onMounted, ref} from "vue";
import axios from '@/libraries/utils/clientapi/axios';
import breadcrumbConfig from "@/storage/data/breadcrumbs";
import route from '@/libraries/utils/ZiggyRoute';
import Notifier from "@/libraries/utils/Notifier";
import { VueDraggableNext } from 'vue-draggable-next';
import {useRouter} from "vue-router";
import {useI18n} from "vue-i18n";
import {useMeta} from "vue-meta";
import BtModalHelper from "@/libraries/utils/BtModalHelper";
import AddPipelineModal from "@/components/admin/Customer/Pipeline/AddPipelineModal.vue";
import __has from "lodash/has";
import AddCustomerToPipelineModal from "@/components/admin/Customer/Pipeline/AddCustomerToPipelineModal.vue";


const router = useRouter();
const { t: $t } = useI18n();
useMeta({title: $t('Customer Pipeline')});

let addPipelineModal = ref(false);
let addCustomerToPipelineModal = ref(false);
const form = ref({});

const pipelines = ref([]);
const pendingLeads = ref([]);

const getPipelineWithCustomer = async (page = 1, per_page = 0) => {

    await axios.post(route('admin.pipeline.list'), {}, {}, true).then(response => {
        if (response.status === 200) {
            pipelines.value = response.data.data.pipelines;
            pendingLeads.value = response.data.data.pending_leads;
        }
    });
}


function sortPipeline(index, pipelineId, event) {
    if (__has(event, 'added') || __has(event, 'removed')) {
        axios.post(route('admin.pipeline.move'), {
            pipeline_id: pipelineId,
            user_ids: getSortedUserIds(pipelines.value[index]['users']),
        });
    }
    if (__has(event, 'moved')) {
        axios.post(route('admin.pipeline.sort'), {
            event: 'remove',
            pipeline_id: pipelineId,
            user_ids: getSortedUserIds(pipelines.value[index]['users']),
        })
            .then(response => {
                console.log(response);
            });
    }
}

function getSortedUserIds(users) {
    return users.map(user => user.id);
}

function openAddPipelineModal() {
    addPipelineModal.value = true;
    BtModalHelper.open();
}

function closeAddPipelineModal() {
    addPipelineModal.value = false;
    BtModalHelper.close();
}

function closeAddPipelineModalAndRefresh() {
    closeAddPipelineModal();
    getPipelineWithCustomer();
}

function openAddCustomerToPipelineModal() {
    addCustomerToPipelineModal.value = true;
    BtModalHelper.open();
}

function closeAddCustomerToPipelineModal() {
    addCustomerToPipelineModal.value = false;
    BtModalHelper.close();
}

function closeAddCustomerTOPipelineModalAndRefresh() {
    closeAddCustomerToPipelineModal();
    getPipelineWithCustomer();
}

onMounted(async () => {
    await getPipelineWithCustomer();
})

</script>