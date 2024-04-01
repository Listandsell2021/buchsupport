<template>
    <div>
        <Breadcrumbs :menu-items="breadcrumbConfig.service.list()" :title="$t('Service List')"/>

        <div class="clearfix mb-3">
            <div class="pull-left" v-if="isDataSelected()">
                <div class="btn-group">
                    <select class="form-control"
                            style="width: 200px;"
                            v-model="form.selection.action"
                    >
                        <option value="">{{ $t('Action') }}</option>
                        <option value="delete">{{ $t('Delete') }}</option>
                    </select>
                    <button class="btn btn-secondary"
                            @click.prevent="submitBulkAction()"
                    >{{ $t('Submit') }}</button>
                </div>
            </div>
            <router-link to="services/create" class="btn btn-primary pull-right">
                <i class="fa fa-plus"></i> {{ $t('Create New') }}
            </router-link>
        </div>

        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="">
                        <table class="table">
                            <thead>
                            <Sorting :columns="form.columns"
                                     @column_changed="getServicesList"
                                     @filter="updateFilters"
                            >
                                <template v-slot:sorting_top>
                                    <th class="col-select-all">
                                        <input type="checkbox"
                                               class="checkbox_animated"
                                               v-model="form.selection.all"
                                               @change="selectAll()"
                                        />
                                    </th>
                                </template>
                                <template v-slot:sorting_bottom>
                                    <th class="fixed-t-right">{{ $t('Action') }}</th>
                                </template>
                            </Sorting>
                            </thead>
                            <tbody>
                            <template v-if="hasServices()">
                                <tr v-for="(service) in services.data"
                                    :key="PasswordGenerator.generate()"
                                >
                                    <td>
                                        <input type="checkbox"
                                               class="checkbox_animated"
                                               v-model="form.selection.data_ids"
                                               :value="service.id"
                                        />
                                    </td>
                                    <td>{{ service.name }}</td>
                                    <td>
                                        <AdvanceStatusSwitcher :is_active="service.is_active"
                                                               :url="route('admin.services.change_status')"
                                                               :model_id="service.id"
                                                               @changed="getServicesList"
                                        ></AdvanceStatusSwitcher>
                                    </td>
                                    <td>
                                        <button class="btn btn-success btn-xs"
                                                @click="goToEditAdmin(service.id)"
                                                v-tooltip="$t('Edit Service')"
                                        >
                                            <i class="fa fa-edit"></i>
                                        </button>

                                        <DeleteBtn :id="service.id"
                                                   :url="route('admin.services.destroy', {id: service.id})"
                                                   :name="service.name"
                                                   @updated="getServicesList"
                                        ></DeleteBtn>
                                    </td>
                                </tr>
                            </template>
                            <template v-else>
                                <tr>
                                    <td colspan="4">
                                        <div class="alert alert-danger alert-t-box">
                                            {{ $t('No services found') }}
                                        </div>
                                    </td>
                                </tr>
                            </template>
                            </tbody>
                        </table>
                    </div>

                </div>

                <div class="m-4">
                    <PaginationBar
                        :data="services"
                        @change="getServicesList"
                    ></PaginationBar>
                </div>

            </div>
        </div>
    </div>
</template>
<script setup>


import {onMounted, ref, shallowRef} from "vue";
import axios from '@/libraries/utils/clientapi/axios';
import PaginationBar from "@/components/widgets/form/PaginationBar"
import breadcrumbConfig from "@/storage/data/breadcrumbs";
import Sorting from '@/components/common/Sorting';
import route from '@/libraries/utils/ZiggyRoute';
import Notifier from "@/libraries/utils/Notifier";

import __has from 'lodash/has';
import PaginationSetting from "@/storage/data/paginationSetting";
import NameFilter from "@/components/admin/Product/Filters/NameFilter";
import IsActiveFilter from "@/components/admin/Product/Filters/IsActiveFilter.vue";
import __Has from "lodash/has";
import {useRouter} from "vue-router";
import {useI18n} from "vue-i18n";
import PasswordGenerator from "@/libraries/utils/helpers/PasswordGenerator";
import {useMeta} from "vue-meta";
import AdvanceStatusSwitcher from "@/components/widgets/form/AdvanceStatusSwitcher.vue";
import DeleteBtn from "@/components/widgets/form/DeleteBtn.vue";


const router = useRouter();
const { t: $t } = useI18n();
useMeta({title: $t('Product List')});

const NameFilterComponent = shallowRef(NameFilter);
const IsActiveFilterComponent = shallowRef(IsActiveFilter);
const form = ref({
    page: 1,
    per_page: PaginationSetting.per_page,
    filters: {
        name: '',
        is_active: '',
    },
    selection: {
        all: false,
        data_ids: [],
        action: '',
    },
    columns: [
        {
            name: 'Name',
            key: 'services.name',
            sort: 'none',
            component: NameFilterComponent
        },
        {
            name: 'Status',
            key: 'services.is_active',
            sort: 'none',
            component: IsActiveFilterComponent
        }
    ]
});

const services = ref({});

const getServicesList = async (page = 1, per_page = 0) => {

    setPageNumber(page, per_page);

    await axios.get(route('admin.services.index'), form.value, {}, true).then(response => {
        services.value = response.data.data;
    });
}

function hasServices() {
    return __has(services.value, 'data') ? (services.value.data.length > 0) : services.value;
}

let debounceController = null;

const filterCategoryList = () => {
    clearTimeout(debounceController);
    debounceController = setTimeout(() => {
        getServicesList();
    }, 500);
}

function goToEditAdmin(adminId) {
    return router.push('services/' + adminId);
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
        if (__Has(filters, filterName)) {
            form.value.filters[filterName] = filters[filterName];
            hasFilter = true;
        }
    }

    if (hasFilter) {
        getServicesList();
    }
}

function isDataSelected() {
    return form.value.selection.data_ids.length > 0;
}

function selectAll() {
    if (form.value.selection.all) {
        form.value.selection.data_ids = services.value.data.map(data => data.id)
    } else {
        form.value.selection.data_ids = [];
    }
}

function submitBulkAction() {
    Notifier.toastConfirm($t('Do you want to perform bulk action?'), '', () => {
        axios.post(route('admin.services.bulk_action'), {
            data_ids: form.value.selection.data_ids,
            action: form.value.selection.action,
        }).then((response) => {
            if (response.status === 200) {
                form.value.selection = {action: '', data_ids: [], all: false};
                getServicesList();
                Notifier.toastSuccess(response.data.message);
            }
        });
    });
}



onMounted(async () => {
    await getServicesList();
})

</script>