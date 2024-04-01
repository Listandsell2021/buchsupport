<template>
    <div class="modal fade show modal-show" id="edit-lead-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" ref="modalDialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ $t('Lead Objection') }}</h5>
                    <a href="#" @click.prevent="closeModal" class="close close-modal" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <div class="modal-body">
                    <BsEditor
                        :api-key="PluginConfig.tinyMce.key"
                        :init="PluginConfig.tinyMce.config"
                        v-model="form.reason"
                    />
                    <button @click.prevent="updateLeadRejection" class="btn btn-primary m-t-30">{{ $t('Update') }}</button>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {onMounted, ref} from "vue";
import PluginConfig from "@/config/plugins";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import Notifier from "@/libraries/utils/Notifier";
import { onClickOutside } from '@vueuse/core';
import {useI18n} from "vue-i18n";
import {useRouter} from "vue-router";

const emit = defineEmits(['close', 'reload-lead']);
const props = defineProps({
    leadId: {
        required: true
    }
});

const { t: $t } = useI18n();
const router = useRouter();
const modalDialog = ref(null);

const form = ref({
    lead_id: props.leadId,
    reason: "",
});

onClickOutside(modalDialog, () => {
    closeModal();
})

function updateLeadRejection() {
    axios.post(route('admin.leads.update_objection'), form.value)
        .then((response) => {
            if (response.status === 200) {
                Notifier.toastSuccess(response.data.message);
                closeModalAndReload();
            }
        });
}


function closeModal() {
    emit('close');
}

function closeModalAndReload() {
    emit('reload-lead');
    emit('close');
}

onMounted(async () => {

})

</script>

<style scoped lang="scss">

</style>
