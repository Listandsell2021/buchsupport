<template>
    <a href="#" class="import_leads" :class="props.classes" @click.prevent="$refs.leadFile.click()">
        <i class="fa fa-file"></i> {{ $t('Import Leads') }}
    </a>
    <input type="file" ref="leadFile" style="display: none" @change="uploadLeads"/>
</template>

<script setup>
import {onMounted, ref} from "vue";
import axios from "@/libraries/utils/clientapi/axios";
import Notifier from "@/libraries/utils/Notifier";
import route from '@/libraries/utils/ZiggyRoute';

const props = defineProps({
    classes: {
        default: 'btn btn-sm btn-primary'
    }
});

const leadFile = ref(null);
const emit = defineEmits(['imported']);

function uploadLeads(event) {

    let formData = new FormData();
    formData.append('file', event.target.files[0]);

    axios.post(route('admin.leads.import'), formData)
        .then((response) => {
            if (response.status === 200) {
                Notifier.toastSuccess(response.data.message);
                emit('imported');
                //AppUtils.blobFileDownload(response);
            }
        })
}

onMounted(() => {

});

</script>

<style scoped lang="scss">
.import_leads {
    display: inline-block;
}
</style>
