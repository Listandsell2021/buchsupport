<template>
    <div class="service-status-listing">

        <AddPipeline v-if="addPipeline"
                     :service-id="serviceId"
                     @refresh="getPipelinesList"
                     @close="closeAddPipeline"
        ></AddPipeline>

        <EditPipeline v-if="editPipeline"
                     :pipeline="selectedPipeline"
                     @refresh="getPipelinesList"
                     @close="closeEditPipeline"
        ></EditPipeline>

        <div class="clearfix mb-3">
            <h5 class="pull-left">{{ $t("Pipelines") }}</h5>
            <a href="#"
               @click.prevent="openAddPipeline"
               class="btn btn-primary btn-xs pull-right"
            >
                <i class="fa fa-plus"></i> {{ $t('Create New') }}
            </a>
        </div>

        <table class="table">
            <thead>
            <Sorting :columns="form.columns"
                     @column_changed="getPipelinesList"
                     @filter="updateFilters"
            >
                <template v-slot:sorting_bottom>
                    <th class="fixed-t-right">{{ $t('Action') }}</th>
                </template>
            </Sorting>
            </thead>
            <tbody>
            <template v-if="hasPipelines()">
                <tr v-for="(pipeline) in pipelines.data"
                    :key="pipeline.id+pipeline.default"
                >
                    <td>{{ pipeline.name }}</td>
                    <td>
                        <AdvanceStatusSwitcher :url="route('admin.services.change_default')"
                                               :model_id="pipeline.id"
                                               :is_active="pipeline.default"
                                               @changed="getPipelinesList"
                        ></AdvanceStatusSwitcher>
                    </td>
                    <td>
                        <button class="btn btn-success btn-xs"
                                v-tooltip="$t('Edit Status')"
                                @click="openEditPipeline(pipeline)"
                        >
                            <i class="fa fa-edit"></i>
                        </button>

                        <DeleteBtn :id="pipeline.id"
                                   :url="route('admin.service_pipeline.destroy', {id: pipeline.id})"
                                   :name="pipeline.name"
                                   @updated="getPipelinesList"
                        ></DeleteBtn>
                    </td>
                </tr>
            </template>
            <template v-else>
                <tr>
                    <td colspan="4">
                        <div class="alert alert-danger alert-t-box">
                            {{ $t('No service status found') }}
                        </div>
                    </td>
                </tr>
            </template>
            </tbody>
        </table>

        <div class="m-4">
            <PaginationBar
                :data="pipelines"
                @change="getPipelinesList"
            ></PaginationBar>
        </div>

    </div>
</template>
<script setup>
import {onMounted, ref, shallowRef} from "vue";
import axios from '@/libraries/utils/clientapi/axios';
import PaginationBar from "@/components/widgets/form/PaginationBar"
import Sorting from '@/components/common/Sorting';
import route from '@/libraries/utils/ZiggyRoute';
import PaginationSetting from "@/storage/data/paginationSetting";
import DeleteBtn from "@/components/widgets/form/DeleteBtn.vue";
import {useRouter} from "vue-router";
import {useI18n} from "vue-i18n";
import __has from 'lodash/has';
import AddPipeline from "@/components/admin/ServiceStatus/AddPipeline.vue";
import BtModalHelper from "@/libraries/utils/BtModalHelper";
import EditPipeline from "@/components/admin/ServiceStatus/EditPipeline.vue";
import AdvanceStatusSwitcher from "@/components/widgets/form/AdvanceStatusSwitcher.vue";


const props = defineProps({
    serviceId: {
        required: true,
    }
});

const router = useRouter();
const { t: $t } = useI18n();

const form = ref({
    page: 1,
    per_page: PaginationSetting.per_page,
    filters: {
        name: '',
        is_active: '',
    },
    columns: [
        {
            name: 'Name',
            key: 'services.name',
            sort: 'none',
        },
        {
            name: 'Is Default',
            key: 'services.default',
            sort: 'none',
        },
    ]
});

const pipelines = ref({});
const addPipeline = ref(false);
const editPipeline = ref(false);
const selectedPipeline = ref(null);

const getPipelinesList = async (page = 1, per_page = 0) => {

    setPageNumber(page, per_page);

    await axios.get(route('admin.service_pipeline.index', {service: props.serviceId}), form.value, {}, true)
        .then(response => {
        pipelines.value = response.data.data;
    });
}

function hasPipelines() {
    return __has(pipelines.value, 'data') ? (pipelines.value.data.length > 0) : pipelines.value;
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

function updateFilters(filters) {

    let hasFilter = false;

    for (let filterName in filters) {
        if (__has(filters, filterName)) {
            form.value.filters[filterName] = filters[filterName];
            hasFilter = true;
        }
    }

    if (hasFilter) {
        getPipelinesList();
    }
}


function openAddPipeline() {
    addPipeline.value = true;
    BtModalHelper.open();
}

function closeAddPipeline() {
    addPipeline.value = false;
    BtModalHelper.close();
}

function openEditPipeline(pipeline) {
    selectedPipeline.value = pipeline;
    editPipeline.value = true;
    BtModalHelper.open();
}

function closeEditPipeline() {
    editPipeline.value = false;
    BtModalHelper.close();
}



onMounted(async () => {
    await getPipelinesList();
})

</script>