<template>
    <div>

        <Breadcrumbs :menu-items="breadcrumbConfig.product_category.list()" :title="$t('Product Categories List')"/>

        <div class="container-fluid">

            <div class="clearfix mb-3">
                <div class="pull-left" v-if="isDataSelected()">
                    <div class="btn-group">
                        <select class="form-control"
                                style="width: 200px;"
                                v-model="form.selection.action"
                        >
                            <option value="">{{ $t('Action') }}</option>
                            <option value="active">{{ $t('Active') }}</option>
                            <option value="inactive">{{ $t('Inactive') }}</option>
                            <option value="delete">{{ $t('Delete') }}</option>
                        </select>
                        <button class="btn btn-secondary"
                                @click.prevent="submitBulkAction()"
                        >{{ $t('Submit') }}</button>
                    </div>
                </div>
                <router-link to="product-categories/create" class="btn btn-primary pull-right">
                    <i class="fa fa-plus"></i> {{ $t('Create New') }}
                </router-link>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="">
                        <table class="table">
                            <thead>
                            <Sorting :columns="form.columns"
                                     @column_changed="getProductCategoriesList"
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
                            <template v-if="hasCategories()">
                                <tr v-for="(productCategory) in productCategories.data"
                                    :key="PasswordGenerator.generate()"
                                >
                                    <td>
                                        <input type="checkbox"
                                               class="checkbox_animated"
                                               v-model="form.selection.data_ids"
                                               :value="productCategory.id"
                                        />
                                    </td>
                                    <td>{{ productCategory.name }}</td>
                                    <td class="switcher-col">
                                        <StatusSwitcher :is_active="productCategory.is_active"
                                                        @toggle="changeActiveStatus(productCategory.id, $event)"
                                        ></StatusSwitcher>
                                    </td>
                                    <td>
                                        <button class="btn btn-success btn-xs"
                                                @click="goToEditAdmin(productCategory.id)"
                                                v-tooltip="$t('Edit Product Category')"
                                        >
                                            <i class="fa fa-edit"></i>
                                        </button>

                                        <button class="btn btn-danger btn-xs ms-1"
                                                @click.prevent="deleteProductCategory(productCategory.id, productCategory.name)"
                                                v-tooltip="$t('Delete Product Category')"
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
                                            {{ $t('No Product Categories found') }}
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
                        :data="productCategories"
                        @change="getProductCategoriesList"
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
import StatusSwitcher from "@/components/widgets/form/StatusSwitcher";
import PaginationSetting from "@/storage/data/paginationSetting";
import __has from 'lodash/has';
import NameFilter from "@/components/admin/ProductCategory/Filters/NameFilter";
import IsActiveFilter from "@/components/admin/ProductCategory/Filters/IsActiveFilter";
import __Has from "lodash/has";
import {useRouter} from "vue-router";
import {useI18n} from "vue-i18n";
import PasswordGenerator from "@/libraries/utils/helpers/PasswordGenerator";
import {useMeta} from "vue-meta";


const router = useRouter();
const { t: $t } = useI18n();
useMeta({title: $t('Product Categories List')});

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
            key: 'name',
            sort: 'none',
            component: NameFilterComponent
        },
        {
            name: 'Status',
            key: 'is_active',
            sort: 'none',
            component: IsActiveFilterComponent
        }
    ]
});


const productCategories = ref({});

const getProductCategoriesList = async (page = 1, per_page = 0) => {

    setPageNumber(page, per_page);

    await axios.get(route('admin.product_categories.index'), form.value, {}, true).then(response => {
        productCategories.value = response.data.data;
    });
}

function hasCategories() {
    return __has(productCategories.value, 'data') ? (productCategories.value.data.length > 0) : productCategories.value;
}

let debounceController = null;

const filterSalespersonList = () => {
    clearTimeout(debounceController);
    debounceController = setTimeout(() => {
        getProductCategoriesList();
    }, 500);
}

function goToEditAdmin(adminId) {
    return router.push('product-categories/' + adminId);
}

function deleteProductCategory(categoryId, categoryName) {
    Notifier.toastConfirm($t('Delete Category'), $t('Do you want to delete this category "{name}"?', {name: categoryName}), () => {
        axios.delete(route('admin.product_categories.destroy', {id: categoryId}))
            .then((response) => {
                Notifier.toastSuccess(response.data.message);
                getProductCategoriesList();
            });
    });
}

function changeActiveStatus(categoryId, isActive) {
    axios.post(route('admin.product_categories.change_status'), {
        category_id: categoryId,
        is_active: isActive,
    }).then((response) => {
        if (response.status === 200) {
            Notifier.toastSuccess(response.data.message);
        }
    });
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
        getProductCategoriesList();
    }

}

function isDataSelected() {
    return form.value.selection.data_ids.length > 0;
}

function selectAll() {
    if (form.value.selection.all) {
        form.value.selection.data_ids = productCategories.value.data.map(data => data.id)
    } else {
        form.value.selection.data_ids = [];
    }
}

function submitBulkAction() {
    Notifier.toastConfirm($t('Do you want to perform bulk action?'), '', () => {
        axios.post(route('admin.product_categories.bulk_action'), {
            data_ids: form.value.selection.data_ids,
            action: form.value.selection.action,
        }).then((response) => {
            if (response.status === 200) {
                form.value.selection = {action: '', data_ids: [], all: false};
                getProductCategoriesList();
                Notifier.toastSuccess(response.data.message);
            }
        });
    });
}

onMounted(async () => {
    await getProductCategoriesList();
})

</script>