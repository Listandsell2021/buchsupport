<template>

    <div>
        <CreateProductModal
            v-if="createProductModal"
            :lead-id="props.leadId"
            @close="closeCreateProductModal"
            @reload-products="reloadProductsAndAddProducts"
        ></CreateProductModal>

        <CreateProductCategoryModal
            v-if="createProductCategoryModal"
            :lead-id="props.leadId"
            @close="closeCreateProductCategoryModal"
            @reload-products="reloadProductsAndAddProducts"
        ></CreateProductCategoryModal>

        <EditProductModal
            v-if="editProductModal.show"
            :product-id="editProductModal.product_id"
            @close="closeEditProductModal"
            @reload-products="reloadProductsAndAddProducts"
        ></EditProductModal>

        <EditProductCategoryModal
            v-if="editProductCategoryModal.show"
            :category-id="editProductCategoryModal.category_id"
            @close="closeEditProductCategoryModal"
            @reload-products="reloadProductsAndAddProducts"
        ></EditProductCategoryModal>

        <div class="top-smart-list contract-box">

            <div class="ts-list-header">
                <a href="#" class="ts-list-close" @click.prevent="closeModal"><i class="fa fa-close"></i></a>
                <h3 class="ts-list-title">{{ $t('Lead Contract') }}</h3>
            </div>
            <div class="ts-list-body">

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="document">{{ $t('Contract Document') }}</label>
                            <div>
                                <input type="file"
                                       value=""
                                       placeholder="Document"
                                       ref="documentFile"
                                       @change="updateContractDocument"
                                />
                                <template v-if="hasDocument()">
                                    <div class="m-t-10">
                                        <a href="#" @click.prevent="downloadDocument">
                                            <i class="fa fa-file"></i>
                                            {{ form.document_name }}
                                        </a>
                                    </div>
                                </template>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="document">{{ $t('Contract Document') }}</label>
                            <BsSelect
                                v-model="form.membership"
                                :options="memberships"
                                label="name"
                                :reduce="membership => membership.id"
                                @update:model-value="updateMembership"
                                :clearable="false"
                                :placeholder="$t('Select Membership')"
                            ></BsSelect>
                        </div>
                    </div>
                </div>

                <div class="clearfix m-b-15">
                    <a href="#" class="btn pull-right m-l-15 btn-primary btn-sm"
                       @click.prevent="openCreateProductModal()"
                    >
                        <i class="fa fa-plus"></i>
                        {{ $t('Add New Product') }}
                    </a>
                    <a href="#" class="btn pull-right m-l-15 btn-primary btn-sm"
                       @click.prevent="openCreateProductCategoryModal()"
                    >
                        <i class="fa fa-plus"></i>
                        {{ $t('Add New Category') }}
                    </a>
                </div>

                <div class="row">
                    <div class="col-md-7 offset-md-5">
                        <table class="table table-striped table-bordered" v-if="addedProducts.length > 0">
                            <thead>
                            <tr>
                                <th>{{ $t('Type') }}</th>
                                <th>{{ $t('Name') }}</th>
                                <th>{{ $t('Action') }}</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="addedProduct in addedProducts">
                                <td>{{ addedProduct.type }}</td>
                                <td>{{ addedProduct.product_name }}{{ addedProduct.category_name }}</td>
                                <td>
                                    <a href="#" class="btn btn-xs btn-primary m-r-10"
                                       @click.prevent="editAddedProduct(addedProduct)"
                                    >
                                        <i class="fa fa-edit"></i>
                                    </a>
                                    <a href="#" class="btn btn-xs btn-danger"
                                       @click.prevent="deleteAddedProduct(addedProduct.id)"
                                    >
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="m-t-20 m-b-20">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>{{ $t('Product Name') }}</th>
                            <th>{{ $t('Quantity') }}</th>
                            <th>{{ $t('Quality') }}</th>
                            <th>{{ $t('Price') }}</th>
                            <th>{{ $t('Action') }}</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr :key="product.product_id" v-for="(product, productIndex) in form.product_items">
                            <td>
                                <BsSelect
                                    class="contract-fs"
                                    v-model="product.product_id"
                                    :options="useProductStore().products"
                                    label="name"
                                    :reduce="product => product.id"
                                    :clearable="false"
                                    :placeholder="$t('Select Product')"
                                ></BsSelect>
                            </td>
                            <td>
                                <input class="form-control contract-fc"
                                       v-model="product.quantity"
                                       type="number"
                                       min="1"
                                       :placeholder="$t('Enter Quantity')"
                                />
                            </td>
                            <td>
                                <div>
                                    <i v-for="number in product.condition"
                                       class="product-form-star fa fa-star"
                                    ></i>
                                </div>
                                <div>
                                    <div class="btn-group product-form-condition-action">
                                        <button class="btn btn-primary btn-xs"
                                                @click.prevent="decreaseProductCondition(product)">
                                            <i class="fa fa-minus"></i>
                                        </button>
                                        <button class="btn btn-primary btn-xs"
                                                @click.prevent="increaseProductCondition(product)">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td>
                                <input class="form-control contract-fc"
                                       v-model="product.price"
                                       type="number"
                                       min="1"
                                       :placeholder="$t('Enter Price')"
                                />
                            </td>
                            <td>
                                <a href="#"
                                   class="btn btn-xs btn-danger"
                                   @click.prevent="deleteProduct(productIndex)"
                                >
                                    <i class="fa fa-trash"></i>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <td colspan="6">
                                <div class="clearfix">
                                    <a href="#"
                                       @click.prevent="addProduct"
                                       class="btn btn-primary btn-xs pull-right"
                                    >
                                        <i class="fa fa-plus"></i>
                                    </a>
                                </div>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>

                <div class="clearfix">
                    <button v-if="false" @click.prevent="updateContract" class="btn btn-primary m-t-30">{{ $t('Update') }}</button>
                    <button @click.prevent="requestForNewCustomer" class="btn btn-primary pull-right m-t-30">
                        {{ $t('Request New Customer') }}
                    </button>
                </div>
            </div>
        </div>
    </div>

