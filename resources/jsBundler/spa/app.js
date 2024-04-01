import router from "./router";
import { createApp } from 'vue/dist/vue.esm-bundler.js';
import RootComponent from '@/components/RootComponent.vue';
import i18n from "@/libraries/i18n";
import {createPinia} from "pinia";
import { createMetaManager } from 'vue-meta';
import appConfig from "./config/app";

import Breadcrumbs from '@/components/Breadcrumbs.vue';
import vueDropzone from 'dropzone-vue3';
import FloatingVue from 'floating-vue';
import 'floating-vue/dist/style.css';
import TinyEditor from '@tinymce/tinymce-vue';
import vSelect from 'vue-select';
import VueGoogleMaps from 'vue-google-maps-community-fork';
import DatePicker from 'vue-datepicker-next';
import 'vue-datepicker-next/index.css';
import { Chart, registerables } from "chart.js";


import { defineRule, configure } from 'vee-validate';
import * as AllRules from '@vee-validate/rules';
import { setLocale } from '@vee-validate/i18n';
import validationMessages from '@/storage/data/validation';
import { localize } from '@vee-validate/i18n';

Object.keys(AllRules).forEach(rule => {defineRule(rule, AllRules[rule]);});
configure({generateMessage: localize(validationMessages)});
setLocale(appConfig.appLocale);

Chart.register(...registerables);
const pinia = createPinia();

const app = createApp({components: {RootComponent}})

app.component('Breadcrumbs', Breadcrumbs);
app.component('BsSelect', vSelect);
app.component('BsDropzone',vueDropzone);
app.component('BsEditor', TinyEditor);
app.component('BsDatePicker', DatePicker);

app
    .use(router)
    .use(pinia)
    .use(i18n)
    .use(FloatingVue)
    .use(createMetaManager())
    .use(VueGoogleMaps, {
        load: {
            key: 'AIzaSyCMcF9zUNz2y9XBSE0jWDQgrgk42uZ1WaE',
            libraries: "places"
        },
    })
    .mount("#app");


