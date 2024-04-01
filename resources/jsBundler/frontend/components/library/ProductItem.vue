<template>
    <div class="product-wrapper cp-container mb-30">
        <div class="top-image-box">
            <div class="card">
                <div class="card-top-icon">
                    <span class="card-link ribbion">
                        <i class="fa fa-bookmark"></i>
                        <span class="card-number">{{ product.quantity }}</span>
                    </span>
                </div>
                <div class="cp-img-wrapper">
                <span class="cp-img-link" :href="getBookUrl(product.id, customerId)">
                    <img :src="getFirstImageUrl(product.images)"
                         :alt="getFirstImageName(product.images)"
                    />
                </span>
                </div>
                <div class="card-body cp-content">
                     <span class="card-link greenstatus">
                        <span class="green-top-txt">
                        {{ getConditionLabel(product.condition) }}
                        </span>
                    </span>
                    <h5 class="card-title">
                        <a v-tooltip="product.product_name"
                           :href="getBookUrl(product.id, customerId)"
                        >
                            {{ product.product_name }}
                        </a>
                    </h5>
                    <div class="cp-info">
                        <ul class="cp-info-links">
                            <li class="cp-info-item" v-if="hasProductInfo(product.note, product.user_product_note)">
                                <a href="#"
                                   class="card-link animate-right"
                                   @click.prevent="openProductInfo(product)"
                                   v-tooltip="'View details'"
                                >
                                    <i class="fa fa-info"></i>
                                </a>
                            </li>
                            <li class="cp-info-item" v-if="hasYoutubeLink(product.yt_link)">
                                <a href="#"
                                   class="card-link animate-right"
                                   @click.prevent="openProductYoutubeInfo(product)"
                                   v-tooltip="'Video betrachten'"
                                >
                                    <i class="fa fa-youtube-play"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                    <div class="card-links-list nav-pills nav-fill">
                        <a @click.prevent="openInquiryModal()" href="#" class="btn btn-interest">
                            <i class="fa fa fa-book mr-1"></i>
                            Kaufinteresse
                        </a>
                        <a :href="getBookUrl(product.id, customerId)"
                           class="btn-next"
                           v-tooltip="'Mehr erfahren'"
                        >
                            <i class="fa fa-long-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>

            <product-modal
                :product="selectedProduct"
                v-if="showProductInfo"
                @close-modal="closeProductInfo"
            ></product-modal>

            <product-youtube-modal
                :product="selectedProduct"
                v-if="showProductYoutubeInfo"
                @close-modal="closeProductYoutubeInfo"
            ></product-youtube-modal>

            <inquiry-modal
                :customer-id="customerId"
                :product-id="product.id"
                :config="config"
                v-if="showInquiryForm"
                @close-modal="closeInquiryModal"
            ></inquiry-modal>
        </div>
    </div>
</template>

<script>
import BoostrapMixin from "../../mixins/BoostrapMixin";
import ProductModal from "../showroom/__inc/ProductModal";
import InquiryModal from "../showroom/__inc/InquiryModal";
import ProductYoutubeModal from "../showroom/__inc/ProductYoutubeModal";

export default {

    props: {
        customerId: {
            required: true
        },
        product: {
            required: true
        },
        config: {
            required: true
        }
    },

    components: {
        ProductYoutubeModal,
        'product-modal': ProductModal,
        'inquiry-modal': InquiryModal,
        'product-youtube-modal': ProductYoutubeModal,
    },

    mixins: [BoostrapMixin],

    data() {
        return {
            showProductInfo: false,
            showProductYoutubeInfo: false,
            showInquiryForm: false,
            selectedProduct: {},
        }
    },


    mounted() {

    },

    methods: {

        getProductListing(page = 1) {

        },

        closeModal() {
            this.$emit('close-modal');
        },

        openProductYoutubeInfo(product) {
            this.selectedProduct = product;
            this.showProductYoutubeInfo = true;
            this.openBtModal();
        },

        closeProductYoutubeInfo() {
            this.showProductYoutubeInfo = false;
            this.closeBtModal();
        },

        openProductInfo(product) {
            this.selectedProduct = product;
            this.showProductInfo = true;
            this.openBtModal();
        },

        closeProductInfo() {
            this.showProductInfo = false;
            this.closeBtModal();
        },

        hasYoutubeLink() {
            if (this.product.yt_link != null) {
                return this.product.yt_link.length > 0;
            }
            return false;
        },

        hasProductInfo(note, user_product_note) {
            if (note != null || user_product_note != null) {
                return true;
            }
            return false;
        },

        openInquiryModal() {
            this.showInquiryForm = true;
            this.openBtModal();
        },

        closeInquiryModal() {
            this.showInquiryForm = false;
            this.closeBtModal();
        },

        getImageUrl(image) {
            return this.config.storageUrl + image;
        },

        getBookUrl(bookId, customerId) {
            return this.config.bookUrl + bookId + '?register=' + customerId;
        },

        getFirstImageUrl(images) {
            if (images.length > 0) {
                return this.config.storageUrl + images[0].image_path;
            }
            return this.config.emptyImageUrl;
        },

        getFirstImageName(images) {
            if (images.length > 0) {
                return images[0].image_path;
            }
            return '';
        },

        getConditionLabel(conditionNo) {
            let conditionLabel = '';
            for (let index in this.config.product_conditions) {
                if (this.config.product_conditions[index].value == conditionNo) {
                    conditionLabel = this.config.product_conditions[index].label;
                }
            }

            if (conditionLabel !== '') {
                return conditionLabel;
            }

            return this.config.product_condition_default;
        },

    }
}

</script>

<style></style>
