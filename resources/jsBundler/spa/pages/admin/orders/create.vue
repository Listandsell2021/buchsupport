<template>
    <div>

        <Breadcrumbs :menu-items="breadcrumbConfig.order.create()" :title="$t('Order Create')"/>

        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <Form @submit="createOrder" v-slot="{errors}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ $t('Customer') }}</label>
                                    <BsSelect
                                        :filterable="false"
                                        v-model="form.user_id"
                                        :options="customers"
                                        :reduce="customer => customer.id"
                                        label="name"
                                        @search="searchCustomers"
                                    >
                                        <template #no-options="{ search, searching, loading }">
                                            {{ (search.length > 0) && searching ? $t('No customers found') : $t('Search customers') }}
                                        </template>
                                    </BsSelect>
                                </div>
                                <div class="form-group">
                                    <label>{{ $t('Service') }}</label>
                                    <BsSelect
                                        class=""
                                        v-model="form.service_id"
                                        :options="useServiceStore().services"
                                        label="name"
                                        :reduce="service => service.id"
                                        :clearable="false"
                                        @update:model-value="getPipelinesByService"
                                        :placeholder="$t('Select Service')"
                                    ></BsSelect>
                                </div>
                                <div class="form-group">
                                    <label>{{ $t('Service Status') }}</label>
                                    <BsSelect
                                        class=""
                                        v-model="form.pipeline_id"
                                        :options="pipelines"
                                        label="name"
                                        :reduce="pipeline => pipeline.id"
                                        :clearable="false"
                                        :placeholder="$t('Select Service')"
                                    ></BsSelect>
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
                                    <label>{{ $t('Quantity') }}</label>
                                    <Field class="form-control"
                                           v-model="form.quantity"
                                           type="number"
                                           name="quantity"
                                           rules="required"
                                           :placeholder="$t('Enter quantity')"
                                           :class="{'is-invalid': errors.quantity}"
                                    />
                                    <ErrorMessage class="text-danger d-block" name="quantity"/>
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
import {onMounted, ref} from "vue";
import { Form, Field, ErrorMessage } from 'vee-validate';
import breadcrumbConfig from "@/storage/data/breadcrumbs";
import {useServiceStore} from "@/storage/store/services";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import Notifier from "@/libraries/utils/Notifier";
import {useI18n} from "vue-i18n";
import {useRouter} from "vue-router";
import {useMeta} from "vue-meta";
import __debounce from "lodash/debounce";


const router = useRouter();
const { t: $t } = useI18n();
useMeta({title: $t('Order Create')});

const form = ref({
    user_id: '',
    service_id: '',
    pipeline_id: '',
    quantity: 0,
    price: 0,
    note: '',
});

const customers = ref([]);
const pipelines = ref([]);

const searchCustomers = __debounce((search, loading) => {
    if(search.length) {
        loading(true);
        axios.post(route('admin.customers.search'), {
            name: search
        }).then((response) => {
            if (response.status === 200) {
                customers.value = response.data.data;
                form.value.user_id = '';
                loading(false);
            }
        });
    }
}, 500);


function getPipelinesByService(serviceId) {
    console.log(serviceId);
    axios.post(route('admin.service_pipeline.by_service'), {
        service_id: serviceId
    }).then((response) => {
        if (response.status === 200) {
            pipelines.value = response.data.data;
            form.value.pipeline_id = '';
         }
    });
}

function createOrder() {
    axios.post(route('admin.orders.store'), form.value).then((response) => {
        if (response.status == 201) {
            Notifier.toastSuccess(response.data.message);
            router.push('/admin/orders');
        }
    });
}


onMounted(async () => {
    await useServiceStore().refreshServices();
})

</script>