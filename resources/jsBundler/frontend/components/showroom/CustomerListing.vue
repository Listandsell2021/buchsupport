<template>
    <div class="customer-filter-container">

        <loading :active="isLoading"
                 :is-full-page="true"
        ></loading>

        <div v-for="customer in customers.data"
             :key="generateUId()"
        >
            <div class="shop-product-wrapper res-xl res-xl-btn" >
                <div class="shop-bar-area">
                <div class="shop-bar">
                    <div class="shop-found-selector">
                        <div class="shop-found">
                            <p>
                                <span v-if="customer.membership" class="special-vip"
                                :class="'member-style-'+customer.membership"
                                >{{ getCustomerMembership(customer.membership) }}</span>
                                <span class="vipid">ID</span>:
                                <span class="vip-value">{{ customer.uid }}</span>
                            </p>
                        </div>
                        <div class="shop-selector work-code">
                            <label>Werke : </label>
                            <div class="work-number">
                                <ul>
                                    <li class="work-digit">{{ customer.products_count }}</li>
                                </ul>
                            </div>
                        </div>
                        <div class="shop-selector library-look">

                            <div class="library-portal">
                                <ul>
                                    <a :href="getCustomerLibraryUrl(config, customer.id)">
                                        <li class="library-link">Sammlung genauer betrachten
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16"
                                                 height="16"
                                                 fill="currentColor" class="bi bi-arrow-right-circle"
                                                 viewBox="0 0 16 16">
                                                <path fill-rule="evenodd"
                                                      d="M1 8a7 7 0 1 0 14 0A7 7 0 0 0 1 8zm15 0A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM4.5 7.5a.5.5 0 0 0 0 1h5.793l-2.147 2.146a.5.5 0 0 0 .708.708l3-3a.5.5 0 0 0 0-.708l-3-3a.5.5 0 1 0-.708.708L10.293 7.5H4.5z"/>
                                            </svg>
                                        </li>
                                    </a>

                                </ul>
                            </div>
                        </div>
                    </div>

                </div>
                <div class="shop-product-content">
                    <div class="vip-carousel customer-search-carousel"
                         v-if="doesCustomerHaveProducts(customer.products)"
                    >
                        <Carousel :items="3"
                                  :nav="true"
                                  :dots="false"
                                  :margin="30"
                                  :responsive="config.slider_responsive"
                                  :navText="[
                                    '<i class=\'fa fa-angle-left\'></i>',
                                    '<i class=\'fa fa-angle-right\'></i>'
                                  ]"
                        >
                            <div class="product-wrapper cp-container mb-30"
                                 :key="generateUId()"
                                 v-for="product in customer.products"
                            >
                                <div class="top-image-box">
                                    <div class="card">
                                        <div class="card-top-icon">
                                            <span class="card-link ribbion">
                                                <i class="fa fa-bookmark"></i>
                                                <span class="card-number">{{ product.pivot.quantity }}</span>
                                            </span>
                                        </div>
                                        <div class="cp-img-wrapper">
                                            <a class="cp-img-link" :href="getBookUrl(config, product.id, customer.id)">
                                                <img :src="getFirstImageUrl(config, product.images)"
                                                     :alt="getFirstImageName(config, product.images)"
                                                />
                                            </a>
                                        </div>
                                        <div class="card-body cp-content">
                                            <span class="card-link greenstatus">
                                                {{ getConditionLabel(config, product.pivot.condition) }}
                                            </span>
                                            <h5 class="card-title">
                                                <a v-tooltip="product.name"
                                                   :href="getBookUrl(config, product.id, customer.id)"
                                                >
                                                    {{ product.name }}
                                                </a>
                                            </h5>
                                            <div class="cp-info">
                                                <ul class="cp-info-links">
                                                    <li class="cp-info-item" v-if="hasProductInfo(product)">
                                                        <a href="#"
                                                           class="card-link animate-right"
                                                           @click.prevent="openProductInfo(product)"
                                                           v-tooltip="'Details anzeigen'"
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
                                                <a @click.prevent="openInquiryModal(customer.id, product.id)"
                                                   class="btn btn-interest"
                                                   href="#"
                                                >
                                                    <i class="fa fa fa-book mr-1"></i>
                                                    Kaufinteresse
                                                </a>
                                                <a :href="getBookUrl(config, product.id, customer.id)"
                                                   class="btn-next"
                                                   v-tooltip="'Mehr erfahren'"
                                                >
                                                    <i class="fa fa-long-arrow-right"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </Carousel>
                    </div>
                </div>
            </div>
            </div>

        </div>

        <laravel-vue-pagination
            :data="customers"
            :limit="3"
            :show-disabled="true"
            @pagination-change-page="getCustomerListing"
        >
            <span slot="prev-nav">&lt; Zurück</span>
            <span slot="next-nav">Weiter &gt;</span>
        </laravel-vue-pagination>
    </div>
