<template>
    <div>
        <div class="card-wrapper">
            <div class="row">
                <div class="col-md-4 col">
                    <div class="fill-height" v-if="!user.membership">
                        <h5 class="text-h6">
                            Hallo, {{ user.last_name }}
                        </h5>
                        <p class="text-body-1">
                            ID: {{ user.uid }}
                            <br/>
                            Registrierungsdatum: {{ user.created_at }}
                        </p>
                    </div>

                    <div v-else class="membership-card" :class="'membership-'+user.membership">
                        <div class="row">
                            <div class="col-4">
                                <p>
                                    Mitgliedschaft: {{ $t(user.membership) }}
                                </p>
                            </div>
                            <div class="offset-3 col-5">
                                <div class="membership-logo text-center">
                                    <img src="/assets/customer/images/logo-transparent.png" alt="Logo"/>
                                    <p class="membership-logo-text">Buch-Kunstregister</p>
                                </div>
                            </div>
                            <div class="col-12 mt-n5">
                                <p>
                                    <small>Name</small>
                                    <br/>
                                    {{ user.first_name }} {{ user.last_name }}
                                </p>
                                <p>
                                    <small>Registrierungsn-Nr.</small>
                                    <br/>
                                    {{ HelperUtils.formatUserId(user.uid) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="fill-height v-card v-sheet theme--light">
                        <div class="v-card__title text-h6">
                            Sammlung
                        </div>
                        <div class="v-card__text">
                            <p>Werke<br>{{ statistic.countProducts }}</p>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="fill-height v-card v-sheet theme--light">
                        <div class="v-card__title text-h6">
                            Zustand
                        </div>
                        <div class="v-card__text">
                            <p v-if="statistic.avgCondition">
                                Ø Zustand
                            </p>
                            <div class="progress">
                                <div class="progress-bar bg-primary" role="progressbar" :style="{width: getConditionInPercentage(statistic.avgCondition, statistic.countProducts)+'%'}" aria-valuenow="75" aria-valuemin="0" aria-valuemax="100">
                                    {{ getConditionInPercentage(statistic.avgCondition, statistic.countProducts) }}%
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col">
                    <div class="fill-height v-card v-sheet theme--light">
                        <div class="v-card__title text-h6">Gesamt</div>
                        <div class="v-card__text">
                            <p v-if="statistic.sumProducts">
                                <span v-html="HelperUtils.getCurrency(statistic.sumProducts, 0)"></span>
                            </p>
                            <p v-if="statistic.avgPrice">
                                Durchschnittspreis: <br/>
                                <span v-html="HelperUtils.getCurrency(statistic.avgPrice, 0)"></span>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="ur-comment">
            <div class="add-ur-comment">
                <h3 class="urc-title">{{ $t('Your comments') }}</h3>
            </div>
            <div class="list-ur-comments">

                <template v-if="comments.length > 0">
                    <template v-for="comment in comments">
                        <div class="custom__card__alt">
                            <div class="custom__card__alt--body">
                                <p>{{ comment.text }}</p>
                                <div>Status:
                                    <span class="label" :class="{ 'label-success': comment.approved, 'label-danger': !comment.approved}">
                                    {{ !comment.approved ? 'Nicht freigegeben' : 'Freigegeben' }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    </template>
                </template>
                <template v-else>
                    <p>
                        Sie haben noch kein Kommentar zu unserem Service verfasst.
                    </p>

                    <button class="ui-button mt-2 btn btn-primary"
                            @click.prevent="openCommentModal"
                    >
                        <i class="md-icon mdi mdi-plus-circle-outline"></i>
                        <span>Kommentar verfassen</span>
                    </button>
                </template>

            </div>
        </div>

        <CommentModal v-if="commentModal"
                      @close="closeCommentModal"
                      @reload="getCommentList()"
        ></CommentModal>

        <div class="user-library-container">
            <div class="user-library-header">
                <h3 class="user-library-title">Sammlung von: 9585285517365166</h3>
                <div class="row">
                    <div class="col">
                        <div class="form-group">
                            <label for="search">Suchen</label>
                            <input id="search"
                                   class="form-control"
                                   v-model="form.search_key"
                                   @input="inputChanged"
                            />
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="conditions">Zustand</label>
                            <BsSelect
                                id="conditions"
                                :options="productConditions"
                                v-model="form.conditions"
                                :reduce="condition => condition.value"
                                :placeholder="$t('Select conditions')"
                                @update:model-value="inputChanged"
                                multiple
                            ></BsSelect>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="category_ids">Kategories</label>
                            <BsSelect
                                v-model="form.category_ids"
                                :options="productCategories"
                                label="name"
                                multiple
                                :reduce="category => category.id"
                                :clearable="false"
                                @update:model-value="inputChanged"
                                :placeholder="$t('Select categories')"
                            ></BsSelect>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="sort_column">Sortiere nach</label>
                            <select v-model="form.sort_column"
                                    @change="inputChanged"
                                    id="sort_column"
                                    class="form-control"
                            >
                                <option value=""></option>
                                <option v-for="column in sortColumns" :value="column.value">{{ column.label }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        <div class="form-group">
                            <label for="sort_order">Sortierung</label>
                            <select v-model="form.sort_order"
                                    id="sort_order"
                                    @change="inputChanged"
                                    class="form-control"
                            >
                                <option value=""></option>
                                <option value="asc">Aufsteigend</option>
                                <option value="desc">Absteigend</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="user-library-content">
                <div class="mb-5">
                    <Bootstrap5Pagination :data="userProducts.data"
                                          :limit="PaginationSetting.pagination_bar_limit"
                                          @pagination-change-page="getFilteredProducts"
                    ></Bootstrap5Pagination>
                </div>

                <div class="row">
                    <div class="col-md-3" v-for="(product, index) in userProducts.data" :key="product.user_product_id">
                        <ProductItem
                            :product="product"
                            :user-id="form.user_id"
                        ></ProductItem>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script setup>
import {onMounted, ref} from "vue";
import route from '@/libraries/utils/ZiggyRoute';
import axios from '@/libraries/utils/clientapi/axios';
import HelperUtils from "@/libraries/utils/helpers/HelperUtils";
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import buchConfig from "@/storage/data/buch";
import PaginationSetting from "@/storage/data/paginationSetting";
import ProductItem from "@/components/customer/dashboard/ProductItem";
import CommentModal from "@/components/customer/dashboard/CommentModal";
import debounce from 'lodash/debounce';
import {useAuth} from "@/composables/useAuth";
import BtModalHelper from "@/libraries/utils/BtModalHelper";
import {useI18n} from "vue-i18n";
import {useMeta} from "vue-meta";

const {t: $t} = useI18n();
useMeta({ title: $t('Customer Dashboard') });
const {user, isLoggedIn} = useAuth('customer');
const statistic = ref({
    avgCondition: 0,
    avgPrice: "0",
    countProducts: 0,
    countTotalProducts: "0",
    sumProducts: "110,30",
});

const productCategories = ref([]);
const userProducts = ref({ data: [] });
const comments = ref([]);
const commentModal = ref(false);
const productConditions = ref(buchConfig.productConditions);


const sortColumns = ref([
    {label: 'Titel', value: 'products.name'},
    {label: 'Position', value: 'user_products.position'},
    {label: 'Zustand', value: 'user_products.condition'},
]);

const form = ref({
    user_id: user.id,
    search_key: '',
    conditions: [],
    category_ids: [],
    sort_column: '',
    sort_order: '',
    page: 1,
});

function getConditionInPercentage(average, total) {
    const percentageValue = (average / total) * 100
    return Math.round(percentageValue);
}

function getCardsDetails() {
    axios.post(route('customer.dashboard.cards'), form.value, {}, true).then(response => {
        statistic.value = response.data.data;
    });
}

function getProductCategories() {
    axios.post(route('customer.dashboard.product_categories'), form.value).then(response => {
        productCategories.value = response.data.data;
    });
}

function getFilteredProducts() {
    axios.post(route('customer.dashboard.search_products'), form.value).then(response => {
        userProducts.value = response.data.data;
    });
}

function getCommentList() {
    axios.post(route('customer.dashboard.comments')).then(response => {
        comments.value = response.data.data;
    });
}

function openCommentModal() {
    BtModalHelper.open();
    commentModal.value = true;
}

function closeCommentModal() {
    commentModal.value = false;
    BtModalHelper.close();
}

const inputChanged = debounce(() => {
    getFilteredProducts();
}, 600);


onMounted(async () => {
    getCardsDetails();
    getCommentList();
    getProductCategories();
    getFilteredProducts();
})

</script>