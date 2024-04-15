<template>
    <div>
        <Breadcrumbs :menu-items="breadcrumbConfig.order.view(orderId)" :title="getTitle()"/>

        <div class="container-fluid">

            <EditOrderModal v-if="editOrderModal"
                            @close="closeEditOrderModal"
                            @refresh="getOrderDetails"
                            :order="order"
            ></EditOrderModal>

            <template v-if="hasConversionInNextStage()">
                <AddLeadCustomerModal :lead="order.lead"
                                      :order-id="order.id"
                                      v-if="createLeadCustomerModal"
                                      @close="closeCreateLeadCustomerModal"
                                      @refresh="getOrderDetails"
                ></AddLeadCustomerModal>
            </template>

            <template v-if="hasTrackingInNextStage()">
                <AddOrderShipmentModal :order-id="order.id"
                                      v-if="updateOrderShipmentModal"
                                      @close="closeUpdateOrderShipmentModal"
                                      @refresh="getOrderDetails"
                ></AddOrderShipmentModal>
            </template>


            <div class="clearfix m-b-20">
                <button class="btn btn-primary btn-sm pull-right"
                        @click.prevent="openEditOrderModal"
                >
                    <i class="fa fa-edit"></i> {{ $t('Edit') }}
                </button>
            </div>

            <div class="card">
                <div class="card-body">

                    <OrderStage :key="orderStageKey" :next-stage="nextStage" :order-id="orderId" :stages="order.stages" :service-id="order.service_id"></OrderStage>

                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <td>{{ $t("Customer") }}</td>
                            <td>
                                <ClickableCustomer :user="order.user"></ClickableCustomer>
                                <button v-if="hasConversionInNextStage()"
                                        @click.prevent="openCreateLeadCustomerModal"
                                        class="btn btn-primary btn-sm m-l-15"
                                ><i class="fa fa-user"></i> {{ $t("Convert to customer") }}</button>
                            </td>
                        </tr>
                        <tr v-if="order.lead">
                            <td>{{ $t("Lead") }}</td>
                            <td>{{ order.lead.first_name+" "+order.lead.last_name }}</td>
                        </tr>
                        <tr>
                            <td>{{ $t("Total") }}</td>
                            <td>
                                <table class="order-detail-table">
                                    <thead>
                                        <tr>
                                            <th>{{ $t('Service') }}</th>
                                            <th>{{ $t('Quantity') }}</th>
                                            <th>{{ $t('Price') }}</th>
                                            <th>{{ $t('Subtotal') }}</th>
                                            <th>{{ $t('Tax') }}</th>
                                            <th>{{ $t('Tax Price') }}</th>
                                            <th>{{ $t('Total') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <tr>
                                        <td>{{ order.service.name  }}</td>
                                        <td>{{ order.quantity  }}</td>
                                        <td><TextCurrency :amount="order.price"/></td>
                                        <td><TextCurrency :amount="order.subtotal"/></td>
                                        <td>{{ order.tax }}%</td>
                                        <td><TextCurrency :amount="order.tax_price"/></td>
                                        <td><TextCurrency :amount="order.total"/></td>
                                    </tr>
                                    </tbody>

                                </table>

                            </td>
                        </tr>
                        <tr>
                            <td>{{ $t('Note') }}</td>
                            <td>{{ order.note  }}</td>
                        </tr>
                        <tr>
                            <td>{{ $t("Shipment no") }}</td>
                            <td>
                                {{ order.shipment_no }}

                                <button v-if="hasTrackingInNextStage()"
                                        @click.prevent="openUpdateOrderShipmentModal"
                                        class="btn shipment-btn btn-primary btn-sm m-l-15"
                                ><i class="fa fa-plus"></i> {{ $t("Add Shipment no") }}</button>
                            </td>
                        </tr>
                        <tr>
                            <td>{{ $t("Order Date") }}</td>
                            <td>{{ HelperUtils.getDateTimeInGerman(order.order_at) }}</td>
                        </tr>
                        <tr>
                            <td>{{ $t('Document') }}</td>
                            <td>
                                <a href="#" @click.prevent="downloadDocument">
                                    <i class="fa fa-file"></i>
                                    {{ order.document  }}
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td>{{ $t("Salesperson") }}</td>
                            <td>
                                {{ order.admin ? (order.admin.first_name+" "+order.admin.last_name) : '-' }}
                            </td>
                        </tr>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import {ref, onMounted} from "vue";
import breadcrumbConfig from "@/storage/data/breadcrumbs";
import {useI18n} from "vue-i18n";
import {useRoute, useRouter} from "vue-router";
import {useMeta} from "vue-meta";
import HelperUtils from "@/libraries/utils/helpers/HelperUtils";
import TextCurrency from "@/components/common/TextCurrency.vue";
import OrderStage from "@/components/admin/Order/OrderStage.vue";
import axios from "@/libraries/utils/clientapi/axios";
import route from "@/libraries/utils/ZiggyRoute";
import ClickableCustomer from "@/components/admin/Customer/ClickableCustomer.vue";
import BtModalHelper from "@/libraries/utils/BtModalHelper";
import AddLeadCustomerModal from "@/components/admin/Order/AddLeadCustomerModal.vue";
import ziggyRoute from "@/libraries/utils/ZiggyRoute";
import AddOrderShipmentModal from "@/components/admin/Order/AddOrderShipmentModal.vue";
import {PipelineStatus} from "@/storage/data/PipelineStatus";
import EditOrderModal from "@/components/admin/Order/EditOrderModal.vue";
import PasswordGenerator from "@/libraries/utils/helpers/PasswordGenerator";

const props = defineProps({
    data: {
        required: true,
        type: Object,
    }
});

const router = useRouter();
const routes = useRoute();
const { t: $t } = useI18n();
useMeta({title: $t('Order View')});

const orderId = routes.params.id;
const form = ref(null);
const order = ref(null);
const nextStage = ref(null);
const createLeadCustomerModal = ref(false);
const updateOrderShipmentModal = ref(false);
const editOrderModal = ref(false);
const orderStageKey = ref(PasswordGenerator.generate());

order.value = props.data.value.order;
nextStage.value = props.data.value.next_stage;

function downloadDocument() {
    axios.postDownload(route('admin.orders.download_contract_doc'), {
        order_id: orderId
    })
        .then((response) => {
            if (response.status === 200) {
                HelperUtils.blobFileDownload(response, order.value.document);
            }
        });
}

function getTitle() {
    return $t('Order')+' #'+orderId + ' <span class="top-service-name">'+order.value.service.name + '</span><span class="top-pipeline-name '+getStatusColor(order.value.status)+'">'+order.value.pipeline.name+(order.value.status ? ' ('+$t(PipelineStatus[order.value.status])+')' : '')+'</span>';
}

function getStatusColor(status) {
    if (!status) {
        return '';
    }
    return status;
}

function hasConversionInNextStage() {
    return !!order.value.lead && !order.value.user_id && nextStage.value && nextStage.value.has_conversion;
}

function hasTrackingInNextStage() {
    return !order.value.shipment_no && nextStage.value && nextStage.value.has_tracking;
}

function openCreateLeadCustomerModal() {
    createLeadCustomerModal.value = true;
    BtModalHelper.open();
}

function closeCreateLeadCustomerModal() {
    createLeadCustomerModal.value = false;
    BtModalHelper.close();
}

function openUpdateOrderShipmentModal() {
    updateOrderShipmentModal.value = true;
    BtModalHelper.open();
}

function closeUpdateOrderShipmentModal() {
    updateOrderShipmentModal.value = false;
    BtModalHelper.close();
}

function openEditOrderModal() {
    editOrderModal.value = true;
    BtModalHelper.open();
}

function closeEditOrderModal() {
    editOrderModal.value = false;
    BtModalHelper.close();
}

function getOrderDetails() {
    axios.get(route('admin.orders.show', {id: orderId}))
        .then((response) => {
            if (response.status == 200) {
                order.value = response.data.order;
                nextStage.value = response.data.next_stage;
                orderStageKey.value = PasswordGenerator.generate();
            }
        });
}

function hasLead() {
    return !!order.value.lead;
}

onMounted( () => {

})


</script>