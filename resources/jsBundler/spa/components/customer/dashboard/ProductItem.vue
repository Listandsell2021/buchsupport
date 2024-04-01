<template>
    <div class="product-card-inner">

        <div class="product-card">
            <div class="pc-top-info">
                <span class="v-chip pct-icon-container">
                    <i class="fa fa-book pct-icon"></i>
                    <span class="pct-icon-text">{{ product.quantity }}</span>
                </span>
                <a @click.prevent="getProductInfo()"
                   class="pct-btn-info"
                   v-tooltip="$t('View details')"
                >
                    <i class="icony-info fa fa-info-circle"></i>
                </a>

                <a @click.prevent="getProductInfo()"
                   class="pct-btn-info youtube-icon"
                   v-if="hasYoutubeLink()"
                   v-tooltip="$t('Video betrachten')"
                >
                    <i class="icony-youtube fa fa-youtube"></i>
                </a>

                <a @click.prevent="reverseShowProduct(product.user_product_id, product)"
                   class="pct-btn-info youtube-icon"
                   v-tooltip="product.is_hidden ? 'Werk anzeigen' : 'Werk verbergen'"
                >
                    <i v-if="product.is_hidden" class="icony-youtube fa fa-eye-slash"></i>
                    <i v-else class="icony-youtube fa fa-eye"></i>
                </a>

            </div>

            <div class="pc-image-wrapper">
                <figure class="pc-image-figure">
                    <template v-if="hasImages(product.images)">
                        <img class="pc-image" :src="getFirstImageUrl(product.images)" :alt="getFirstImageName(product.images)">
                    </template>
                    <img v-else class="pc-image" src="/assets/customer/images/placeholder.png" alt="no-image-found">
                </figure>
            </div>
            <div class="product-card-body">
                <span v-if="hasCategory()" class="pc-category-title">
                    <i class="mdi mdi-tag icon-tag"></i>
                    {{ product.category_name }}
                </span>
                <h5 class="pc-title">{{ product.product_name }}</h5>
                <div>
                    <a href="#" @click.prevent="createBookSellingSignal" class="pc-btn-interest">
                        <i class="mdi mdi-book mr-2"></i> Kaufinteresse
                    </a>
                </div>
            </div>
        </div>

        <div class="product-card-desc">
            <span class="text-body-2 grey--text float-left">{{ product.price }} €</span>
            <span class="pc-condition text-center green--text float-left">Sehr gut</span>
            <span class="text-body-2 grey--text float-right">{{ dateInGermany(product.purchased_date) }}</span>
        </div>

        <ProductModal :product="props.product"
                       @close="hideProductModal"
                       v-if="productModal"
        ></ProductModal>

    </div>
</template>

<script setup>
import {ref} from "vue";
import ProductModal from "./ProductModal";
import axios from '@/libraries/utils/clientapi/axios';
import Notifier from "@/libraries/utils/Notifier";
import DateFormatter from "@/libraries/utils/helpers/DateFormatter";
import HelperUtils from "@/libraries/utils/helpers/HelperUtils";
import AppUtils from "@/libraries/utils/helpers/AppUtils";
import route from '@/libraries/utils/ZiggyRoute';
import {useI18n} from "vue-i18n";

const { t: $t } = useI18n()

const props = defineProps({
    product: {
        required: true,
    },
    userId: {
        required: true,
    }
});

const productModal = ref(false);

function hasImages(images) {
    return images.length > 0;
}

function getFirstImageUrl(images) {
    return AppUtils.getApiProductStorageUrl(images[0].image_path);
}

function getFirstImageName(images) {
    return images[0].name;
}


function getProductInfo() {
    showProductModal();
}

function hideProductModal() {
    productModal.value = false;
}

function showProductModal() {
    productModal.value = true;
}

function hasYoutubeLink() {
    return null != props.product.yt_link && props.product.yt_link.length > 0;
}

function hasCategory() {
    return null != props.product.category_id && props.product.category_id > 0;
}

function dateInGermany(date) {
    return DateFormatter.inGerman(date);
}

function reverseShowProduct(userProductId, product) {

    axios.post(route('customer.dashboard.reverse_product_view'), {
        user_product_id: userProductId
    })
        .then((response) => {
            if (response.status == 200) {
                Notifier.toastSuccess(response.data.message);
                product.is_hidden = !product.is_hidden;
            }
        });
}

function createBookSellingSignal() {
    Notifier.toastConfirm(
        $t('Interest in purchasing'),
        $t('If confirmed, we will contact you so that we can refer you further! Yes'),
        () => {
            axios.post(route('customer.book.inquiry'), {product_id: props.product.id, user_id: props.userId})
                .then((response) => {
                    if (response.status == 200) {
                        Notifier.toastSuccess(response.data.message, $t('Successful'));
                    }
                });
        },
        $t('Continue'),
        $t('Cancel')
    )

}

</script>
<style lang="scss">
</style>
