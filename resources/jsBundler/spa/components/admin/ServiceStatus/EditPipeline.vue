<template>
    <div class="modal fade show modal-show" id="edit-lead-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" ref="modalDialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ $t('Edit Status') }}</h5>
                    <a href="#" @click.prevent="closeModal" class="close close-modal" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <div class="modal-body">
                    <Form @submit="updatePipeline" v-slot="{errors}">

                        <div class="form-group">
                            <label>{{ $t('Name') }}</label>
                            <Field class="form-control"
                                   v-model="form.name"
                                   type="text"
                                   name="name"
                                   rules="required"
                                   :placeholder="$t('Enter name')"
                                   :class="{'is-invalid': errors.name}"
                            />
                            <ErrorMessage class="text-danger d-block" name="name"/>
                        </div>

                        <div class="form-group">
                            <label>{{ $t('Has tracking') }}</label>
                            <StatusSwitcher :is_active="form.has_tracking"
                                            @toggle="changeHasTracking"
                            ></StatusSwitcher>
                        </div>

                        <div class="form-group">
                            <label>{{ $t('Is Default') }}</label>
                            <StatusSwitcher :is_active="form.default"
                                            @toggle="changeDefault"
                            ></StatusSwitcher>
                        </div>

                        <button type="submit" class="btn btn-primary m-t-30">{{ $t('Update Status') }}</button>
                    </Form>

                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {onMounted, ref} from "vue";
import { Form, Field, ErrorMessage } from 'vee-validate';
import { countryList as countries } from "@/storage/data/countrylist";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import Notifier from "@/libraries/utils/Notifier";
import { GendersSelectable } from "@/storage/data/genders";
import { useLeadStatusStore } from '@/storage/store/lead_status';
import { onClickOutside } from '@vueuse/core';
import {useI18n} from "vue-i18n";
import {useRouter} from "vue-router";
import StatusSwitcher from "@/components/widgets/form/StatusSwitcher.vue";

const emit = defineEmits(['close', 'refresh']);
const props = defineProps({
    pipeline: {
        required: true,
    }
});

const { t: $t } = useI18n();
const router = useRouter();
const modalDialog = ref(null);
const leadStatus = await useLeadStatusStore().getLeadStatusByRefresh();

const form = ref({
    id: props.pipeline.id,
    name: props.pipeline.name,
    default: props.pipeline.default,
    has_tracking: props.pipeline.has_tracking,
});

onClickOutside(modalDialog, () => {
    closeModal();
})

function updatePipeline() {
    axios.put(route('admin.service_pipeline.update', {id: props.pipeline.id}), form.value)
        .then((response) => {
            if (response.status === 200) {
                Notifier.toastSuccess(response.data.message);
                emit('refresh');
                closeModal();
            }
        });
}

function changeHasTracking(hasTracking) {
    form.value.has_tracking = hasTracking;
}

function changeDefault(defaultValue) {
    form.value.default = defaultValue;
}

function closeModal() {
    emit('close');
}

onMounted(async () => {

})

</script>

<style scoped lang="scss">

</style>
