<template>
    <div class="modal fade show modal-show" id="add-lead-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" ref="modalDialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ $t('Add Service Status') }}</h5>
                    <a href="#" @click.prevent="closeModal" class="close close-modal" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <div class="modal-body">
                    <Form @submit="addLead" v-slot="{errors}">

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

                        <div class="form-group">
                            <label>{{ $t('Has status') }}</label>
                            <StatusSwitcher :is_active="form.has_option"
                                            @toggle="changeStatus"
                            ></StatusSwitcher>
                        </div>

                        <button type="submit" class="btn btn-primary m-t-30">{{ $t('Save Status') }}</button>
                    </Form>

                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Form, Field, ErrorMessage } from 'vee-validate';
import {onMounted, ref} from "vue";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import Notifier from "@/libraries/utils/Notifier";
import { onClickOutside } from '@vueuse/core';
import {useI18n} from "vue-i18n";
import {useRouter} from "vue-router";
import StatusSwitcher from "@/components/widgets/form/StatusSwitcher.vue";

const emit = defineEmits(['close', 'refresh']);
const props = defineProps({
    serviceId: {
        required: true
    }
});
const { t: $t } = useI18n();
const router = useRouter();
const modalDialog = ref(null);

const form = ref({
    service_id: props.serviceId,
    name: '',
    has_tracking: 0,
    has_option: 0,
    default: 0,
});

onClickOutside(modalDialog, () => {
    closeModal();
})

function addLead() {
    axios.post(route('admin.service_pipeline.store'), form.value).then((response) => {
        if (response.status === 201) {
            Notifier.toastSuccess(response.data.message);
            refreshList();
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

function changeStatus(defaultValue) {
    form.value.has_option = defaultValue;
}

function closeModal() {
    emit('close');
}

function refreshList() {
    emit('refresh');
}

onMounted(async () => {
})

</script>

<style scoped lang="scss">

</style>
