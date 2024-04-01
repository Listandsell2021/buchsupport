<template>
    <div>
        <div class="modal fade show" tabindex="-1" style="display: block">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" v-on-click-outside="closeModal">
                    <div class="modal-header">
                        <h5 class="modal-title">Produkt Übersicht</h5>
                        <a href="#" class="close" @click.prevent="closeModal">
                            <i class="fa fa-close"></i>
                        </a>
                    </div>
                    <div class="modal-body">

                        <div class="product-description c-product-desc">
                            <div class="m-b-30">
                                <h5 class="font-20 m-b-20">Produkt-Beschreibung</h5>
                                <div v-if="product.description"
                                     v-html="product.description"
                                     class="thin text-left"
                                ></div>
                                <p v-else class="thin text-left">Keine vorhanden</p>
                            </div>

                            <div class="m-b-30">
                                <h5 class="font-20 m-b-20">Zusätzliche Produktinformation</h5>
                                <div v-if="product.user_product_note"
                                     v-html="product.user_product_note"
                                     class="thin text-left"
                                ></div>
                                <p v-else class="thin text-left">Keine vorhanden</p>
                            </div>

                        </div>

                        <div v-if="product.yt_link">
                            <hr/>
                            <iframe width="100%" height="350" :src="getEmbedUrl(product.yt_link)"></iframe>
                        </div>

                        <div class="product-image-gallery row" v-if="hasImages()">
                            <div class="col-md-4" v-for="image in product.images">
                                <a :key="image.id"
                                   target="_blank"
                                   :href="AppUtils.getApiProductStorageUrl(image.image_path)"
                                >
                                    <img :src="AppUtils.getApiProductStorageUrl(image.image_path)" class="img-thumbnail" />
                                </a>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    </div>
</template>
<script setup>
import {ref} from "vue";
import AppUtils from "@/libraries/utils/helpers/AppUtils";
import { vOnClickOutside } from '@vueuse/components';

const props = defineProps({
    product: {
        required: true,
    }
});

const emit = defineEmits(['close'])

function getEmbedUrl(link) {
    return 'https://www.youtube.com/embed/'+link;
}

function hasImages() {
    return props.product.images.length > 0;
}

function closeModal() {
    emit('close');
}


</script>
<style lang="sass">
</style>
