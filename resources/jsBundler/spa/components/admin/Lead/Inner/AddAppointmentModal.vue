<template>
    <div class="modal fade show modal-show" id="add-lead-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" v-on-click-outside="onClickOutsideHandler">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $t('Add Appointment') }}</h5>
                    <a href="#" @click.prevent="closeModal" class="close close-modal" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>{{ $t('Description') }}</label>
                        <div class="appointment-bs-editor">
                            <BsEditor
                                :api-key="PluginConfig.tinyMce.key"
                                :init="PluginConfig.tinyMce.config"
                                v-model="form.description"
                            />
                        </div>
                    </div>
                    <div class="form-group">
                        <label>{{ $t('Start at') }}</label>
                        <div>
                            <BsDatePicker v-model:value="appointmentStartDate"
                                          type="datetime"
                                          format="DD.MM.YYYY HH:mm:ss"
                                          @change="updateStartDate"
                            ></BsDatePicker>
                        </div>
                    </div>
                    <div class="m-t-45">
                        <button class="btn btn-primary"
                                @click="addLeadAppointment"
                        >
                            <i class="fa fa-plus m-r-5"></i> {{ $t('Add') }}
                        </button>
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
import PluginConfig from "@/config/plugins";
import { vOnClickOutside } from '@vueuse/components'
import moment from "moment";
import {useI18n} from "vue-i18n";
import {useRouter} from "vue-router";
import HelperUtils from "@/libraries/utils/helpers/HelperUtils";

const emit = defineEmits(['close', 'reload']);
const props = defineProps({
    leadId: {
        required: true,
    }
});

const { t: $t } = useI18n();
const router = useRouter();
const appointmentStartDate = ref(null);

const form = ref({
    lead_id: props.leadId,
    description: '',
    start_at: '',
});

const onClickOutsideHandler = [
    (ev) => {
        if (HelperUtils.hasSomeParentTheClass(ev.target, 'mx-datepicker-main') ) return;

        closeModal();
    }, { ignore: [] }
];

function addLeadAppointment() {
    axios.post(route('admin.lead.appointment.store'), form.value)
        .then((response) => {
            if (response.status === 201) {
                Notifier.toastSuccess(response.data.message);
                emit('reload');
                closeModal();
            }
        });
}

function updateStartDate(date) {
    form.value.start_at = moment(date).format('YYYY-MM-DD HH:mm:ss');
}

function closeModal() {
    emit('close');
}

onMounted(async () => {

})

</script>

<style scoped lang="scss">

</style>
