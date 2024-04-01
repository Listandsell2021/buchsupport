<template>
    <div>

        <Breadcrumbs :menu-items="breadcrumbConfig.mail.edit(mailId)" :title="$t('Edit: {mail}', {mail: mail.name})"/>

        <PreviewMailModal
            v-if="previewMail"
            :layout="mail.html_layout"
            :content="form.html_template"
            :style="mail.html_style"
            @close="closePreviewMail"
        ></PreviewMailModal>

        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label for="subject">{{ $t('Subject') }}</label>
                        <input type="text"
                               id="subject"
                               v-model="form.subject"
                               class="form-control"
                               :placeholder="$t('Enter Subject')"
                        />
                    </div>
                    <div class="form-group">
                        <label for="mail-template">{{ $t('Mail Template') }}</label>
                        <div class="mail-variable-list m-b-15">
                            <template v-for="variable in mail.variables">
                                <a href="#"
                                   class="mail-variable-item btn btn-light-secondary btn-sm m-r-5"
                                   @click.prevent="addVariableToEditor(variable)"
                                >
                                    <i class="fa fa-anchor"></i> {{ variable }}
                                </a>
                            </template>
                        </div>
                        <BsEditor
                            :api-key="PluginConfig.tinyMce.key"
                            :init="PluginConfig.tinyMce.config"
                            v-model="form.html_template"
                            ref="tinyMce"
                        />
                    </div>

                    <div class="form-group" v-if="false">
                        <label for="mail-layout" class="m-r-10">{{ $t('Layout') }}</label>
                        <a href="#" v-tooltip="$t('{{{ body }}} variable must be in layout in order to get mail template content')">
                            <i class="fa fa-exclamation-triangle"></i>
                        </a>
                        <div class="alert alert-danger" v-show="false">
                            <span v-html="'{{{ body }}}'"></span> variable must be in layout in order to get mail template content
                        </div>
                        <BsEditor
                            :api-key="PluginConfig.tinyMce.key"
                            :init="PluginConfig.tinyMce.config"
                            v-model="form.html_layout"
                            ref="tinyMceLayout"
                        />
                    </div>

                    <div class="form-group" v-if="false">
                        <label for="mail-layout" class="m-r-10">{{ $t('Styles') }}</label>
                        <VAceEditor v-model:value="form.html_style"
                                    lang="html"
                                    style="height: 300px"
                                    :options="{
                                        useWorker: true,
                                        enableBasicAutocompletion: true,
                                        enableSnippets: true,
                                        enableLiveAutocompletion: true,
                                      }"
                        ></VAceEditor>
                    </div>

                    <div class="clearfix m-t-15">
                        <button class="btn btn-primary m-r-10" @click.prevent="updateMail">{{ $t('Update') }}</button>
                        <button class="btn btn-info" @click.prevent="openPreviewMail">
                            <i class="fa fa-eye"></i> {{ $t('Preview') }}
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import {onMounted, ref} from "vue";
import breadcrumbConfig from "@/storage/data/breadcrumbs";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import Notifier from "@/libraries/utils/Notifier";
import PluginConfig from "@/config/plugins";
import PreviewMailModal from "@/components/admin/Mail/PreviewMailModal";
import BtModalHelper from "@/libraries/utils/BtModalHelper";
import { VAceEditor } from 'vue3-ace-editor';
import '@/storage/data/ace';
import {useI18n} from "vue-i18n";
import {useRoute, useRouter} from "vue-router";
import {useMeta} from "vue-meta";

const props = defineProps({
    data: {
        required: true,
        type: Object,
    }
});

const router = useRouter();
const routes = useRoute();
const { t: $t } = useI18n();
useMeta({title: $t('Edit: {mail}', {mail: props.data.value.name})});

const mailId = routes.params.id;

const mail = ref(null);
const tinyMce = ref(null);
const tinyMceLayout = ref(null);
let previewMail = ref(false);

let form = ref({
    id: 0,
    name: '',
    subject: '',
    html_template: '',
});
mail.value = props.data.value;
mapRoleIntoForm(props.data.value);


function addVariableToEditor(variable) {
    tinyMce.value.getEditor().selection.setContent('{{ '+variable+' }}');
}
function addVariableToEditorLayout() {
    tinyMceLayout.value.getEditor().selection.setContent('{{{ body }}}');
}

function mapRoleIntoForm(mail) {
    form = ref({
        id: mail.id,
        name: mail.name,
        subject: mail.subject,
        html_template: mail.html_template,
        //html_layout: mail.html_layout,
        //html_style: mail.html_style
    });
}

function updateMail() {
    axios.put(route('admin.mails.update', {id: mailId}), form.value)
        .then((response) => {
            if (response.status == 200) {
                Notifier.toastSuccess($t(response.data.message));
                //router.push('/admin/mail-management');
            }
        });
}

function openPreviewMail() {
    previewMail.value = true;
    BtModalHelper.open();
}

function closePreviewMail() {
    previewMail.value = false;
    BtModalHelper.close();
}


onMounted(() => {

});

</script>