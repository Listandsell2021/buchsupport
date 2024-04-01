<template>
    <div>

        <Breadcrumbs :menu-items="breadcrumbConfig.customer.list()" :title="$t('Customer List')"/>

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
                <router-link to="customers/create" class="btn btn-primary pull-right">
                    <i class="fa fa-plus"></i> {{ $t('Create New') }}
                </router-link>
                <router-link to="customers/pipeline" class="btn btn-primary pull-right m-r-15">
                    {{ $t('Pipeline') }}
                </router-link>
            </div>

            <div class="card">
                <div class="card-body">
                        <div class="table-responsive table-alt-responsive">
                            <table class="table table-striped table-alt">
                                <thead>
                                <Sorting :columns="form.columns"
                                         @column_changed="getCustomerList"
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
                                    <template v-if="hasCustomers()">
                                        <template v-for="(customer, index) in customers.data"
                                                  :key="PasswordGenerator.generate()"
                                        >
                                            <tr>
                                                <td>
                                                    <input type="checkbox"
                                                           class="checkbox_animated"
                                                           v-model="form.selection.data_ids"
                                                           :value="customer.id"
                                                    />
                                                </td>
                                                <td>
                                                    <a href="#" @click.prevent="goToEditCustomer(customer.id)">
                                                        {{ customer.uid }}
                                                    </a>
                                                </td>
                                                <td>{{ customer.first_name }} {{ customer.last_name }}</td>
                                                <td>{{ HelperUtils.truncate(customer.street, 25, '..') }}</td>
                                                <td>{{ customer.postal_code }}</td>
                                                <td>{{ customer.city }}</td>
                                                <td>{{ customer.dob }}</td>
                                                <td>{{ customer.registered_at }}</td>
                                                <td>
                                                    {{ customer.products_count }}
                                                    <a v-if="hasProducts(customer.products_count)"
                                                       @click.prevent="toggleShowProduct(customer.id)"
                                                       class="m-l-10"
                                                       href="#"
                                                    >{{ $t('View') }}</a>
                                                </td>
                                                <td class="switcher-col">
                                                    <StatusSwitcher :is_active="customer.is_active"
                                                                    @toggle="changeActiveStatus(customer.id, $event)"
                                                    ></StatusSwitcher>
                                                </td>
                                                <td>
                                                    <button class="btn btn-success btn-xs"
                                                            @click="goToEditCustomer(customer.id)"
                                                            v-tooltip="$t('Edit Customer')"
                                                    >
                                                        <i class="fa fa-edit"></i>
                                                    </button>

                                                    <button class="btn btn-danger btn-xs ms-1"
                                                            @click.prevent="deleteCustomer(customer.id, customer.first_name + ' '+ customer.last_name)"
                                                            v-tooltip="$t('Delete Customer')"
                                                    >
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </td>
                                            </tr>
                                            <Transition>
                                                <tr v-if="selectedCustomerId === customer.id && customerProducts.length > 0">
                                                    <td colspan="11">
                                                        <div class="row">
                                                            <div class="col-md-8">
                                                                <ul class="list-group">
                                                                    <VueDraggableNext
                                                                        v-model="customerProducts"
                                                                        group="people"
                                                                        @change="sortProducts(customer.id, customerProducts)"
                                                                    >
                                                                        <li class="list-group-item draggable-item"
                                                                            :key="product.product_id"
                                                                            v-for="(product, index) in customerProducts"
                                                                        >
                                                                            <div class="clearfix">
                                                                        <span class="pull-left">
                                                                            <span class="product-id-text ">
                                                                                #{{ product.product_id }}
                                                                            </span>
                                                                            {{ product.name }}
                                                                        </span>
                                                                                <span class="pull-right">
                                                                            &euro; {{ product.price }}
                                                                        </span>
                                                                            </div>
                                                                        </li>
                                                                    </VueDraggableNext>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </td>
                                                </tr>
                                            </Transition>
                                        </template>
                                    </template>
                                    <template v-else>
                                        <tr>
                                            <td colspan="9">
                                                <div class="alert alert-danger alert-t-box">
                                                    {{ $t('No customers found') }}
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
                        :data="customers"
                        @change="getCustomerList"
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
import HelperUtils from "@/libraries/utils/helpers/HelperUtils";
import PasswordGenerator from "@/libraries/utils/helpers/PasswordGenerator";
import StatusSwitcher from "@/components/widgets/form/StatusSwitcher";
import PaginationSetting from "@/storage/data/paginationSetting";
import IdFilter from "@/components/admin/Customer/Filters/IdFilter";
import NameFilter from "@/components/admin/Customer/Filters/NameFilter";
import StreetFilter from "@/components/admin/Customer/Filters/StreetFilter";
import PostalCodeFilter from "@/components/admin/Customer/Filters/PostalCodeFilter";
import CityFilter from "@/components/admin/Customer/Filters/CityFilter";
import IsActiveFilter from "@/components/admin/Customer/Filters/IsActiveFilter";
import ProductFilter from "@/components/admin/Customer/Filters/ProductFilter";
import { VueDraggableNext } from 'vue-draggable-next';
import {useRouter} from "vue-router";
import {useI18n} from "vue-i18n";
import __Has from "lodash/has";
import {useMeta} from "vue-meta";


