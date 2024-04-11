<template>
    <div>
        <Breadcrumbs :menu-items="breadcrumbConfig.order.list()" :title="$t('Order List')"/>

        <div class="clearfix mb-3">
            <router-link to="orders/create" class="btn btn-primary pull-right">
                <i class="fa fa-plus"></i> {{ $t('Create New') }}
            </router-link>
        </div>

        <div class="card">
            <div class="card-body">
                <div class="">
                    <table class="table">
                        <thead>
                        <Sorting :columns="form.columns"
                                 @column_changed="getOrderList"
                                 @filter="updateFilters"
                        >
                            <template v-slot:sorting_bottom>
                                <th class="fixed-t-right">{{ $t('Action') }}</th>
                            </template>
                        </Sorting>
                        </thead>
                        <tbody>
                        <template v-if="hasOrders()">
                            <tr v-for="(order) in orders.data"
                                :key="order.id"
                            >
                                <td>{{ order.id  }}</td>
                                <td>{{ order.user.first_name+" "+order.user.last_name  }}</td>
                                <td>{{ order.pipeline.name }}</td>
                                <td>{{ HelperUtils.getReadableDate(order.order_at) }}</td>
                                <td><TextCurrency :amount="order.price"/></td>
                                <td>{{ order.service.name }}</td>
                                <td>
                                    <button class="btn btn-success btn-xs"
                                            @click="goToEdit(order.id)"
                                            v-tooltip="$t('View Order')"
                                    >
                                        <i class="fa fa-eye"></i>
                                    </button>
                                    <DeleteBtn :id="order.id"
                                               :url="route('admin.orders.delete', {id: order.id})"
                                               :name="order.user.first_name+' order'"
                                               @updated="getOrderList"
                                    ></DeleteBtn>
                                </td>
                            </tr>
                        </template>
                        <template v-else>
                            <tr>
                                <td colspan="6">
                                    <div class="alert alert-danger alert-t-box">
                                        {{ $t('No orders found') }}
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
                    :data="orders"
                    @change="getOrderList"
                ></PaginationBar>
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
import PaginationSetting from "@/storage/data/paginationSetting";
import NameFilter from "@/components/admin/Service/Filters/NameFilter";
import IsActiveFilter from "@/components/admin/Service/Filters/IsActiveFilter.vue";
import AdvanceStatusSwitcher from "@/components/widgets/form/AdvanceStatusSwitcher.vue";
import PasswordGenerator from "@/libraries/utils/helpers/PasswordGenerator";
import DeleteBtn from "@/components/widgets/form/DeleteBtn.vue";
import {useRouter} from "vue-router";
import {useI18n} from "vue-i18n";
import {useMeta} from "vue-meta";
import __has from 'lodash/has';
import HelperUtils from "../../../libraries/utils/helpers/HelperUtils";
import TextCurrency from "@/components/common/TextCurrency.vue";


const router = useRouter();
const { t: $t } = useI18n();
useMeta({title: $t('Orders List')});

const NameFilterComponent = shallowRef(NameFilter);
const IsActiveFilterComponent = shallowRef(IsActiveFilter);
const form = ref({
    page: 1,
    per_page: PaginationSetting.per_page,
    filters: {
        name: '',
        is_active: '',
    },
    columns: [
        {
            name: 'Order ID',
            key: 'orders.id',
            sort: 'none',
        },
        {
            name: 'Customer',
            key: 'orders.user_id',
            sort: 'none',
            component: NameFilterComponent
        },
        {
            name: 'Status',
            key: 'orders.pipeline_id',
            sort: 'none',
            component: IsActiveFilterComponent
        },
        {
            name: 'Order Date',
            key: 'orders.order_at',
            sort: 'none',
            component: IsActiveFilterComponent
        },
        {
            name: 'Price',
            key: 'orders.price',
            sort: 'none',
            component: IsActiveFilterComponent
        },
        {
            name: 'Service',
            key: 'orders.service_id',
            sort: 'none',
            component: IsActiveFilterComponent
        }
    ]
});

const orders = ref({});

const getOrderList = async (page = 1, per_page = 0) => {

    setPageNumber(page, per_page);

    await axios.get(route('admin.orders.list'), form.value, {}, true).then(response => {
        orders.value = response.data.data;
    });
}

function hasOrders() {
    return __has(orders.value, 'data') ? (orders.value.data.length > 0) : orders.value;
}

let debounceController = null;

const filterCategoryList = () => {
    clearTimeout(debounceController);
    debounceController = setTimeout(() => {
        getOrderList();
    }, 500);
}

function goToEdit(adminId) {
    return router.push('orders/' + adminId);
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
        getOrderList();
    }
}




onMounted(async () => {
    await getOrderList();
})

</script>