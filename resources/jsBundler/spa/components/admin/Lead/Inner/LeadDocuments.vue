<template>

    <div class="lead-document-container">

        <div class="lead-detail-box">
            <div class="lbd-header clearfix">
                <h4 class="ldb-title pull-left">{{ $t('Documents') }}</h4>
            </div>
            <div class="ldb-body">

                <div class="ldb-document-body">
                    <template v-if="hasLeadDocuments()">
                        <div class="ldb-item ldb-document-item" v-for="leadDocument in leadDocuments.data">
                            <div v-html="HelperUtils.truncate(leadDocument.name, 40)"></div>

                            <div>
                                <a href="#" class="btn btn-primary btn-xs"
                                   @click.prevent="downloadLeadDocument(leadDocument.id, leadDocument.name)"
                                >
                                    <i class="fa fa-download"></i>
                                </a>
                                <a href="#" class="btn btn-danger btn-xs m-l-10"
                                   @click.prevent="deleteLeadDocument(leadDocument.id)"
                                   v-if="!isConverted()"
                                >
                                    <i class="fa fa-trash"></i>
                                </a>
                            </div>
                        </div>
                    </template>
                    <template v-else>
                        <div class="alert alert-danger">{{ $t('No lead documents') }}</div>
                    </template>
                </div>

                <div class="m-t-30 text-center">
                    <Bootstrap5Pagination :data="leadDocuments"
                                          class="pagination-sm"
                                          @pagination-change-page="getLeadDocumentList"
                                          :limit="3"
                    ></Bootstrap5Pagination>
                </div>

                <template v-if="!isConverted()">
                    <BsDropzone ref="dropzoneUploader"
                                id="dropzone"
                                class="editable-dropzone"
                                :options="dropzoneOption"
                                :destroy-dropzone="false"
                                v-on:vdropzone-file-added="uploadLeadDocument"
                    />
                </template>

            </div>

        </div>

    </div>


</template>

<script setup>
import {onMounted, reactive, ref} from "vue";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import HelperUtils from "@/libraries/utils/helpers/HelperUtils";
import Notifier from "@/libraries/utils/Notifier";
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import {useI18n} from "vue-i18n";
import {useRouter} from "vue-router";

const emit = defineEmits(['close']);
const props = defineProps({
    leadId: {
        required: true,
    },
    lead: {
        required: true,
    }
});

const { t: $t } = useI18n();
const router = useRouter();

const leadDocuments = ref({data: []});
const dropzoneUploader = ref(null);
const form = ref({page: 1, lead_id: props.leadId});

const dropzoneOption = reactive({
    url: route('admin.lead.document.store'),
    method: 'POST',
    maxFilesize: 100,
    autoProcessQueue: false,
    addRemoveLinks: true,
    dictRemoveFile: 'Entferne Bild',
    dictDefaultMessage: 'Bilder zum Hochladen hier ablegen',
});

function deleteLeadDocument(documentId) {
    Notifier.toastConfirm($t('Delete Lead Document'), $t('Do you want to delete this document?'), () => {
        axios.post(route('admin.lead.document.destroy'), { document_id: documentId})
            .then((response) => {
                if (response.status === 200) {
                    Notifier.toastSuccess(response.data.message);
                    getLeadDocumentList();
                }
            });
    }, $t('Yes'), $t('No'));
}

function downloadLeadDocument(documentId, documentName) {
    axios.postDownload(route('admin.lead.document.download'), { document_id: documentId})
        .then((response) => {
            if (response.status === 200) {
                HelperUtils.blobFileDownload(response, documentName);
            }
        });
}

function uploadLeadDocument(document) {

    let formData = new FormData();

    formData.append('lead_id', props.leadId);
    formData.append('document', document);

    axios.post(route('admin.lead.document.store'), formData).then((response) => {
        if (response.status === 201) {
            getLeadDocumentList(1, false);
            Notifier.toastSuccess(response.data.message);
        }
        removeFileFromDropzone(document);
    });
}

function removeFileFromDropzone(file) {
    dropzoneUploader.value.removeFile(file);
}

async function getLeadDocumentList(page = 1, setPage = true) {

    if (setPage) {
        setPageNumber(page);
    }

    await axios.post(route('admin.lead.document.list'), form.value)
        .then((response) => {
            if (response.status === 200) {
                leadDocuments.value = response.data.data;
            }
        });
}

function setPageNumber(page) {
    if (typeof page === 'number') {
        form.value.page = page;
    } else {
        form.value.page = 1;
    }
}

function hasLeadDocuments() {
    return leadDocuments.value.data.length > 0;
}

function isConverted() {
    return props.lead.is_converted;
}

onMounted(async () => {
    await getLeadDocumentList();
})

</script>

<style scoped lang="scss">

</style>
