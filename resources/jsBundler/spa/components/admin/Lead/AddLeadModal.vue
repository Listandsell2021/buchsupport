<template>
    <div class="modal fade show modal-show" id="add-lead-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" ref="modalDialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ $t('Add Lead') }}</h5>
                    <a href="#" @click.prevent="closeModal" class="close close-modal" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <div class="modal-body">
                    <Form @submit="addLead" v-slot="{errors}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ $t('First name') }}</label>
                                    <Field class="form-control"
                                           v-model="form.first_name"
                                           type="text"
                                           name="first_name"
                                           rules="required"
                                           :placeholder="$t('Enter first name')"
                                           :class="{'is-invalid': errors.first_name}"
                                    />
                                    <ErrorMessage class="text-danger d-block" name="first_name"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ $t('Last name') }}</label>
                                    <Field class="form-control"
                                           v-model="form.last_name"
                                           type="text"
                                           name="last_name"
                                           :placeholder="$t('Enter last name')"
                                           rules="required"
                                           :class="{'is-invalid': errors.last_name}"
                                    />
                                    <ErrorMessage class="text-danger d-block" name="last_name"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ $t('Email') }}</label>
                                    <Field class="form-control"
                                           v-model="form.email"
                                           type="email"
                                           name="email"
                                           :placeholder="$t('Enter email')"
                                           rules="email|required"
                                           :class="{'is-invalid': errors.email}"
                                    />
                                    <ErrorMessage class="text-danger d-block" name="email"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ $t('Gender') }}</label>
                                    <BsSelect
                                        v-model="form.gender"
                                        :options="GendersSelectable"
                                        :reduce="gender => gender.id"
                                        label="name"
                                        @update:model-value="updateGender"
                                        :placeholder="$t('Select gender')"
                                    />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ $t('Phone no') }}</label>
                                    <Field class="form-control"
                                           v-model="form.phone_no"
                                           type="text"
                                           name="phone_no"
                                           :placeholder="$t('Enter phone no')"
                                           :class="{'is-invalid': errors.phone_no}"
                                    />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ $t('City') }}</label>
                                    <Field class="form-control"
                                           v-model="form.city"
                                           type="text"
                                           name="city"
                                           :placeholder="$t('Enter city')"
                                           :class="{'is-invalid': errors.city}"
                                    />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ $t('Street') }}</label>
                                    <Field class="form-control"
                                           v-model="form.street"
                                           type="text"
                                           name="street"
                                           :placeholder="$t('Enter street')"
                                           :class="{'is-invalid': errors.street}"
                                    />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ $t('Postal Code') }}</label>
                                    <Field class="form-control"
                                           v-model="form.postal_code"
                                           type="number"
                                           name="postal_code"
                                           :placeholder="$t('Enter postal code')"
                                           :class="{'is-invalid': errors.postal_code}"
                                    />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ $t('Country') }}</label>
                                    <BsSelect
                                        v-model="form.country"
                                        :options="countries"
                                        :reduce="country => country"
                                        @update:model-value="updateCountry"
                                        :placeholder="$t('Select country')"
                                    />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ $t('Google Map Address') }}</label>
                                    <div class="form-group">
                                        <GMapAutocomplete
                                            class="form-control form-control-sm"
                                            :placeholder="$t('Search address')"
                                            @place_changed="setGeoCoordinates"
                                        >
                                        </GMapAutocomplete>
                                    </div>
                                    <div class="row">
                                        <div class="col">
                                            <input type="text"
                                                   class="form-control"
                                                   v-model="form.map_longitude"
                                                   placeholder="Enter map longitude"
                                            />
                                        </div>
                                        <div class="col">
                                            <input type="text"
                                                   class="form-control"
                                                   v-model="form.map_latitude"
                                                   placeholder="Enter map latitude"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ $t('Status') }}</label>
                                    <BsSelect
                                        v-model="form.lead_status_id"
                                        :options="leadStatus"
                                        label="name"
                                        :reduce="status => status.id"
                                        @update:model-value="updateStatus"
                                        :placeholder="$t('Select Status')"
                                    />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ $t('Salesperson') }}</label>
                                    <BsSelect
                                        v-model="form.salesperson_id"
                                        :options="salespersons"
                                        label="fullname"
                                        :reduce="salesperson => salesperson.id"
                                        @update:model-value="updateSalesperson"
                                        :placeholder="$t('Select salesperson')"
                                    />
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary m-t-30">{{ $t('Save Lead') }}</button>
                    </Form>

                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Form, Field, ErrorMessage } from 'vee-validate';
import {onMounted, ref} from "vue";
import { countryList as countries } from "@/storage/data/countrylist";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import Notifier from "@/libraries/utils/Notifier";
import { GendersSelectable } from "@/storage/data/genders";
import { useLeadStatusStore } from '@/storage/store/lead_status';
import { useSalespersonsStore } from '@/storage/store/salespersons';
import { onClickOutside } from '@vueuse/core';
import {useI18n} from "vue-i18n";
import {useRouter} from "vue-router";

const emit = defineEmits(['close', 'refresh']);

const { t: $t } = useI18n();
const router = useRouter();
const modalDialog = ref(null);
const leadStatus = await useLeadStatusStore().getLeadStatusByRefresh();
let salespersons = await useSalespersonsStore().getSalespersonsByRefresh();

const form = ref({
    first_name: '',
    last_name: '',
    email: '',
    phone_no: '',
    gender: '',
    street: '',
    postal_code: '',
    city: '',
    country: '',
    map_longitude: '',
    map_latitude: '',
    lead_status_id: '',
    salesperson_id: '',
});

onClickOutside(modalDialog, () => {
    closeModal();
})

function addLead() {
    axios.post(route('admin.leads.store'), form.value).then((response) => {
        if (response.status === 201) {
            Notifier.toastSuccess(response.data.message);
            refreshLeadList();
            closeModal();
        }
    });
}

function setGeoCoordinates(object) {
    form.value.map_longitude = object.geometry.location.lng();
    form.value.map_latitude = object.geometry.location.lat();
}

function closeModal() {
    emit('close');
}

function refreshLeadList() {
    emit('refresh');
}

function updateCountry(selected) {
    if (selected == null) {
        form.value.country = '';
    }
}

function updateSalesperson(selected) {
    if (selected == null) {
        form.value.salesperson_id = '';
    }
}

function updateStatus(selected) {
    if (selected == null) {
        form.value.lead_status_id = '';
    }
}

function updateGender(selected) {
    if (selected == null) {
        form.value.gender = '';
    }
}


onMounted(async () => {

})

</script>

<style scoped lang="scss">

</style>
