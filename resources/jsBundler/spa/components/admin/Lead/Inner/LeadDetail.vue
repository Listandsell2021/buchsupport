<template>
    <div class="lead-detail-container">
        <Transition>
            <RejectedLeadModal
                :lead-id="props.lead.id"
                @close="closeRejectedModal"
                @reload-lead="reloadLead"
                v-if="rejectedModal"
            ></RejectedLeadModal>
        </Transition>

        <div class="lead-detail-box">
            <div class="lbd-header clearfix">
                <h4 class="ldb-title pull-left">{{ $t('Details') }}</h4>
                <a href="#" class="ldb-edit pull-right"
                   @click.prevent="openEditLeadModal"
                   v-if="!isConverted()"
                >
                    <i class="fa fa-edit"></i>
                </a>
            </div>
            <div class="ldb-body">
                <div class="ldb-item row">
                    <label class="ldb-label col-md-4">{{ $t('Name') }}</label>
                    <div class="ldb-desc col-md-8">{{
                            props.lead.first_name + ' ' + props.lead.last_name
                        }}
                    </div>
                </div>
                <div class="ldb-item row">
                    <label class="ldb-label col-md-4">{{ $t('Email') }}</label>
                    <div class="ldb-desc col-md-8">{{ props.lead.email }}</div>
                </div>
                <div class="ldb-item row">
                    <label class="ldb-label col-md-4">{{ $t('Gender') }}</label>
                    <div class="ldb-desc col-md-8">{{ $t(props.lead.gender) }}</div>
                </div>
                <div class="ldb-item row">
                    <label class="ldb-label col-md-4">{{ $t('Phone No') }}</label>
                    <div class="ldb-desc col">{{ props.lead.phone_no }}</div>
                </div>
                <div class="ldb-item row">
                    <label class="ldb-label col-md-4">{{ $t('City') }}</label>
                    <div class="ldb-desc col-md-8">{{ props.lead.city }}</div>
                </div>
                <div class="ldb-item row">
                    <label class="ldb-label col-md-4">{{ $t('Street') }}</label>
                    <div class="ldb-desc col-md-8">{{ props.lead.street }}</div>
                </div>
                <div class="ldb-item row">
                    <label class="ldb-label col-md-4">{{ $t('Postal Code') }}</label>
                    <div class="ldb-desc col-md-8">{{ props.lead.postal_code }}</div>
                </div>
                <div class="ldb-item row">
                    <label class="ldb-label col-md-4">{{ $t('County') }}</label>
                    <div class="ldb-desc col-md-8">{{ props.lead.country }}</div>
                </div>
                <div class="ldb-item row">
                    <label class="ldb-label col-md-4">{{ $t('Map') }}</label>
                    <div class="ldb-desc col-md-8"><i class="fa fa-map-marker"></i></div>
                </div>
                <div class="ldb-item row" v-if="!isConverted()">
                    <label class="ldb-label col-md-4">{{ $t('Objection') }}</label>
                    <div class="ldb-desc col-md-8">
                        <template v-if="props.lead.objection">
                            <div v-html="props.lead.objection"></div>
                        </template>
                        <a href="#"
                           class="btn btn-xs btn-primary m-r-5"
                           @click.prevent="openRejectedModal"
                        ><i class="fa fa-edit"></i></a>
                        <template v-if="props.lead.objection">
                            <a href="#"
                               class="btn btn-xs btn-danger"
                               @click.prevent="removeLeadObjection"
                            ><i class="fa fa-trash"></i>
                            </a>
                        </template>

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
import RejectedLeadModal from "@/components/admin/Lead/RejectedLeadModal";
import HelperUtils from "@/libraries/utils/helpers/HelperUtils";
import BtModalHelper from "@/libraries/utils/BtModalHelper";
import Notifier from "@/libraries/utils/Notifier";

const props = defineProps({
    lead: {
        required: true,
    }
});

const emit = defineEmits(['open-edit-lead', 'reload'])

const rejectedModal = ref(false);

function openEditLeadModal() {
    emit('open-edit-lead');
}

function reloadLead() {
    emit('reload');
}

function isConverted() {
    return props.lead.is_converted;
}

function openRejectedModal() {
    rejectedModal.value = true;
    BtModalHelper.open();
}

function closeRejectedModal() {
    rejectedModal.value = false;
    BtModalHelper.close();
}

function removeLeadObjection() {
    axios.post(route('admin.leads.remove_objection'), {
        lead_id: props.lead.id
    })
        .then(async (response) => {
            if (response.status === 200) {
                Notifier.toastSuccess(response.data.message);
                emit('reload');
            }
        });
}


onMounted(async () => {

})

</script>

<style scoped lang="scss">

</style>
