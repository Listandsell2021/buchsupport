<template>
    <div>
        <Breadcrumbs :menu-items="breadcrumbConfig.order.view(orderId)" :title="$t('View Order')"/>

        <div class="container-fluid">
            <div class="card">
                <div class="card-body">

                    <table class="table table-striped">
                        <tbody>
                        <tr>
                            <td>{{ $t("Customer") }}</td>
                            <td>{{ order.user.first_name+" "+order.user.last_name  }}</td>
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
                            <td>{{ $t('Note') }}</td>
                            <td>{{ order.note  }}</td>
                        </tr>
                        <tr>
                            <td>{{ $t("Order Date") }}</td>
                            <td>{{ order.order_at }}</td>
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

onMounted( () => {

})


</script>