</template>

<script setup>
import {onMounted, ref} from "vue";
import axios from "@/libraries/utils/clientapi/axios";
import AppUtils from "@/libraries/utils/helpers/AppUtils";
import route from '@/libraries/utils/ZiggyRoute';
import Notifier from "@/libraries/utils/Notifier";
import {onClickOutside} from '@vueuse/core';
import {useMembershipStore} from "@/storage/store/memberships";
import {useProductStore} from "@/storage/store/products";
import {useNotificationStore} from '@/storage/store/notifications';
import BtModalHelper from "@/libraries/utils/BtModalHelper";
import CreateProductModal from "@/components/admin/Lead/CreateProductModal";
import CreateProductCategoryModal from "./CreateProductCategoryModal";
import EditProductModal from "./EditProductModal";
import EditProductCategoryModal from "./EditProductCategoryModal";
import HelperUtils from "@/libraries/utils/helpers/HelperUtils";
import {useI18n} from "vue-i18n";
import {useRouter} from "vue-router";

const emit = defineEmits(['close', 'reload-lead']);
const props = defineProps({
    leadId: {
        required: true
    }
});

const {t: $t} = useI18n();
const router = useRouter();
let createProductModal = ref(false);
let createProductCategoryModal = ref(false);
let editProductModal = ref({
    product_id: 0,
    show: false,
});
let editProductCategoryModal = ref({
    category_id: 0,
    show: false,
});
const modalDialog = ref(null);
const contract = ref(null);
const documentFile = ref(null);
const memberships = await useMembershipStore().getMembershipsByRefresh();
let addedProducts = ref([]);

const form = ref({
    lead_id: props.leadId,
    contract_id: 0,
    membership: "",
    document: "",
    document_name: "",
    product_items: [],
});

onClickOutside(modalDialog, () => {
    closeModal();
})

function updateContract() {
    axios.post(route('admin.leads.update_contract_products'), {
        contract_id: form.value.contract_id,
        products: form.value.product_items
    })
        .then((response) => {
            if (response.status === 200) {
                Notifier.toastSuccess(response.data.message);
            }
        });
}

function requestForNewCustomer() {

    let formData = new FormData();
    formData.append('lead_id', props.leadId);
    formData.append('contract_id', form.value.contract_id);
    formData.append('document', form.value.document);
    formData.append('membership', form.value.membership);
    let productFormIndex = 0;
    for (const productItem of form.value.product_items) {
        Object.entries(productItem).forEach(([key, value]) => {
            formData.append('products['+productFormIndex+']['+key+']', value);
        });
        ++productFormIndex;
    }

    axios.post(route('admin.leads.request_new_customer'), formData)
        .then((response) => {
            if (response.status === 200) {
                Notifier.toastSuccess(response.data.message);
                useNotificationStore().refreshNotifications();
                closeModalAndReload();
            }
        });
}

