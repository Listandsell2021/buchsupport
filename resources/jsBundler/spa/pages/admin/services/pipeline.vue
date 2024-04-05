<template>
    <div>
        <Breadcrumbs :menu-items="breadcrumbConfig.service.edit(serviceId)" :title="$t('Pipeline Edit')"/>

        <div class="container-fluid">
            <div class="pipeline-container">
                <div class="pipeline-card" v-for="(pipeline, pipelineIndex) in pipelines" :key="pipeline.id">
                    <div class="pipeline-title">
                        {{ pipeline.name }}
                    </div>

                    <VueDraggableNext
                        tag="ul"
                        v-bind="dragOptions"
                        class="list-group pipeline-group dragArea"
                        :list="pipeline.orders"
                        :scroll-sensitivity="200"
                        group="people"
                        :item-key="'pipeline_'+pipeline.name"
                        @change="sortPipeline(pipelineIndex, pipeline.id, $event)"
                    >
                        <li class="list-group-item draggable-item pipeline-item"
                            :key="order.id"
                            v-for="order in pipeline.orders"
                        >
                            <div class="m-b-10 pipeline-item-title">{{ order.user.first_name + " " + order.user.last_name }}</div>
                            <table class="pipeline-table">
                                <tr>
                                    <td>{{ $t('Price') }}</td>
                                    <td><TextCurrency :amount="order.price"/></td>
                                </tr>
                                <tr>
                                    <td>{{ $t('Quantity') }}</td>
                                    <td>{{ order.quantity }}</td>
                                </tr>
                                <tr>
                                    <td>{{ $t('Order At') }}</td>
                                    <td>{{ HelperUtils.getReadableDate(order.order_at) }}</td>
                                </tr>
                            </table>
                        </li>
                    </VueDraggableNext>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import {ref, onMounted, computed} from "vue";
import breadcrumbConfig from "@/storage/data/breadcrumbs";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import Notifier from "@/libraries/utils/Notifier";
import {useI18n} from "vue-i18n";
import {useRoute, useRouter} from "vue-router";
import {useMeta} from "vue-meta";
import {VueDraggableNext} from "vue-draggable-next";
import __has from "lodash/has";
import HelperUtils from "../../../libraries/utils/helpers/HelperUtils";
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
useMeta({title: $t('Service Pipeline')});

const dragOptions = computed(() => {
    return {
        group: {name: 'g1'},
        scrollSensitivity: 0.1,
        forceFallback: true
    };
});



function onDrop(arr, dragResult) {
    console.log(arr, dragResult);
}


const serviceId = routes.params.id;

let form = ref(null);
let pipelines = ref(null);

pipelines.value = props.data.value;

function updateService() {
    axios.put(route('admin.services.update', {id: serviceId}), form.value).then((response) => {
        if (response.status === 200) {
            Notifier.toastSuccess(response.data.message);
            router.push('/admin/services');
        }
    });
}



function sortPipeline(pipelineIndex, pipelineId, event) {

    if (__has(event, 'added')) { //__has(event, 'removed')
        axios.post(route('admin.orders.change_pipeline'), {
            order_id: event.added.element.id,
            pipeline_id: pipelineId,
            order_no: ++event.added.newIndex,
        });
    }
    if (__has(event, 'moved')) {
        axios.post(route('admin.orders.sort'), {
            pipeline_id: pipelineId,
            order_ids: getSortedOrderIds(pipelines.value[pipelineIndex]['orders']),
        })
            .then(response => {});
    }
}

function getSortedOrderIds(orders) {
    return orders.map(order => order.id);
}


onMounted( () => {

})


</script>