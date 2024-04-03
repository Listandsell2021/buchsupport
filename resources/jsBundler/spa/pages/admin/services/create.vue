<template>
    <div>

        <Breadcrumbs :menu-items="breadcrumbConfig.service.create()" :title="$t('Service Create')"/>

        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <Form @submit="createService" v-slot="{errors}">
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
                                <div class="form-group">
                                    <label>{{ $t('Price') }}</label>
                                    <Field class="form-control"
                                           v-model="form.price"
                                           type="number"
                                           name="price"
                                           rules="required"
                                           :placeholder="$t('Enter price')"
                                           :class="{'is-invalid': errors.price}"
                                    />
                                    <ErrorMessage class="text-danger d-block" name="name"/>
                                </div>
                                <div class="form-group">
                                    <label>{{ $t('Note') }}</label>
                                    <textarea class="form-control"
                                              v-model="form.note"
                                              name="note"
                                              rows="4"
                                              :placeholder="$t('Enter note')"
                                    ></textarea>
                                </div>
                                <div class="form-group">
                                    <label>{{ $t('Status') }}</label>
                                    <StatusSwitcher :is_active="form.is_active"
                                                    @toggle="changeActiveStatus"
                                    ></StatusSwitcher>
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
import {useI18n} from "vue-i18n";
import {useRouter} from "vue-router";
import {useMeta} from "vue-meta";
import StatusSwitcher from "@/components/widgets/form/StatusSwitcher.vue";


const router = useRouter();
const { t: $t } = useI18n();
useMeta({title: $t('Service Create')});

const form = ref({
    name: '',
    price: '',
    note: '',
    is_active: 0,
});

function changeActiveStatus(isActive) {
    form.value.is_active = isActive;
}

function createService() {
    axios.post(route('admin.services.store'), form.value).then((response) => {
        if (response.status == 201) {
            Notifier.toastSuccess(response.data.message);
            router.push('/admin/services');
        }
    });
}


onMounted(async () => {

})

</script>