function getContractDetail() {
    axios.post(route('admin.leads.get_contract'), {
        lead_id: props.leadId
    })
        .then((response) => {
            if (response.status === 200) {
                if (!HelperUtils.isEmptyArray(response.data.data)) {
                    contract.value = response.data.data;
                    setContractForm(contract.value);
                }
            }
        });
}

function downloadDocument() {
    axios.postDownload(route('admin.leads.download_contract_doc'), {
        contract_id: form.value.contract_id
    })
        .then((response) => {
            if (response.status === 200) {
                HelperUtils.blobFileDownload(response, form.value.document_name);
            }
        });
}

function updateContractDocument(event) {

    form.value.document = event.target.files[0];

    /*let formData = new FormData();
    formData.append('lead_id', form.value.lead_id);
    formData.append('document', event.target.files[0]);

    axios.post(route('admin.leads.upload_contract_doc'), formData, {headers: {'Content-Type': 'multipart/form-data'}})
        .then((response) => {
            if (response.status === 200) {
                Notifier.toastSuccess(response.data.message);
                documentFile.value.value = null;
                getContractDetail();
            }
        });*/
}

function updateMembership() {

    /*axios.post(route('admin.leads.update_contract_membership'), {
        lead_id: form.value.lead_id,
        membership: form.value.membership,
    })
        .then((response) => {
            if (response.status === 200) {
                Notifier.toastSuccess(response.data.message);
            }
        });*/
}

function setContractForm(contract) {
    form.value.contract_id = contract.id;
    form.value.document_name = contract.document_name;
    form.value.membership = contract.membership;
    form.value.product_items = contract.product_items;
}

function addProduct() {
    form.value.product_items.push({
        contract_id: form.value.contract_id,
        product_id: null,
        quantity: 1,
        condition: 1,
        price: 0,
    });
}

function decreaseProductCondition(product) {
    if (product.condition === 1) {
        return;
    }
    --product.condition;
}

function increaseProductCondition(product) {
    if (product.condition === 5) {
        return;
    }
    ++product.condition;
}

function deleteProduct(productIndex) {
    form.value.product_items.splice(productIndex, 1);
}

function closeModal() {
    emit('close');
}

function closeModalAndReload() {
    emit('reload-lead');
    emit('close');
}

function hasDocument() {
    return form.value.document_name !== "" && form.value.document_name !== null;
}

function openCreateProductModal() {
    createProductModal.value = true;
    BtModalHelper.open();
}

function closeCreateProductModal() {
    createProductModal.value = false;
    BtModalHelper.close();
}

function openCreateProductCategoryModal() {
    createProductCategoryModal.value = true;
    BtModalHelper.open();
}

function closeCreateProductCategoryModal() {
    createProductCategoryModal.value = false;
    BtModalHelper.close();
}

function openEditProductModal(productId) {
    editProductModal.value.product_id = productId;
    editProductModal.value.show = true;
    BtModalHelper.open();
}

function closeEditProductModal() {
    editProductModal.value.product_id = 0;
    editProductModal.value.show = false;
    BtModalHelper.close();
}

function openEditProductCategoryModal(categoryId) {
    editProductCategoryModal.value.category_id = categoryId;
    editProductCategoryModal.value.show = true;
    BtModalHelper.open();
}

function closeEditProductCategoryModal() {
    editProductCategoryModal.value.category_id = 0;
    editProductCategoryModal.value.show = false;
    BtModalHelper.close();
}

function editAddedProduct(addedProduct) {
    if (addedProduct.type === 'product') {
        openEditProductModal(addedProduct.related_id);
    }
    if (addedProduct.type === 'category') {
        openEditProductCategoryModal(addedProduct.related_id);
    }
}

function deleteAddedProduct(addedProductId) {
    axios.post(route('admin.leads.delete_added_product'), {
        added_product_id: addedProductId
    })
        .then(async (response) => {
            if (response.status === 200) {
                Notifier.toastSuccess(response.data.message);
                await reloadProductsAndAddProducts();
            }
        });
}

async function reloadProductsAndAddProducts() {
    await reloadProducts();
    await reloadAddedProducts();
}

async function reloadProducts() {
    await useProductStore().refreshProducts();
}

async function reloadAddedProducts() {
    await axios.post(route('admin.leads.added_products'), {
        lead_id: form.value.lead_id,
    })
        .then((response) => {
            if (response.status === 200) {
                addedProducts.value = response.data.data;
            }
        });
}

onMounted(async () => {
    getContractDetail();
    await reloadAddedProducts();
    await reloadProducts();
})

</script>

<style scoped lang="scss">

</style>
