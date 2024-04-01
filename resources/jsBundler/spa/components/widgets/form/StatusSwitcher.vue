<template>
    <div class="switch-md" :class="props.class">
        <label class="switch">
            <input type="checkbox"
                   @change="statusChanged"
                   v-model="status"
                   :disabled="disabled"
            />
            <span class="switch-state"></span>
        </label>
    </div>
</template>
<script setup>
import {onMounted, ref} from "vue";

const emit = defineEmits(['toggle']);

const props = defineProps({
    is_active: {
        required: true,
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

function statusChanged() {
    emit('toggle', Number(status.value))
}

onMounted(() => {
    status.value = Boolean(parseInt(props.is_active));
    disabled.value = Boolean(parseInt(props.disabled));
})

</script>