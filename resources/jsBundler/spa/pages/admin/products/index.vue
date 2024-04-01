<template>
    <div>

        <Breadcrumbs :menu-items="breadcrumbConfig.product.list()" :title="$t('Product List')"/>

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
            <router-link to="products/create" class="btn btn-primary pull-right">
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
                                     @column_changed="getProductsList"
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
                            <template v-if="hasProducts()">
                                <tr v-for="(product) in products.data"
                                    :key="PasswordGenerator.generate()"
                                >
                                    <td>
                                        <input type="checkbox"
                                               class="checkbox_animated"
                                               v-model="form.selection.data_ids"
                                               :value="product.id"
                                        />
                                    </td>
                                    <td>{{ product.category_name }}</td>
                                    <td>{{ product.name }}</td>
                                    <td>
                                        <button class="btn btn-success btn-xs"
                                                @click="goToEditAdmin(product.id)"
                                                v-tooltip="$t('Edit Product')"
                                        >
                                            <i class="fa fa-edit"></i>
                                        </button>

                                        <button class="btn btn-danger btn-xs ms-1"
                                                @click.prevent="deleteProduct(product.id, product.name)"
                                                v-tooltip="$t('Delete Product ')"
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
                                            {{ $t('No Products found') }}
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
                        :data="products"
                        @change="getProductsList"
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
import CategoryFilter from "@/components/admin/Product/Filters/CategoryFilter";
import __Has from "lodash/has";
import {useRouter} from "vue-router";
import {useI18n} from "vue-i18n";
import PasswordGenerator from "@/libraries/utils/helpers/PasswordGenerator";
import {useMeta} from "vue-meta";


const router = useRouter();
const { t: $t } = useI18n();
useMeta({title: $t('Product List')});

const NameFilterComponent = shallowRef(NameFilter);
const CategoryFilterComponent = shallowRef(CategoryFilter);
const form = ref({
    page: 1,
    per_page: PaginationSetting.per_page,
    filters: {
        name: '',
        category_id: '',
    },
    selection: {
        all: false,
        data_ids: [],
        action: '',
    },
    columns: [
        {
            name: 'Category',
            key: 'product_categories.name',
            sort: 'none',
            component: CategoryFilterComponent
        },
        {
            name: 'Name',
            key: 'products.name',
            sort: 'none',
            component: NameFilterComponent
        }
    ]
});

const products = ref({});

const getProductsList = async (page = 1, per_page = 0) => {

    setPageNumber(page, per_page);

    await axios.get(route('admin.products.index'), form.value, {}, true).then(response => {
        products.value = response.data.data;
    });
}

function hasProducts() {
    return __has(products.value, 'data') ? (products.value.data.length > 0) : products.value;
}

let debounceController = null;

const filterCategoryList = () => {
    clearTimeout(debounceController);
    debounceController = setTimeout(() => {
        getProductsList();
    }, 500);
}

function goToEditAdmin(adminId) {
    return router.push('products/' + adminId);
}

function deleteProduct(productId, productName) {
    Notifier.toastConfirm($t('Delete Product'), $t('Do you want to delete this product "{name}"?', {name: productName}),
        () => {
            axios.delete(route('admin.products.destroy', {id: productId}))
            .then((response) => {
                Notifier.toastSuccess(response.data.message);
                getProductsList();
            });
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
        getProductsList();
    }
}

function isDataSelected() {
    return form.value.selection.data_ids.length > 0;
}

function selectAll() {
    if (form.value.selection.all) {
        form.value.selection.data_ids = products.value.data.map(data => data.id)
    } else {
        form.value.selection.data_ids = [];
    }
}

function submitBulkAction() {
    Notifier.toastConfirm($t('Do you want to perform bulk action?'), '', () => {
        axios.post(route('admin.products.bulk_action'), {
            data_ids: form.value.selection.data_ids,
            action: form.value.selection.action,
        }).then((response) => {
            if (response.status === 200) {
                form.value.selection = {action: '', data_ids: [], all: false};
                getProductsList();
                Notifier.toastSuccess(response.data.message);
            }
        });
    });
}



onMounted(async () => {
    await getProductsList();
})

</script>