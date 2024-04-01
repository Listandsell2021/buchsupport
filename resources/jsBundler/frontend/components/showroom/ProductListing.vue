<template>
    <div class="product-filter-container">

        <loading :active="isLoading"
                 :is-full-page="true"
        ></loading>

        <div class="res-xl res-xl-btn">
            <div class="row">
                <div class="col-sm-4 col-md-3" v-for="product in products.data" :key="product.id">
                    <div class="book-box">
                        <a :href="getBookUrl(config, product.id)">
                            <div class="bb-img-container">
                                <figure class="bb-img-figure">
                                    <img :src="getFirstImageUrl(config, product.images)"
                                         :alt="getFirstImageName(config, product.images)"
                                    />
                                </figure>
                            </div>
                        </a>
                        <div class="bb-description">
                            <div>
                                <a :href="getBookUrl(config, product.id, '')" class="bb-title">{{ product.product_name }}</a>
                                <small class="bb-category-title">{{ product.category_name }}</small>
                            </div>
                            <a @click.prevent="openInquiryModal(product.id)" href="#" class="btn btn-interest btn-custom-interest">
                                <i class="fa fa fa-book mr-1"></i>
                                Kaufinteresse
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <book-inquiry-modal
            v-if="showInquiryForm"
            :product-id="productId"
            :config="config"
            @close-modal="closeInquiryModal"
        ></book-inquiry-modal>

        <laravel-vue-pagination
            :data="products"
            :limit="3"
            :show-disabled="true"
            @pagination-change-page="getProductListing"
        >
            <span slot="prev-nav">&lt; Bisherige</span>
            <span slot="next-nav">Nächster &gt;</span>
        </laravel-vue-pagination>

    </div>
</template>

<script>
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import SearchMixin from "./__inc/SearchMixin";
import BookInquiryModal from "./__inc/BookInquiryModal";
import EventBus from "../../mixins/EventBus";
import loading from "vue3-loading-overlay";

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
        loading,
        'laravel-vue-pagination': Bootstrap5Pagination,
        'book-inquiry-modal': BookInquiryModal,
    },

    mixins: [SearchMixin],

    data() {
        return {
            products: {},
            form: {},
            isLoading: false,
            showInquiryForm: false,
            customerId: '',
            productId: '',
        }
    },

    computed: {},

    created() {
        this.form = this.filters;
    },

    mounted() {
        EventBus.on('SEARCH_ON_PRODUCTS',(payload) => {
            this.form = payload;
            this.getProductListing();
        });
    },

    beforeUnmount() {
        EventBus.remove('SEARCH_ON_PRODUCTS');
    },

    methods: {

        getProductListing(page = 1) {

            this.isLoading = true;
            this.setPageNumber(page);

            axios.get(this.config.filterProductsUrl, {
                params: this.form
            })
                .then((response) => {
                    if (response.status === 200) {
                        this.products = response.data.data;
                        this.isLoading = false;
                    }
                });
        },

        setPageNumber(page) {

            if (typeof page === 'number') {
                this.form.page = page;
            } else {
                this.form.page = 1;
            }
        },

        openInquiryModal(productId) {
            this.productId = productId;
            this.showInquiryForm = true;
        },

        closeInquiryModal() {
            this.showInquiryForm = false;
        },

    }
}

</script>

<style></style>
