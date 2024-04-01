<template>

    <div class="modal fade show modal-show" id="create-product-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <a href="#" @click.prevent="closeModal" class="close close-modal" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </a>

                    <h5 class="m-b-30">{{ $t('Edit Product Category') }}</h5>

                    <div class="row">
                        <div class="col-md-12">
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
                                <label>{{ $t('Status') }}</label>
                                <StatusSwitcher :is_active="form.is_active"
                                                @toggle="changeActiveStatus"
                                ></StatusSwitcher>
                            </div>
                        </div>
                    </div>

                    <button @click.prevent="updateProductCategory()"
                            class="btn btn-primary"
                    >{{ $t('Update') }}</button>
                </div>
            </div>
        </div>
    </div>

</template>

<script setup>
import {ref, onMounted} from "vue";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import Notifier from "@/libraries/utils/Notifier";
import {useApiFetch} from "@/composables/useApiFetch";
import StatusSwitcher from "@/components/widgets/form/StatusSwitcher";
import {useI18n} from "vue-i18n";

const emit = defineEmits(['close', 'reload-products']);
const props = defineProps({
    categoryId: {
        required: true
    }
});

const { t: $t } = useI18n()

const categoryId = props.categoryId;

let form = ref(null);
const { data:category } = await useApiFetch(route('admin.product_categories.show', {id: categoryId}));

if (!category.value) {
    throw showError({ statusCode: 404, statusMessage: 'Page Not Found', redirectUrl: 'testing' })
}

mapUserIntoForm(category.value);

function mapUserIntoForm(category) {
    form = ref({
        id: category.id,
        name: category.name,
        is_active: category.is_active,
    });
}

function changeActiveStatus(isActive) {
    form.value.is_active = isActive;
}

function updateProductCategory() {
    axios.put(route('admin.product_categories.update', {id: categoryId}), form.value).then((response) => {
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

onMounted(async () => {

})

</script>

<style scoped lang="scss">

</style>
