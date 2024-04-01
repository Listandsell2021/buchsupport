<template>
    <div class="product-image-container">
        <VueDraggableNext class="row" v-model="productImages" @change="sortProductImages">
            <div class="col-md-3" v-for="(image) in productImages" :key="image.id">
                <div class="product-image-item">
                    <div class="product-image-item-inner">
                        <i @click.prevent="removeImage(image.id)" class="product-image-remove fa fa-remove"></i>
                        <figure class="filemanager-thumb">
                            <img :src="image.thumb_url"
                                 :alt="image.name"
                                 class="img-thumb"
                            />
                        </figure>
                    </div>
                </div>
            </div>
        </VueDraggableNext>
    </div>
</template>

<script setup>
import {onMounted, ref} from "vue";
import axios from "@/libraries/utils/clientapi/axios";
import Notifier from "@/libraries/utils/Notifier";
import route from '@/libraries/utils/ZiggyRoute';
import EventBus from "@/libraries/utils/EventBus";
import { VueDraggableNext } from 'vue-draggable-next';

const props = defineProps({
    productId: {
        required: true,
    },
    images: {
        required: true,
        type: Array,
    },
})

const productImages = ref([]);

function removeImage(imageId) {
    axios.post(route('admin.products.remove_image'), {
        image_id: imageId
    }).then((response) => {
        if (response.status === 200) {
            Notifier.toastSuccess(response.data.message);
            loadProductImages();
        }
    });
}


function loadProductImages() {
    axios.get(route('admin.products.images'), {
        product_id: props.productId,
    }).then((response) => {
        if (response.status === 200) {
            productImages.value = response.data.data;
        }
    });
}

function sortProductImages() {
    let imageIds = productImages.value.map((productImage) => productImage.id);
    axios.post(route('admin.products.sort_images'), {
        image_ids: imageIds
    }).then((response) => {
        if (response.status === 200) {
            Notifier.toastSuccess(response.data.message);
            loadProductImages();
        }
    });
}

onMounted(() => {
    productImages.value = props.images;
    EventBus.on('reload-product-images', () => {
        loadProductImages();
    });
});



</script>

<style scoped lang="scss">

</style>
