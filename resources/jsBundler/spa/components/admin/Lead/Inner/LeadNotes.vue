<template>

    <div class="lead-notes">
        <HasPermission :permission="AdminPermissions.CREATE_NOTE">
            <div class="lead-note-editor" v-if="!isConverted()">
                <h4 class="lne-title">Notes</h4>
                <BsEditor
                    :api-key="PluginConfig.tinyMce.key"
                    :init="PluginConfig.tinyMce.config"
                    v-model="noteForm.note"
                />
                <button class="btn btn-primary m-t-10"
                        v-if="noteForm.note.length > 0"
                        @click.prevent="addLeadNote"
                >{{ $t('Add Note') }}
                </button>
            </div>
        </HasPermission>

        <HasPermission :permission="AdminPermissions.LIST_NOTE">
            <div class="lead-note-lists" v-if="leadNotes.length > 0">
                <h5 class="lnl-title">List Notes</h5>
                <div class="lnl-item" v-for="leadNote in leadNotes">
                    <i class="lnl-icon fa fa-calendar"></i>
                    <div class="lnl-desc">
                        <div v-html="leadNote.description"></div>
                        <div class="lnl-added-by">
                            {{ $t('Added by') }}:
                            <span>{{ leadNote.created_by }}</span>
                        </div>
                    </div>
                    <div class="lnl-date">{{ HelperUtils.getDateTimeInGerman(leadNote.created_at) }}</div>
                </div>
            </div>
        </HasPermission>

    </div>

</template>

<script setup>
import {onMounted, ref} from "vue";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import HelperUtils from "@/libraries/utils/helpers/HelperUtils";
import HasPermission from "@/components/admin/Permission/HasPermission";
import AdminPermissions from "@/storage/data/AdminPermissions";
import Notifier from "@/libraries/utils/Notifier";
import PluginConfig from "@/config/plugins";

const props = defineProps({
    lead: {
        required: true,
    }
});

const leadNotes = ref([]);

const noteForm = ref({
    note: '',
    lead_id: props.lead.id,
});

function getLeadNotes() {
    axios.get(route('admin.leads.notes', {lead_id: props.lead.id}))
        .then((response) => {
            if (response.status === 200) {
                leadNotes.value = response.data.data;
            }
        });
}

function addLeadNote() {
    axios.post(route('admin.leads.add_note'), noteForm.value)
        .then((response) => {
            if (response.status === 200) {
                noteForm.value.note = '';
                Notifier.toastSuccess(response.data.message);
                getLeadNotes();
            }
        });
}

function isConverted() {
    return props.lead.is_converted;
}


onMounted(async () => {
    await getLeadNotes();
})

</script>

<style scoped lang="scss">

</style>
