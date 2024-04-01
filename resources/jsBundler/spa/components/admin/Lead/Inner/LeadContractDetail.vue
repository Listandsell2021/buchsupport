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
                                    {{ leadContract.document_name }}
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
                        <div class="contract-label">{{ $t('Membership') }}</div>
                    </div>
                    <div class="col-md-8">
                        <div class="contract-item-desc">
                            {{ HelperUtils.ucfirst(leadContract.membership) }}
                        </div>
                    </div>
                </div>
            </div>
            <div class="contract-item">
                <div class="row">
                    <div class="col-md-4">
                        <div class="contract-label">{{ $t('Products') }}</div>
                    </div>
                    <div class="col-md-8">
                        <div class="contract-item-desc" v-if="hasContractProducts()">
                            <div class="contract-product"
                                 v-for="productItem in leadContract.product_items">
                                <div>
                                    <label>{{ $t('Name') }}:</label>
                                    <span>{{ productItem.product.name }}</span>
                                </div>
                                <div>
                                    <label>{{ $t('Quality') }}:</label>
                                    <span>{{
                                            HelperUtils.getProductCondition(productItem.condition)
                                        }}</span>
                                </div>
                                <div>
                                    <label>{{ $t('Price') }}:</label>
                                    <span
                                        v-html="HelperUtils.getCurrency(productItem.price)"></span>
                                </div>
                                <div>
                                    <label>{{ $t('Quantity') }}:</label>
                                    <span>{{ productItem.quantity }}</span>
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
    contract: {
        required: true,
    }
});

const leadContract = ref(props.contract);

const { t: $t } = useI18n();

function hasLeadDocument() {
    return leadContract.value.document_name !== "" && leadContract.value.document_name !== null;
}

function downloadLeadDocument() {
    axios.postDownload(route('admin.leads.download_contract_doc'), {
        contract_id: leadContract.value.id
    })
        .then((response) => {
            if (response.status === 200) {
                HelperUtils.blobFileDownload(response, leadContract.value.document_name);
            }
        });
}

function hasContractProducts() {
    return leadContract.value.product_items.length > 0;
}

function getLeadContract() {
    axios.post(route('admin.leads.get_contract'), {lead_id: props.contract.lead_id})
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