</template>

<script>
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import EventBus from "./../../mixins/EventBus";
import BoostrapMixin from "../../mixins/BoostrapMixin";
import SearchMixin from "./__inc/SearchMixin";
import ProductModal from "./__inc/ProductModal";
import ProductYoutubeModal from "./__inc/ProductYoutubeModal";
import InquiryModal from "./__inc/InquiryModal";
import { Carousel } from 'bgl-v-owl-carousel';
import Loading from 'vue3-loading-overlay';
import 'swiper/css';
import 'swiper/css/navigation';

export default {

    props: {
        config: {
            required: true,
        },
        filters: {
            required: true,
        },
    },

    components: {
        Carousel,
        'laravel-vue-pagination': Bootstrap5Pagination,
        'ProductModal': ProductModal,
        'InquiryModal': InquiryModal,
        'ProductYoutubeModal': ProductYoutubeModal,
        'loading': Loading,
    },

    mixins: [SearchMixin, BoostrapMixin],

    data() {
        return {
            customers: {},
            form: { page: 1 },
            selectedProduct: {},
            showProductInfo: false,
            showProductYoutube: false,
            showInquiryForm: false,
            customerId: '',
            productId: '',
            isLoading: false,
        }
    },

    computed: {},

    created() {
        this.form = this.filters;
    },

    mounted() {
        EventBus.on('SEARCH_ON_CUSTOMERS', (payload) => {
            this.form = payload;
            this.getCustomerListing();
        });
    },

    beforeUnmount() {
        EventBus.remove('SEARCH_ON_CUSTOMERS');
    },

    methods: {

        isUsersMoreThanOne(users) {
            return users.length > 1;
        },

        generateUId() {
            return "id" + Math.random().toString(16).slice(2);
        },

        getCustomerListing(page = 1) {

            this.isLoading = true;
            this.setPageNumber(page);

            axios.get(this.config.filterCustomersUrl, {
                params: this.form
            })
                .then((response) => {
                    if (response.status === 200) {
                        this.customers = response.data.data.customers;
                    }
                    this.isLoading = false;
                });
        },

        setPageNumber(page) {
            if (typeof page === 'number') {
                this.form.page = page;
            } else {
                this.form.page = 1;
            }
        },

        hasProductInfo(product) {
            if (product.note != null) {
                return true;
            }
            if (product.pivot.note != null) {
                return true;
            }
            return false;
        },

        hasYoutubeLink(link) {
            if (link != null) {
                return link.length > 0;
            }

            return false;
        },


        isInMiddle(customerId) {
            if (this.customers.data.length > 1) {
                if (this.customers.data[Math.round(this.customers.data.length/2)].id === customerId) {
                    return true
                }
            }
            return false;
        },

        openInquiryModal(customerId, productId) {
            EventBus.emit('OPEN_INQUIRY_MODAL', {
                customerId: customerId,
                productId: productId
            });
        },

        openProductInfo(product) {
            EventBus.emit('OPEN_PRODUCT_INFO_MODAL', product);
        },

        openProductYoutubeInfo(product) {
            EventBus.emit('OPEN_PRODUCT_YOUTUBE_MODAL', product);
        },

    }
}

</script>

<style></style>
