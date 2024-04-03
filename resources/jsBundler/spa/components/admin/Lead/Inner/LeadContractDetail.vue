<template>

    <div class="contract-detail">
        <div class="contract-title">
            <h4>{{ $t('Contract Detail') }}</h4>
        </div>
        <div class="contract-body">
            <div class="contract-item">
                <div class="row">
                    <div class="col-md-4">
                        <div class="contract-label">{{ $t('Document') }}</div>
                    </div>
                    <div class="col-md-8">
                        <div class="contract-item-desc">
                            <template v-if="hasLeadDocument()">
                                <a href="#" @click.prevent="downloadLeadDocument">
                                    <i class="fa fa-file"></i>
                                    {{ leadContract.contract_document }}
                                </a>
                            </template>
                            <template v-else>-</template>
                        </div>
                    </div>
                </div>
            </div>
            <div class="contract-item">
                <div class="row">
                    <div class="col-md-4">
                        <div class="contract-label">{{ $t('Services') }}</div>
                    </div>
                    <div class="col-md-8">
                        <div class="contract-item-desc" v-if="hasContractServices()">
                            <div class="contract-product"
                                 v-for="service in lead.services">
                                <div>
                                    <label>{{ $t('Name') }}:</label>
                                    <span>{{ service.service.name }}</span>
                                </div>
                                <div>
                                    <label>{{ $t('Note') }}:</label>
                                    <span>{{ service.service.note }}</span>
                                </div>
                                <div>
                                    <label>{{ $t('Price') }}:</label>
                                    <span
                                        v-html="HelperUtils.getCurrency(service.service.price)"></span>
                                </div>
                                <div>
                                    <label>{{ $t('Quantity') }}:</label>
                                    <span>{{ service.service.quantity }}</span>
                                </div>
                            </div>
                        </div>
                        <template v-else>-</template>
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

const lead = ref(props.lead);
const { t: $t } = useI18n();

function hasLeadDocument() {
    return lead.value.contract_document !== "" && lead.value.contract_document !== null;
}

function downloadLeadDocument() {
    axios.postDownload(route('admin.leads.download_contract_doc'), {
        lead_id: lead.value.id
    })
        .then((response) => {
            if (response.status === 200) {
                HelperUtils.blobFileDownload(response, lead.value.contract_document_name);
            }
        });
}

function hasContractServices() {
    return lead.value.services.length > 0;
}

function getLeadContract() {
    axios.post(route('admin.leads.get_contract'), {lead_id: props.lead.id})
        .then((response) => {
            if (response.status === 200) {
                lead.value = response.data.data;
            }
        });
}


onMounted(async () => {

})

</script>

<style scoped lang="scss">

</style>
