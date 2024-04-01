<template>

    <div class="modal fade show modal-show" id="create-product-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <a href="#" @click.prevent="closeModal" class="close close-modal" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </a>

                    <h5 class="m-b-30">{{ $t('Edit Product') }}</h5>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ $t('Category') }}</label>
                                <BsSelect
                                    v-model="form.category_id"
                                    :options="useProductCategoryStore().product_categories"
                                    :reduce="category => category.id"
                                    label="name"
                                    @update:model-value="updateCategory"
                                />
                            </div>
                            <div class="form-group">
                                <label>{{ $t('Name') }}</label>
                                <input class="form-control"
                                       v-model="form.name"
                                       type="text"
                                       name="name"
                                       :placeholder="$t('Enter name')"
                                />
                            </div>
                            <div class="form-group">
                                <label>{{ $t('Description') }}</label>
                                <BsEditor
                                    :api-key="PluginConfig.tinyMce.key"
                                    :init="PluginConfig.tinyMce.config"
                                    v-model="form.description"
                                />
                                <ErrorMessage class="text-danger d-block" name="description"/>
                            </div>
                            <div class="form-group">
                                <label>{{ $t('Youtube Link') }}</label>
                                <input class="form-control"
                                       v-model="form.youtube_link"
                                       type="text"
                                       name="youtube_link"
                                       :placeholder="$t('Enter youtube link')"
                                />
                            </div>
                            <div class="form-group">
                                <label for="images">Images</label>
                                <ImageManager
                                    :images="product.images"
                                    :product-id="productId"
                                ></ImageManager>
                                <BsDropzone ref="dropzoneUploader"
                                             id="dropzone"
                                             class="editable-dropzone"
                                             :options="dropzoneOption"
                                             :destroy-dropzone="false"
                                             v-on:vdropzone-file-added="uploadProductImage"
                                />
                            </div>
                        </div>
                    </div>

                    <button @click.prevent="updateProduct()"
                            class="btn btn-primary"
                    >{{ $t('Update') }}</button>
                </div>
            </div>
        </div>
    </div>

</template>

<script setup>
import {ref, onMounted, reactive} from "vue";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import Notifier from "@/libraries/utils/Notifier";
import EventBus from "@/libraries/utils/EventBus";
import {useApiFetch} from "@/composables/useApiFetch";
import { useProductCategoryStore } from '@/storage/store/product_categories';
import PluginConfig from "@/config/plugins";
import ImageManager from "@/components/admin/Product/ImageManager";
import {useI18n} from "vue-i18n";

const emit = defineEmits(['close', 'reload-products']);
const props = defineProps({
    productId: {
        required: true,
    }
});

const { t: $t } = useI18n();

const productId = props.productId;

const dropzoneOption = reactive({
    url: route('admin.products.add_image'),
    method: 'POST',
    maxFilesize: 100,
    autoProcessQueue: false,
    addRemoveLinks: true,
    dictRemoveFile: 'Entferne Bild',
    dictDefaultMessage: 'Bilder zum Hochladen hier ablegen',
});

let form = ref(null);
const { data:product } = await useApiFetch(route('admin.products.show', {id: productId}));

if (!product.value) {
    throw showError({ statusCode: 404, statusMessage: 'Page Not Found', redirectUrl: 'testing' })
}

const dropzoneUploader = ref(null);

mapUserIntoForm(product.value);

function changeActiveStatus(isActive) {
    form.value.is_active = isActive;
}

function mapUserIntoForm(product) {
    form.value = {
        id: product.id,
        category_id: product.category_id,
        name: product.name,
        description: product.description,
        youtube_link: product.youtube_link,
        images: product.images,
    };
}

function updateCategory(selected) {
    if (selected == null) {
        form.value.category_id = '';
    }
}

function uploadProductImage(image) {

    let formData = new FormData();

    formData.append('product_id', productId);
    formData.append('image', image);

    axios.post(route('admin.products.add_image'), formData).then((response) => {
        if (response.status === 200) {
            EventBus.emit('reload-product-images');
            Notifier.toastSuccess(response.data.message);
        }
        removeFileFromDropzone(image);
    });
}

function removeFileFromDropzone(file) {
    dropzoneUploader.value.removeFile(file);
}

function updateProduct() {
    axios.put(route('admin.products.update', {id: productId}), form.value).then((response) => {
        if (response.status === 200) {
            Notifier.toastSuccess(response.data.message);
            closeModalAndReload();
        }
    });
}

function closeModal() {
    emit('close');
}

function closeModalAndReload() {
    emit('close');
    emit('reload-products');
}

function refreshCategories() {
    useProductCategoryStore().refreshCategories();
}

onMounted(async () => {
    refreshCategories();
})
</script>

<style scoped lang="scss">

</style>
