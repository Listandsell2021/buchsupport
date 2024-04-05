<template>
    <button class="btn btn-danger btn-xs ms-1"
            :class="props.class"
            @click.prevent="executeDelete"
            v-tooltip="$t('Delete '+props.name)"
    >
        <i class="fa fa-trash"></i>
    </button>
</template>
<script setup>
import {onMounted, ref} from "vue";
import axios from "@/libraries/utils/clientapi/axios";
import Notifier from "@/libraries/utils/Notifier";
import route from "@/libraries/utils/ZiggyRoute";
import {useI18n} from "vue-i18n";

const emit = defineEmits(['toggle']);
const { t: $t } = useI18n();

const props = defineProps({
    id: {
        required: true,
    },
    name: {
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



function executeDelete() {

    Notifier.toastConfirm($t('Delete !!!'), $t('Do you want to delete "{name}"?', {name: props.name}),
        () => {
            axios.delete(props.url, {id: props.id})
                .then((response) => {
                    Notifier.toastSuccess(response.data.message);
                    emit('updated')
                });
        });
}

onMounted(() => {
})

</script>