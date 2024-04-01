import './bootstrap';

import { VTooltip } from 'floating-vue';
import { createApp } from 'vue/dist/vue.esm-bundler.js';
import SearchContainer from "./components/showroom/SearchContainer";

const app = createApp({
    components: {
        'search-filter-container': SearchContainer
    }
});

app.directive('tooltip', VTooltip);
app.mount("#app");


