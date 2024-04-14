<template>
    <div class="modal fade show modal-show" id="edit-lead-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" ref="modalDialog">
            <div class="modal-content">
                <div class="modal-body">
                    <a href="#" @click.prevent="closeModal" class="close close-modal" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </a>
                    <h3>Do you want to convert lead into customer?</h3>
                    <div class="clearfix">
                        <button class="btn btn-primary" @click.prevent="updateLeadConversion">Yes</button>
                        <button class="btn btn-danger" @click="closeModal">No</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {onMounted, ref} from "vue";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import Notifier from "@/libraries/utils/Notifier";
import { onClickOutside } from '@vueuse/core';
import {useI18n} from "vue-i18n";
import {useRouter} from "vue-router";

const emit = defineEmits(['close', 'reload']);
const props = defineProps({
    orderId: {
        required: true
    },
    pipelineId: {
        required: true
    }
});

const { t: $t } = useI18n();
const router = useRouter();
const modalDialog = ref(null);

/*onClickOutside(modalDialog, () => {
    closeModal();
})*/

function updateLeadConversion() {
    axios.put(route('admin.leads.update', {id: props.lead.id}), form.value)
        .then((response) => {
            if (response.status === 200) {
                Notifier.toastSuccess(response.data.message);
                emit('reload');
                closeModal();
            }
        });
}

function closeModal() {
    emit('close');
}

onMounted(async () => {

})

</script>

<style scoped lang="scss">

</style>
