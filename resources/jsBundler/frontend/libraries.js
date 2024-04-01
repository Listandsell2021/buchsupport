import './bootstrap';

import { VTooltip } from 'floating-vue';
import { createApp } from 'vue/dist/vue.esm-bundler.js';
import ProductContainer from "./components/library/ProductContainer";

const app = createApp({
    components: {
        'product-container': ProductContainer
    }
});

app.directive('tooltip', VTooltip);
app.mount("#app");
