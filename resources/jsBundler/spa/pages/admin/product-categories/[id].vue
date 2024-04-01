<template>
    <div>

        <Breadcrumbs :menu-items="breadcrumbConfig.product_category.edit(categoryId)" :title="$t('Product Category Edit')"/>

        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <Form @submit="updateProductCategory" v-slot="{errors}">
                        <div class="row">
                            <div class="col-md-6">
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
                            </div>
                            <div class="col-md-6">

                                <div class="form-group">
                                    <label>{{ $t('Status') }}</label>
                                    <StatusSwitcher :is_active="form.is_active"
                                                    @toggle="changeActiveStatus"
                                    ></StatusSwitcher>
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
import {ref} from "vue";
import breadcrumbConfig from "@/storage/data/breadcrumbs";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import Notifier from "@/libraries/utils/Notifier";
import {useApiFetch} from "@/composables/useApiFetch";
import StatusSwitcher from "@/components/widgets/form/StatusSwitcher";
import {useI18n} from "vue-i18n";
import {useRoute, useRouter} from "vue-router";
import {useMeta} from "vue-meta";

const router = useRouter();
const routes = useRoute();
const { t: $t } = useI18n();
useMeta({title: $t('Product Category Edit')});

const props = defineProps({
    data: {
        required: true,
        type: Object,
    }
});

const categoryId = routes.params.id;

let form = ref(null);

mapUserIntoForm(props.data.value);

function updateProductCategory() {
    axios.put(route('admin.product_categories.update', {id: categoryId}), form.value).then((response) => {
        if (response.status === 200) {
            Notifier.toastSuccess(response.data.message);
            router.push('/admin/product-categories');
        }
    });
}

function changeActiveStatus(isActive) {
    form.value.is_active = isActive;
}

function mapUserIntoForm(category) {
    form = ref({
        id: category.id,
        name: category.name,
        is_active: category.is_active,
    });
}

</script>