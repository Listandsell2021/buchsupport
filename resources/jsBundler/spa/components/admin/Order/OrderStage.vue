<template>
    <ul class="row wizard-nav wizard-nav-pills">
        <li class="col step-wizard-item mb-2" :class="{'active': isActiveStage(pipeline.id)}" v-for="pipeline in pipelines">
            <div class="stepTitle"> {{ pipeline.name }}</div>
            <div class="step">
                <span class="step-no">&#10003;</span>
            </div>
            <div class="stage-date">
                {{ getDateOfActiveStage(pipeline.id) }}
            </div>
        </li>
    </ul>
</template>
<script setup>

import {onMounted, ref} from "vue";
import axios from "@/libraries/utils/clientapi/axios";
import route from "@/libraries/utils/ZiggyRoute";
import HelperUtils from "@/libraries/utils/helpers/HelperUtils";

const props = defineProps({
    stages: {
        required: true
    },
    serviceId: {
        required: true,
    },
    orderId: {
        required: true,
    }
});

const pipelines = ref([]);

function getServicePipelines() {
    axios.post(route('admin.service_pipeline.by_service', {service_id: props.serviceId}))
        .then((response) => {
            if (response.status === 200) {
                pipelines.value = response.data.data;
            }
        });
}

function isActiveStage(pipelineId) {
    return props.stages.some((stage) => {
        return stage.pipeline.id === pipelineId;
    });
}

function getDateOfActiveStage(pipelineId) {
    let dateTime = "";
    for (const stage of props.stages) {
        if (stage.pipeline.id == pipelineId) {
            dateTime = HelperUtils.getDateTimeInGerman(stage.created_at);
        }
    }
    return dateTime;
}

onMounted(async () => {
    getServicePipelines();


});

</script>