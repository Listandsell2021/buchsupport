<template>
    <div class="switch-md" :class="props.class">
        <label class="switch">
            <input type="checkbox"
                   @change="changeStatus"
                   v-model="status"
                   :disabled="disabled"
            />
            <span class="switch-state"></span>
        </label>
    </div>
</template>
<script setup>
import {onMounted, ref} from "vue";
import axios from "@/libraries/utils/clientapi/axios";
import Notifier from "@/libraries/utils/Notifier";

const emit = defineEmits(['toggle']);

const props = defineProps({
    is_active: {
        required: true,
    },
    model_id: {
        required: true,
    },
    url: {
        required: true,
        type: String
    },
    disabled: {
        default: false
    },
    class: {
        default: ''
    }
})

const status = ref(false);
const disabled = ref(false);


function changeStatus() {
    const isActive = Number(status.value);

    axios.post(props.url, {
        model_id: props.model_id,
        is_active: isActive,
    }).then((response) => {
        emit('changed', isActive)
        if (response.status === 200) {
            if (response.data.message) {
                Notifier.toastSuccess(response.data.message);
            }
        }
    });
}

onMounted(() => {
    status.value = Boolean(parseInt(props.is_active));
    disabled.value = Boolean(parseInt(props.disabled));
})

</script>