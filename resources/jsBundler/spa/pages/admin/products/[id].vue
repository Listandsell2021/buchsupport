<template>
    <div>
        <Breadcrumbs :menu-items="breadcrumbConfig.product.edit(productId)" :title="$t('Product Edit')"/>

        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <Form @submit="updateProduct" v-slot="{errors}">
                        <div class="row">
                            <div class="col-md-9">
                                <div class="form-group">
                                    <label>{{ $t('Category') }}</label>
                                    <BsSelect
                                        v-model="form.category_id"
                                        :options="categories"
                                        :reduce="category => category.id"
                                        label="name"
                                        @update:model-value="updateCategory"
                                    />
                                </div>
                                <div class="form-group">
                                    <label>{{ $t('Name') }}</label>
                                    <Field class="form-control"
                                           v-model="form.name"
                                           type="text"
                                           name="name"
                                           rules="required"
                                           :placeholder="$t('Enter name')"
                                           :class="{'is-invalid': errors.name}"
                                    />
                                    <ErrorMessage class="text-danger d-block" name="name"/>
                                </div>
                                <div class="form-group">
                                    <label>{{ $t('Description') }}</label>
                                    <BsEditor
                                        :api-key="PluginConfig.tinyMce.key"
                                        :init="PluginConfig.tinyMce.config"
                                        v-model="form.description"
                                    />
                                </div>
                                <div class="form-group">
                                    <label>{{ $t('Youtube Link') }}</label>
                                    <Field class="form-control"
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
                                                 id="productDropzone"
                                                 class="editable-dropzone"
                                                :destroy-dropzone="false"
                                                :options="dropzoneOption"
                                                 v-on:vdropzone-file-added="uploadProductImage"
                                    />
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">{{ $t('Update') }}</button>
                    </Form>

                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { Form, Field, ErrorMessage } from 'vee-validate';
import {ref, onMounted, reactive} from "vue";
import breadcrumbConfig from "@/storage/data/breadcrumbs";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import Notifier from "@/libraries/utils/Notifier";
import EventBus from "@/libraries/utils/EventBus";
import {useApiFetch} from "@/composables/useApiFetch";
import { useProductCategoryStore } from '@/storage/store/product_categories';
import PluginConfig from "@/config/plugins";
import ImageManager from "@/components/admin/Product/ImageManager";
import {useI18n} from "vue-i18n";
import {useRoute, useRouter} from "vue-router";
import {useMeta} from "vue-meta";

const props = defineProps({
    data: {
        required: true,
        type: Object,
    }
});

const router = useRouter();
const routes = useRoute();
const { t: $t } = useI18n();
useMeta({title: $t('Product Edit')});

const productId = routes.params.id;


let form = ref(null);
let product = ref(null);

const dropzoneUploader = ref(null);
const dropzoneOption = {
    url: route('admin.products.add_image'),
    method: 'POST',
    maxFilesize: 100,
    autoProcessQueue: false,
    addRemoveLinks: true,
    dictRemoveFile: 'Entferne Bild',
    dictDefaultMessage: 'Bilder zum Hochladen hier ablegen',
    params: {product_id: productId}
};
const categories = await useProductCategoryStore().getCategoriesByRefresh();

product.value = props.data.value;
mapUserIntoForm(props.data.value);

function updateProduct() {
    axios.put(route('admin.products.update', {id: productId}), form.value).then((response) => {
        if (response.status === 200) {
            Notifier.toastSuccess(response.data.message);
            router.push('/admin/products');
        }
    });
}

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

onMounted( () => {

})


</script>