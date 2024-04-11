<template>
    <div>
        <Breadcrumbs :menu-items="breadcrumbConfig.service.edit(serviceId)" :title="$t('Service Edit')"/>

        <div class="container-fluid">
            <div class="card">
                <div class="card-body">

                    <Form @submit="updateService" v-slot="{errors}">
                        <div class="row">
                            <div class="col-md-9">
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
                                           :placeholder="$t('Enter Price')"
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
                                              :placeholder="$t('Enter Note')"
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

                        <button type="submit" class="btn btn-primary">{{ $t('Update') }}</button>
                    </Form>

                    <ServiceStatusListing :service-id="serviceId"
                    ></ServiceStatusListing>

                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { Form, Field, ErrorMessage } from 'vee-validate';
import {ref, onMounted} from "vue";
import breadcrumbConfig from "@/storage/data/breadcrumbs";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import Notifier from "@/libraries/utils/Notifier";
import {useI18n} from "vue-i18n";
import {useRoute, useRouter} from "vue-router";
import {useMeta} from "vue-meta";
import StatusSwitcher from "@/components/widgets/form/StatusSwitcher.vue";
import ServiceStatusListing from "@/components/admin/ServiceStatus/Listing.vue";

const props = defineProps({
    data: {
        required: true,
        type: Object,
    }
});

const router = useRouter();
const routes = useRoute();
const { t: $t } = useI18n();
useMeta({title: $t('Service Edit')});

const serviceId = routes.params.id;

let form = ref(null);
let service = ref(null);

service.value = props.data.value;
mapUserIntoForm(props.data.value);

function updateService() {
    axios.put(route('admin.services.update', {id: serviceId}), form.value).then((response) => {
        if (response.status === 200) {
            Notifier.toastSuccess(response.data.message);
            router.push('/admin/services');
        }
    });
}

function changeActiveStatus(isActive) {
    form.value.is_active = isActive;
}

function mapUserIntoForm(service) {
    console.log(service);
    form.value = {
        id: service.id,
        name: service.name,
        price: service.price,
        note: service.note,
        is_active: service.is_active
    };
}

onMounted( () => {

})


</script>