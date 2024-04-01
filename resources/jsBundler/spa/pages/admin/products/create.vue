<template>
    <div>

        <Breadcrumbs :menu-items="breadcrumbConfig.product.create()" :title="$t('Product Create')"/>

        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <Form @submit="createProduct" v-slot="{errors}">
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
                                    <BsDropzone ref="dropzoneUploader"
                                                id="dropzone"
                                                class="editable-dropzone"
                                                :destroy-dropzone="false"
                                                :options="DropzoneSetting.options"
                                    />
                                </div>
                            </div>

                        </div>

                        <button type="submit" class="btn btn-primary">{{ $t('Create') }}</button>
                    </Form>

                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import {onMounted, ref, watch} from "vue";
import { Form, Field, ErrorMessage } from 'vee-validate';
import breadcrumbConfig from "@/storage/data/breadcrumbs";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import Notifier from "@/libraries/utils/Notifier";
import PluginConfig from "@/config/plugins";
import { useProductCategoryStore } from '@/storage/store/product_categories';
import DropzoneSetting from "@/storage/data/dropzone";
import {useI18n} from "vue-i18n";
import {useRouter} from "vue-router";
import {useMeta} from "vue-meta";


const router = useRouter();
const { t: $t } = useI18n();
useMeta({title: $t('Product Create')});

const dropzoneUploader = ref(null);

const categories = await useProductCategoryStore().getCategoriesByRefresh();

const form = ref({
    category_id: '',
    name: '',
    description: '',
    youtube_link: '',
});

function updateCategory(selected) {
    if (selected == null) {
        form.value.category_id = '';
    }
}

function createProduct() {

    let formData = new FormData();

    for (let key in form.value) {
        formData.append(key, form.value[key]);
    }

    let files = dropzoneUploader.value.getAcceptedFiles();

    for (let x = 0; x < files.length; x++) {
        formData.append('images[]', files[x]);
    }

    axios.post(route('admin.products.store'), formData).then((response) => {
        if (response.status == 201) {
            Notifier.toastSuccess(response.data.message);
            router.push('/admin/products');
        }
    });
}

function changeActiveStatus(isActive) {
    form.value.is_active = isActive;
}

onMounted(async () => {

})

</script>