<template>
    <div class="modal fade show modal-show" id="update-lead-salesperson-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" ref="modalDialog">
            <div class="modal-content">
                <div class="modal-body">
                    <a href="#" @click.prevent="closeModal" class="close close-modal" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </a>
                    <div class="row">
                        <div class="form-group">
                            <label>{{ $t('Status') }}</label>
                            <BsSelect
                                v-model="form.lead_status_id"
                                :options="leadStatus"
                                label="name"
                                :reduce="status => status.id"
                                @update:model-value="updateStatus"
                                :placeholder="$t('Select Status')"
                            />
                        </div>
                        <div class="form-group">
                            <button class="btn btn-primary"
                                    @click.prevent="updateLeadStatus"
                            >{{ $t('Update Status') }}</button>
                        </div>
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
import {useSalespersonsStore} from "@/storage/store/salespersons";
import {useLeadStatusStore} from "@/storage/store/lead_status";

const props = defineProps({
    filters: {
        required: true,
        type: Object
    }
})

const emit = defineEmits(['close']);

const { t: $t } = useI18n();
const router = useRouter();
const modalDialog = ref(null);
const leadStatus = await useLeadStatusStore().getLeadStatusByRefresh();

const form = ref({
    lead_status_id: '',
});

function updateStatus(selected) {
    if (selected == null) {
        form.value.lead_status_id = '';
    }
}

function updateLeadStatus() {
    axios.post(route('admin.leads.update_bulk_status'), {
        lead_status_id: form.value.lead_status_id,
        filters: props.filters
    })
        .then((response) => {
        if (response.status === 201) {
            Notifier.toastSuccess(response.data.message);
            closeModal();
        }
    });
}

function closeModal() {
    emit('close');
}

onClickOutside(modalDialog, () => {
    closeModal();
})


</script>

<style scoped lang="scss">

</style>