const router = useRouter();
const { t: $t } = useI18n();
useMeta({title: $t('Customer List')});

const IdFilterComponent = shallowRef(IdFilter);
const NameFilterComponent = shallowRef(NameFilter);
const StreetFilterComponent = shallowRef(StreetFilter);
const PostalCodeFilterComponent = shallowRef(PostalCodeFilter);
const CityFilterComponent = shallowRef(CityFilter);
const IsActiveFilterComponent = shallowRef(IsActiveFilter);
const ProductFilterComponent = shallowRef(ProductFilter);

const form = ref({
    page: 1,
    per_page: PaginationSetting.per_page,
    selection: {
        all: false,
        data_ids: [],
        action: '',
    },
    filters: {
        uid: '',
        name: '',
        street: '',
        postal_code_start: '',
        postal_code_end: '',
        gender: '',
        city: '',
        is_active: '',
        product_ids: [],
    },
    columns: [
        {
            name: 'ID',
            key: 'customers.uid',
            sort: 'none',
            component: IdFilterComponent,
        },
        {
            name: 'Name',
            key: 'customers.first_name',
            sort: 'none',
            component: NameFilterComponent,
        },
        {
            name: 'Address',
            key: 'customers.street',
            sort: 'none',
            component: StreetFilterComponent
        },
        {
            name: 'Postal',
            key: 'customers.postal_code',
            sort: 'none',
            component: PostalCodeFilterComponent
        },
        {
            name: 'City',
            key: 'customers.city',
            sort: 'none',
            component: CityFilterComponent
        },
        {
            name: 'DOB',
            key: 'customers.dob',
            sort: 'none',
        },
        {
            name: 'Registered At',
            key: 'customers.registered_at',
            sort: 'none',
        },
        {
            name: 'Products',
            key: 'customers.products_count',
            sort: 'none',
            component: ProductFilterComponent,
        },
        {
            name: 'Status',
            key: 'customers.is_active',
            sort: 'none',
            component: IsActiveFilterComponent
        }
    ]
});

const customers = ref({});
let selectedCustomerId = ref(0);
let customerProducts = ref([]);

const getCustomerList = async (page = 1, per_page = 0) => {

    setPageNumber(page, per_page);

    await axios.get(route('admin.customers.index'), form.value, {}, true).then(response => {
        customers.value = response.data.data;
    });
}

function hasCustomers() {
    return __Has(customers.value, 'data') ? (customers.value.data.length > 0) : customers.value;
}

function hasProducts(totalProduct)
{
    return totalProduct > 0;
}

function toggleShowProduct(customerId) {

    if (selectedCustomerId.value === customerId) {
        selectedCustomerId.value = 0;
        return;
    }

    selectedCustomerId.value = customerId;

    getProductsByCustomer(customerId);
}

function getProductsByCustomer(customerId)
{
    axios.post(route('admin.customers.products'), {
        user_id: customerId,
    })
        .then(response => {
            if (response.status === 200) {
                customerProducts.value = response.data.data;
            }
        });
}

function sortProducts(customerId, products) {
    axios.post(route('admin.customers.sort_products'), {
        user_id: customerId,
        user_product_ids: getUserProductIds(products),
    })
        .then((response) => {
            if (response.status === 200) {
                Notifier.toastSuccess(response.data.message);
            }
        });
}

function getUserProductIds(products) {
    return products.map((product) => {
        return product.user_product_id;
    });
}

function goToEditCustomer(adminId) {
    return router.push('customers/' + adminId);
}

function deleteCustomer(customerId, customerName) {
    Notifier.toastConfirm($t('Delete Customer'), $t('Do you want to delete this customer "{name}"?', {name: customerName}), () => {
        axios.delete(route('admin.customers.destroy', {id: customerId}))
            .then((response) => {
                Notifier.toastSuccess(response.data.message);
                getCustomerList();
            });
    });
}

function changeActiveStatus(customerId, isActive) {
    axios.post(route('admin.customers.change_status'), {
        user_id: customerId,
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
        getCustomerList();
    }
}

function isDataSelected() {
    return form.value.selection.data_ids.length > 0;
}

function selectAll() {
    if (form.value.selection.all) {
        form.value.selection.data_ids = customers.value.data.map(data => data.id)
    } else {
        form.value.selection.data_ids = [];
    }
}

function submitBulkAction() {
    Notifier.toastConfirm($t('Do you want to perform bulk action?'), '', () => {
        axios.post(route('admin.customers.bulk_action'), {
            data_ids: form.value.selection.data_ids,
            action: form.value.selection.action,
        }).then((response) => {
            if (response.status === 200) {
                form.value.selection = {action: '', data_ids: [], all: false};
                getCustomerList();
                Notifier.toastSuccess(response.data.message);
            }
        });
    });
}

onMounted(async () => {
    await getCustomerList();
})

</script>