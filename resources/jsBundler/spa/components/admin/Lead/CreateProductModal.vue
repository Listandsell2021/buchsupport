<template>

    <div class="modal fade show modal-show" id="create-product-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <a href="#" @click.prevent="closeModal" class="close close-modal" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </a>

                    <h5 class="m-b-30">{{ $t('Create Product') }}</h5>

                    <div class="row">
                        <div class="col-md-12">
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
                                <div ref="imageContainer">
                                    <BsDropzone ref="dropzoneUploader"
                                                 id="dropzone"
                                                 class="editable-dropzone"
                                                 :destroy-dropzone="false"
                                                 :options="DropzoneSetting.options"
                                    />
                                </div>
                            </div>
                        </div>

                    </div>

                    <button @click.prevent="createProduct()"
                            class="btn btn-primary"
                    >{{ $t('Create') }}</button>
                </div>
            </div>
        </div>
    </div>

</template>

<script setup>
import {onMounted, ref} from "vue";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import Notifier from "@/libraries/utils/Notifier";
import { useProductCategoryStore } from '@/storage/store/product_categories';
import PluginConfig from "@/config/plugins";
import DropzoneSetting from "@/storage/data/dropzone";
import { vOnClickOutside } from '@vueuse/components';
import {useI18n} from "vue-i18n";
import {useRouter} from "vue-router";

const emit = defineEmits(['close', 'reload-products']);
const props = defineProps({
    leadId: {
        required: true
    }
});

const { t: $t } = useI18n()
const router = useRouter();
const dropzoneUploader = ref(null);
const imageContainer = ref(null);
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
    formData.append('lead_id', props.leadId);

    let files = dropzoneUploader.value.getAcceptedFiles();

    for (let x = 0; x < files.length; x++) {
        formData.append('images[]', files[x]);
    }

    axios.post(route('admin.leads.create_product'), formData).then((response) => {
        if (response.status === 201) {
            Notifier.toastSuccess(response.data.message);
            closeModalAndReload();
        }
    });
}

function changeActiveStatus(isActive) {
    form.value.is_active = isActive;
}

function closeModal() {
    emit('close');
}

function closeModalAndReload() {
    emit('close');
    emit('reload-products');
}

onMounted(async () => {

})




</script>

<style scoped lang="scss">

</style>
