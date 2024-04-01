<template>
    <div class="search-container">
        <div>
            <InquiryModal
                v-if="showInquiryForm"
                :product-id="productId"
                :customer-id="customerId"
                :config="config"
                @close-modal="closeInquiryModal"
            ></InquiryModal>

            <ProductModal
                v-if="showProductInfo"
                :product="selectedProduct"
                @close-modal="closeProductInfo"
            ></ProductModal>

            <ProductYoutubeModal
                v-if="showProductYoutube"
                :product="selectedProduct"
                @close-modal="closeProductYoutubeInfo"
            ></ProductYoutubeModal>

        </div>
        <div class="header-bottom-furniture wrapper-padding-2 border-top-3">
            <div class="container book-filter">
                <div class="slider-animation slider-content-book fadeinup-animated">
                    <p class="animated-shop"><span>Alle </span> Sammlungen</p>
                </div>
                <div class="furniture-bottom-wrapper">
                    <div class="furniture-search">
                        <div class="form">
                            <input type="text"
                                   v-if="form.is_customer_selected"
                                   class="showroom-search-input"
                                   id="search-key"
                                   v-model="form.customer.search_key"
                                   placeholder="Ich suche nach ID..."
                                   @input="onSearchKeyChanged"
                            />
                            <input type="text"
                                   v-if="!form.is_customer_selected"
                                   class="showroom-search-input"
                                   id="search-key"
                                   v-model="form.product.search_key"
                                   placeholder="Ich suche nach..."
                                   @input="onSearchKeyChanged"
                            />
                            <button>
                                <i class="ti-search fa fa-search"></i>
                            </button>
                        </div>
                        <div class="toggle-selection">
                            <label class="switch">
                                <input type="checkbox" v-model="form.is_customer_selected" v-on:change="onSearchKeyChanged">
                                <span class="slider"></span>
                                <p class="off">Werke</p>
                                <p class="on">Mitgliedern</p>
                            </label>
                        </div>
                    </div>
                    <ul v-if="form.is_customer_selected" class="showroom-filter customer-filters">
                        <li>
                            <span @click.prevent="clearCustomerFilter" class="close-filter close-filter-btn" v-if="form.customer.is_filtering">
                                <svg width="16" height="16" fill="none" xmlns="http://www.w3.org/2000/svg"><path
                                d="M8 1C4.15 1 1 4.15 1 8s3.15 7 7 7 7-3.15 7-7-3.15-7-7-7zm3.063 8.838l-1.226 1.225L8 9.224l-1.838 1.838-1.224-1.226L6.774 8 4.937 6.162l1.225-1.224L8 6.774l1.838-1.838 1.225 1.225L9.224 8l1.838 1.838z"
                                fill="#929396"></path></svg>
                            </span>
                            <a @click.prevent="enableCustomerFilter" href="#">
                                <svg width="20" height="18" viewBox="0 0 22 20" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M21 1H1L9 10.46V17L13 19V10.46L21 1Z" stroke="#24262D" stroke-width="2"
                                          stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                                Filter
                            </a>
                        </li>
                        <li>
                            <span @click.prevent="clearCustomerSorting" class="close-sorting close-filter-btn" v-if="form.customer.is_sorting">
                                <svg width="16" height="16" fill="none" xmlns="http://www.w3.org/2000/svg"><path
                                    d="M8 1C4.15 1 1 4.15 1 8s3.15 7 7 7 7-3.15 7-7-3.15-7-7-7zm3.063 8.838l-1.226 1.225L8 9.224l-1.838 1.838-1.224-1.226L6.774 8 4.937 6.162l1.225-1.224L8 6.774l1.838-1.838 1.225 1.225L9.224 8l1.838 1.838z"
                                    fill="#929396"></path></svg>
                            </span>
                            <a @click.prevent="enableCustomerSorting" href="#">
                                <svg width="18" height="14" viewBox="0 0 18 14" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M5.08325 5.83361L5.08325 14L3.58325 14L3.58325 5.83361H0.833496L4.33353 0.000218391L7.83356 5.83361H5.08325Z"
                                          fill="#24262D"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M14.417 8.16638L14.417 6.55637e-08L12.917 0L12.917 8.16638H10.1672L13.6673 13.9998L17.1673 8.16638H14.417Z"
                                          fill="#24262D"></path>
                                </svg>
                                Sortierung
                            </a>
                        </li>
                    </ul>

                    <ul v-else class="showroom-filter product-filters">
                        <li>
                            <span @click.prevent="clearProductFilter" class="close-filter close-filter-btn" v-if="form.product.is_filtering">
                                <svg width="16" height="16" fill="none" xmlns="http://www.w3.org/2000/svg"><path
                                    d="M8 1C4.15 1 1 4.15 1 8s3.15 7 7 7 7-3.15 7-7-3.15-7-7-7zm3.063 8.838l-1.226 1.225L8 9.224l-1.838 1.838-1.224-1.226L6.774 8 4.937 6.162l1.225-1.224L8 6.774l1.838-1.838 1.225 1.225L9.224 8l1.838 1.838z"
                                    fill="#929396"></path></svg>
                            </span>
                            <a @click.prevent="enableProductFilter" href="#">
                                <svg width="20" height="18" viewBox="0 0 22 20" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path d="M21 1H1L9 10.46V17L13 19V10.46L21 1Z" stroke="#24262D" stroke-width="2"
                                          stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                                Filter
                            </a>
                        </li>
                        <li>
                            <span @click.prevent="clearProductSorting" class="close-sorting close-filter-btn" v-if="form.product.is_sorting">
                                <svg width="16" height="16" fill="none" xmlns="http://www.w3.org/2000/svg"><path
                                    d="M8 1C4.15 1 1 4.15 1 8s3.15 7 7 7 7-3.15 7-7-3.15-7-7-7zm3.063 8.838l-1.226 1.225L8 9.224l-1.838 1.838-1.224-1.226L6.774 8 4.937 6.162l1.225-1.224L8 6.774l1.838-1.838 1.225 1.225L9.224 8l1.838 1.838z"
                                    fill="#929396"></path></svg>
                            </span>
                            <a @click.prevent="enableProductSorting" href="#">
                                <svg width="18" height="14" viewBox="0 0 18 14" fill="none"
                                     xmlns="http://www.w3.org/2000/svg">
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M5.08325 5.83361L5.08325 14L3.58325 14L3.58325 5.83361H0.833496L4.33353 0.000218391L7.83356 5.83361H5.08325Z"
                                          fill="#24262D"></path>
                                    <path fill-rule="evenodd" clip-rule="evenodd"
                                          d="M14.417 8.16638L14.417 6.55637e-08L12.917 0L12.917 8.16638H10.1672L13.6673 13.9998L17.1673 8.16638H14.417Z"
                                          fill="#24262D"></path>
                                </svg>
                                Sortierung
                            </a>
                        </li>
                    </ul>
                </div>

                <div class="customer-form-filter" v-if="form.is_customer_selected">
                    <div class="form-filter-lists row" v-if="form.customer.is_filtering == true">
                        <div class="form-filter-item col-md-3">
                            <div class="filter-by-work clearfix">
                                <label>Werke</label>
                                <VueSimpleRangeSlider
                                    :min="form.customer.product_range_min"
                                    :max="form.customer.product_range_max"
                                    v-model="form.customer.product_range"
                                    @update:model-value="onProductRangeChange"
                                />
                            </div>
                        </div>
                        <div class="form-filter-item col-md-3">
                            <div class="filter-by-work clearfix">
                                <label>Mitgliedern</label>
                                <v-select
                                    id="membership_ids"
                                    :options="config.getMemberships"
                                    v-model="form.customer.membership_ids"
                                    :reduce="(membership) => membership.id"
                                    label="name"
                                    placeholder="Mitgliedern auswählen"
                                    @update:model-value="onCustomerMembershipChange"
                                    multiple
                                />
                            </div>
                        </div>
                    </div>
                    <div class="form-sorting-lists row" v-if="form.customer.is_sorting == true">
                        <div class="form-sorting-item col-md-3">
                            <div class="sort-by-work clearfix">
                                <label>Sortieren nach</label>
                                <select v-model="form.customer.sort_by" @change.prevent="onCustomerSortingChange"  class="form-control">
                                    <option value=""></option>
                                    <option :value="sorting_item.value" v-for="sorting_item in form.customer.sorting_lists"
                                    >
                                        {{ sorting_item.label }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-sorting-item col-md-3">
                            <div class="sort-order clearfix">
                                <label>Sortierung</label>
                                <select v-model="form.customer.sort_order" @change.prevent="onCustomerSortingOrderChange" class="form-control">
                                    <option value=""></option>
                                    <option :value="sorting_order_item.value" v-for="sorting_order_item in form.customer.sorting_order_list"
                                    >
                                        {{ sorting_order_item.label }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="product-form-filter" v-else>
                    <div class="form-filter-lists row" v-if="form.product.is_filtering == true">
                        <div class="form-filter-item col-md-3">
                            <div class="filter-by-category clearfix">
                                <label>Kategorie</label>
                                <v-select
                                    id="category_ids"
                                    :options="config.getCategories"
                                    v-model="form.product.category_ids"
                                    :reduce="category => category.id"
                                    label="name"
                                    placeholder="Kategorie auswählen"
                                    @update:model-value="onProductCategorySelection"
                                    multiple
                                />
                            </div>
                        </div>
                    </div>
                    <div class="form-sorting-lists row" v-if="form.product.is_sorting == true">
                        <div class="form-sorting-item col-md-3">
                            <div class="sort-by-category clearfix">
                                <label>Sortieren nach</label>
                                <select v-model="form.product.sort_by" @change="onProductSortingChange"  class="form-control">
                                    <option value=""></option>
                                    <option :value="sorting_item.value" v-for="sorting_item in form.product.sorting_lists"
                                    >
                                        {{ sorting_item.label }}
                                    </option>
                                </select>
                            </div>
                        </div>
                        <div class="form-sorting-item col-md-3">
                            <div class="sort-order clearfix">
                                <label>Sortierung</label>
                                <select v-model="form.product.sort_order" @change="onProductSortingOrderChange" class="form-control">
                                    <option value=""></option>
                                    <option :value="sorting_order_item.value" v-for="sorting_order_item in form.product.sorting_order_list"
                                    >
                                        {{ sorting_order_item.label }}
                                    </option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="shop-page-wrapper">

            <div v-if="form.is_customer_selected">
                <CustomerListing
                    :config="config"
                    :filters="form.customer"
                ></CustomerListing>
            </div>

            <div v-else>
                <ProductListing
                    :config="config"
                    :filters="form.product"
                ></ProductListing>
            </div>

        </div>


    </div>
</template>

<script>
import EventBus from "../../mixins/EventBus";
import CustomerListing from './CustomerListing';
import ProductListing from "./ProductListing";
import VueSimpleRangeSlider from "vue-simple-range-slider";
import BoostrapMixin from "../../mixins/BoostrapMixin";
import vSelect from 'vue-select';
import 'vue-select/dist/vue-select.css';
import 'floating-vue/dist/style.css'
import InquiryModal from "./__inc/InquiryModal.vue";
import ProductModal from "./__inc/ProductModal.vue";
import ProductYoutubeModal from "./__inc/ProductYoutubeModal.vue";
import passwordGenerator from "@/libraries/utils/helpers/PasswordGenerator";

export default {
    computed: {
        passwordGenerator() {
            return passwordGenerator
        }
    },

    props: {
        config: {
            required: true,
        },
    },

    components: {
        ProductYoutubeModal, ProductModal, InquiryModal,
        CustomerListing,
        ProductListing,
        VueSimpleRangeSlider,
        'v-select': vSelect,
    },

    mixins: [BoostrapMixin],

    data() {
        return {
            form: {
                is_customer_selected: true,
                customer: {
                    search_key: '',
                    is_filtering: false,
                    is_sorting: false,
                    membership_ids: [],
                    product_range: [0, 0],
                    product_range_min: 0,
                    product_range_max: 100,
                    sorting_lists: [],
                    sorting_order_list: [],
                    sort_by: '',
                    sort_order: '',
                    page: 1,
                },
                product: {
                    search_key: '',
                    is_filtering: false,
                    is_sorting: false,
                    category_ids: [],
                    sorting_lists: [],
                    sorting_order_list: [],
                    sort_by: '',
                    sort_order: '',
                    page: 1
                },
            },
            debounceController: null,
            showInquiryForm: false,
            showProductInfo: false,
            showProductYoutube: false,
            selectedProduct: {},
            customerId: 0,
            productId: 0
        }
    },

    async created() {
        this.form.is_customer_selected = this.config.isSearchByCustomer;
        console.log(this.config.isSearchByCustomer);
        await this.setCustomerInitialFields();
        await this.setProductInitialFields();

        this.registerEvents();

        if (this.config.isSearchByCustomer) {
            this.sendEventForCustomerSearch();
        } else {
            this.sendEventForProductSearch();
        }
    },

    methods: {

        setCustomerInitialFields() {
            this.form.customer = this.config.customer_fields;
        },

        setProductInitialFields() {
            this.form.product = this.config.product_fields;
        },

        registerEvents() {
            EventBus.on('OPEN_INQUIRY_MODAL', (obj) => {
                this.openInquiryModal(obj.customerId, obj.productId);
            });
            EventBus.on('OPEN_PRODUCT_INFO_MODAL', (product) => {
                this.openProductInfo(product);
            });
            EventBus.on('OPEN_PRODUCT_YOUTUBE_MODAL', (product) => {
                this.openProductYoutubeInfo(product);
            });
        },

        onSearchKeyChanged() {
            clearTimeout(this.debounceController);
            this.debounceController = setTimeout(() => {
                if (this.form.is_customer_selected) {
                    this.sendEventForCustomerSearch();
                } else {
                    this.sendEventForProductSearch();
                }
            }, this.config.debounce_time);
        },

        sendEventForCustomerSearch() {
            EventBus.emit('SEARCH_ON_CUSTOMERS', this.form.customer);
        },

        sendEventForProductSearch() {
            EventBus.emit('SEARCH_ON_PRODUCTS', this.form.product);
        },

        resetCustomerFilters() {
            this.form.customer.is_filtering = false;
            this.form.customer.product_range = [this.form.customer.product_range_min, this.form.customer.product_range_max];
            this.form.customer.membership_ids = [];
        },

        resetCustomerSorting() {
            this.form.customer.is_sorting = false;
            this.form.customer.sort_by = '';
            this.form.customer.sort_order = '';
        },

        resetProductFilters() {
            this.form.product.is_filtering = false;
            this.form.product.category_ids = [];
        },

        resetProductSorting() {
            this.form.product.is_sorting = false;
            this.form.product.sort_by = '';
            this.form.product.sort_order = '';
        },

        disableCustomerFilter() {
            this.form.customer.is_filtering = false;
        },

        disableProductFilter() {
            this.form.product.is_filtering = false;
        },

        disableCustomerSorting() {
            this.form.customer.is_sorting = false;
        },

        disableProductSorting() {
            this.form.product.is_sorting = false;
        },

        async clearCustomerFilter() {
            await this.resetCustomerFilters();
            this.sendEventForCustomerSearch();
            this.disableCustomerFilter();
        },

        async clearCustomerSorting() {
            await this.resetCustomerSorting();
            this.sendEventForCustomerSearch();
            this.disableCustomerSorting();
        },

        async clearProductFilter() {
            await this.resetProductFilters();
            this.sendEventForProductSearch();
            this.disableProductFilter();
        },

        async clearProductSorting() {
            await this.resetProductSorting();
            this.sendEventForProductSearch();
            this.disableProductSorting();
        },

        enableCustomerFilter() {
            this.form.customer.is_filtering = true;
        },

        enableCustomerSorting() {
            this.form.customer.is_sorting = true;
        },

        enableProductFilter() {
            this.form.product.is_filtering = true;
        },

        enableProductSorting() {
            this.form.product.is_sorting = true;
        },

        openInquiryModal(customerId, productId) {
            this.customerId = customerId;
            this.productId = productId;
            this.showInquiryForm = true;
            this.openBtModal();
        },

        closeInquiryModal() {
            this.showInquiryForm = false;
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

        openProductYoutubeInfo(product) {
            this.selectedProduct = product;
            this.showProductYoutube = true;
            this.openBtModal();
        },

        closeProductYoutubeInfo() {
            this.showProductYoutube = false;
            this.closeBtModal();
        },

        onProductRangeChange(data) {
            clearTimeout(this.debounceController);
            this.debounceController = setTimeout(() => {
                if (data[1] > this.config.customer_fields.product_range_min) {
                    this.enableCustomerFilter();
                    this.sendEventForCustomerSearch();
                } else {
                    this.disableCustomerFilter();
                }
            }, this.config.debounce_time);
        },

        onCustomerMembershipChange() {
            this.enableCustomerFilter();
            this.sendEventForCustomerSearch();
        },

        onCustomerSortingChange() {
            if (this.form.customer.sort_by.length > 0) {
                this.enableCustomerSorting();
                this.sendEventForCustomerSearch();
            } else {
                this.disableCustomerSorting();
            }
        },

        onCustomerSortingOrderChange() {
            if (this.form.customer.sort_by.length > 0) {
                this.enableCustomerSorting();
                this.sendEventForCustomerSearch();
            } else {
                this.disableCustomerSorting();
            }
        },

        onProductCategorySelection() {
            this.sendEventForProductSearch();
        },

        onProductSortingChange() {
            if (this.form.product.sort_by.length > 0) {
                this.enableProductSorting();
                this.sendEventForProductSearch();
            } else {
                this.disableProductSorting();
            }
        },

        onProductSortingOrderChange() {
            if (this.form.product.sort_by.length > 0) {
                this.enableProductSorting();
                this.sendEventForProductSearch();
            } else {
                this.disableProductSorting();
            }
        },

    }
}

</script>

<style></style>
