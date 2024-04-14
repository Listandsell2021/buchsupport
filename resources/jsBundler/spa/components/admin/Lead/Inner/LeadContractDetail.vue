<template>
    <div class="contract-detail">
        <div class="contract-title">
            <h4>{{ $t('Order Detail') }}</h4>
        </div>
        <div class="contract-body">
            <div class="contract-item">
                <div class="row m-b-10 m-t-10">
                    <div class="col-md-4">
                        <div class="contract-label">{{ $t('Document') }}</div>
                    </div>
                    <div class="col-md-8">
                        <div class="contract-item-desc">
                            <template v-if="hasLeadDocument()">
                                <a href="#" @click.prevent="downloadLeadDocument">
                                    <i class="fa fa-file"></i>
                                    {{ leadContract.document }}
                                </a>
                            </template>
                            <template v-else>-</template>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="contract-label">{{ $t('Service') }}</div>
                    </div>
                    <div class="col-md-8">
                        <div class="contract-item-desc">
                            <div>
                                <label>{{ $t('Name') }}: </label>
                                <span>{{ leadContract.service.name }}</span>
                            </div>
                            <div>
                                <label>{{ $t('Price') }}: </label>
                                <span v-html="HelperUtils.getCurrency(leadContract.price)"></span>
                            </div>
                            <div>
                                <label>{{ $t('Quantity') }}: </label>
                                <span>{{ leadContract.quantity }}</span>
                            </div>
                            <div>
                                <label>{{ $t('Total') }}: </label>
                                <span v-html="HelperUtils.getCurrency(leadContract.price * leadContract.quantity)"></span>
                            </div>
                            <div>
                                <label>{{ $t('Note') }}: </label>
                                <span>{{ leadContract.note }}</span>
                            </div>
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
import HelperUtils from "@/libraries/utils/helpers/HelperUtils";
import {useI18n} from "vue-i18n";

const props = defineProps({
    lead: {
        required: true,
    }
});

const leadContract = ref(props.lead);
const { t: $t } = useI18n();

function hasLeadDocument() {
    return leadContract.value.document !== "" && leadContract.value.document !== null;
}

function downloadLeadDocument() {
    axios.postDownload(route('admin.leads.download_contract_doc'), {
        lead_id: leadContract.value.lead_id
    })
        .then((response) => {
            if (response.status === 200) {
                HelperUtils.blobFileDownload(response, leadContract.value.document);
            }
        });
}

function hasContractServices() {
    return leadContract.value.services.length > 0;
}

function getLeadContract() {
    axios.post(route('admin.leads.get_contract'), {lead_id: props.lead.id})
        .then((response) => {
            if (response.status === 200) {
                leadContract.value = response.data.data;
            }
        });
}


onMounted(async () => {

})

</script>

<style scoped lang="scss">

</style>
