<template>
    <div>
        <Breadcrumbs :menu-items="breadcrumbConfig.order.view(orderId)" :title="$t('Order')+' #'+orderId"/>

        <div class="container-fluid">
            <div class="card">
                <div class="card-body">

                    <OrderStage :stages="order.stages" :service-id="order.service_id"></OrderStage>

                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <td>{{ $t("Customer") }}</td>
                            <td><ClickableCustomer :user="order.user"></ClickableCustomer></td>
                        </tr>
                        <tr v-if="order.lead">
                            <td>{{ $t("Lead") }}</td>
                            <td>{{ order.lead.first_name+" "+order.lead.last_name }}</td>
                        </tr>
                        <tr>
                            <td>{{ $t("Service") }}</td>
                            <td>{{ order.service.name  }}</td>
                        </tr>
                        <tr>
                            <td>{{ $t("Status") }}</td>
                            <td>{{ order.pipeline.name  }}</td>
                        </tr>
                        <tr>
                            <td>{{ $t('Quantity') }}</td>
                            <td>{{ order.quantity  }}</td>
                        </tr>
                        <tr>
                          <td>{{ $t('Price') }}</td>
                          <td><TextCurrency :amount="order.price"/></td>
                        </tr>
                        <tr>
                          <td>{{ $t('Subtotal') }}</td>
                          <td><TextCurrency :amount="order.subtotal"/></td>
                        </tr>
                        <tr>
                          <td>{{ $t('Tax') }}</td>
                          <td>{{ order.tax }}%</td>
                        </tr>
                        <tr>
                          <td>{{ $t('Tax Price') }}</td>
                          <td><TextCurrency :amount="order.tax_price"/></td>
                        </tr>
                        <tr>
                          <td>{{ $t('Total') }}</td>
                          <td><TextCurrency :amount="order.total"/></td>
                        </tr>
                        <tr>
                            <td>{{ $t('Note') }}</td>
                            <td>{{ order.note  }}</td>
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
                        <tr v-if="order.lead">
                            <td>{{ $t("Salesperson") }}</td>
                            <td>
                                {{ order.lead.salesperson.first_name+" "+order.lead.salesperson.last_name }}
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

let form = ref(null);
let order = ref(null);

order.value = props.data.value;

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

onMounted( () => {

})


</script>