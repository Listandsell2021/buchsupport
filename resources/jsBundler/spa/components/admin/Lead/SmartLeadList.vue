<template>
    <div class="top-smart-list">
        <div class="ts-list-header">
            <a href="#" @click.prevent="onClose"  class="ts-list-close"><i class="fa fa-close"></i></a>
            <h3 class="ts-list-title">{{ $t('Smart List') }}</h3>
        </div>
        <div class="ts-list-body">
            <div class="row">
                <div class="col-md-4">
                    <div class="ts-work-list" @click="showAllLeads">
                        <div class="work-list-box">
                            <div class="wlb-header">
                                <h5 class="wlb-title">{{ $t('Leads') }}</h5>
                                <span class="wlb-sub-title">{{ $t('All Leads') }}</span>
                                <div><span class="wlb-total">{{ smartLists.total_leads }}</span></div>
                            </div>
                            <div class="wlb-body">
                                <p>
                                    Your worklist gives you access to all leads. You could filter the list to find
                                    leads. Frequently used or interesting views can be saved as Smart Lists.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8">
                    <div class="row">
                        <div class="col-md-4" v-for="smartList in smartLists.smart_lists">
                            <div class="smart-list-item">
                                <div class="clearfix">
                                    <h4 class="sl-header pull-left"
                                        @click.prevent="openSmartListLeads(smartList.id)"
                                    >{{ smartList.name }}</h4>
                                    <a class="pull-right" href="#" @click.prevent="deleteSmartList(smartList.id, smartList.name)">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </div>
                                <div class="sl-detail row">
                                    <div class="col">
                                        <div class="sl-title">{{ $t('Total') }}</div>
                                        <div class="sl-total">{{ smartList.leads_count }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="sl-title">{{ $t('Active') }}</div>
                                        <div class="sl-total">{{ smartList.active_leads_count }}</div>
                                    </div>
                                    <div class="col">
                                        <div class="sl-title">{{ $t('Inactive') }}</div>
                                        <div class="sl-total">{{ smartList.inactive_leads_count }}</div>
                                    </div>
                                </div>
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
import Notifier from "@/libraries/utils/Notifier";
import route from '@/libraries/utils/ZiggyRoute';
import {useI18n} from "vue-i18n";

const props = defineProps({
})

const {t: $t} = useI18n();
const smartLists = ref([]);

const emit = defineEmits(['close', 'show-all', 'show-smart-list']);

async function loadSmartLists() {
    let result = await axios.get(route('admin.smart_list.details'));
    if (result.status === 200) {
        smartLists.value = result.data.data;
    }
}

function deleteSmartList(smartListId, smartListName) {
    Notifier.toastConfirm($t('Do you want to delete "{name}"?', {name: smartListName}), '', (confirm) => {
            axios.post(route('admin.smart_list.destroy'), {
                smart_list_id: smartListId
            })
                .then(async (response) => {
                    if (response.status === 200) {
                        Notifier.toastSuccess(response.data.message);
                        await loadSmartLists();
                    }
                });
    });


}

function showAllLeads() {
    emit('show-all');
}

function openSmartListLeads(smartListId) {
    emit('show-smart-list', smartListId);
}

function onClose() {
    emit('close');
}

onMounted(() => {
    loadSmartLists();
});

</script>

<style scoped lang="scss">

</style>
