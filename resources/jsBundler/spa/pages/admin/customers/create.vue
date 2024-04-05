<template>
    <div>

        <Breadcrumbs :menu-items="breadcrumbConfig.admin.create()" :title="$t('Customer Create')"/>

        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <Form @submit="createCustomer" v-slot="{errors}">
                        <div class="row">
                            <div class="col-md-3">
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
                            <div class="col-md-3">
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
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ $t('Gender') }}</label>
                                    <Field class="form-select"
                                           name="gender"
                                           v-model="form.gender"
                                           as="select"
                                           rules="required"
                                           :class="{'is-invalid': errors.gender}"
                                    >
                                        <option value="">{{ $t('Select gender') }}</option>
                                        <option :value="key" v-for="(gender, key) in Genders">{{ $t(gender) }}</option>
                                    </Field>
                                    <ErrorMessage class="text-danger d-block" name="gender"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ $t('Phone no') }}</label>
                                    <Field class="form-control"
                                           v-model="form.phone_no"
                                           type="text"
                                           name="phone_no"
                                           :placeholder="$t('Enter phone no')"
                                           rules="required"
                                           :class="{'is-invalid': errors.phone_no}"
                                    />
                                    <ErrorMessage class="text-danger d-block" name="phone_no"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ $t('Street') }}</label>
                                    <Field class="form-control"
                                           v-model="form.street"
                                           type="text"
                                           name="street"
                                           :placeholder="$t('Enter street')"
                                           rules="required"
                                           :class="{'is-invalid': errors.street}"
                                    />
                                    <ErrorMessage class="text-danger d-block" name="street"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ $t('Postal Code') }}</label>
                                    <Field class="form-control"
                                           v-model="form.postal_code"
                                           type="number"
                                           name="postal_code"
                                           :placeholder="$t('Enter postal code')"
                                           rules="required"
                                           :class="{'is-invalid': errors.postal_code}"
                                    />
                                    <ErrorMessage class="text-danger d-block" name="postal_code"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ $t('City') }}</label>
                                    <Field class="form-control"
                                           v-model="form.city"
                                           type="text"
                                           name="city"
                                           :placeholder="$t('Enter city')"
                                           rules="required"
                                           :class="{'is-invalid': errors.city}"
                                    />
                                    <ErrorMessage class="text-danger d-block" name="city"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ $t('Country') }}</label>
                                    <BsSelect
                                        v-model="form.country"
                                        :options="countries"
                                        @update:model-value="updateCountry"
                                        :placeholder="$t('Select Country')"
                                    ></BsSelect>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ $t('Password') }}</label>
                                    <VisiblePasswordInput
                                        initial=""
                                        @change="updatePassword"
                                    ></VisiblePasswordInput>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ $t('Email') }}</label>
                                    <Field class="form-control"
                                           v-model="form.email"
                                           type="email"
                                           name="email"
                                           :placeholder="$t('Enter email')"
                                           rules="email"
                                           :class="{'is-invalid': errors.email}"
                                    />
                                    <ErrorMessage class="text-danger d-block" name="email"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ $t('Date of birth') }}</label>
                                    <BsDatePicker v-model:value="form.dob"
                                                    value-type="format"
                                                    format="DD.MM.YYYY"
                                                    placeholder="DD.MM.YYYY"
                                    ></BsDatePicker>
                                    <ErrorMessage class="text-danger d-block" name="dob"/>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ $t('Status') }}</label>
                                    <StatusSwitcher :is_active="form.is_active"
                                                    @toggle="changeActiveStatus"
                                    ></StatusSwitcher>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ $t('Is Special') }}</label>
                                    <StatusSwitcher :is_active="form.is_special"
                                                    @toggle="changeIsSpecial"
                                    ></StatusSwitcher>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ $t('Secondary First name') }}</label>
                                    <Field class="form-control"
                                           v-model="form.secondary_first_name"
                                           type="text"
                                           name="secondary_first_name"
                                           :placeholder="$t('Enter secondary first name')"
                                    />
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>{{ $t('Secondary Last name') }}</label>
                                    <Field class="form-control"
                                           v-model="form.secondary_last_name"
                                           type="text"
                                           name="secondary_last_name"
                                           :placeholder="$t('Enter secondary last name')"
                                    />
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary m-t-30">{{ $t('Create') }}</button>
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
import { countryList as countries } from "@/storage/data/countrylist";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import StatusSwitcher from "@/components/widgets/form/StatusSwitcher";
import Notifier from "@/libraries/utils/Notifier";
import Genders from "@/storage/data/genders";
import { useMembershipStore } from "@/storage/store/memberships";
import VisiblePasswordInput from "@/components/widgets/form/VisiblePasswordInput";
import {useI18n} from "vue-i18n";
import {useRouter} from "vue-router";
import {useMeta} from "vue-meta";


const router = useRouter();
const { t: $t } = useI18n();
useMeta({title: $t('Customer Create')});

const memberships = await useMembershipStore().getMembershipsByRefresh();;

const form = ref({
    first_name: '',
    last_name: '',
    gender: '',
    phone_no: '',
    street: '',
    postal_code: '',
    city: '',
    country: '',
    password: '',
    email: '',
    dob: null,
    is_active: 0,
    is_special: 0,
    secondary_first_name: '',
    secondary_last_name: '',
});


function createCustomer() {
    axios.post(route('admin.customers.store'), form.value).then((response) => {
        if (response.status == 201) {
            Notifier.toastSuccess(response.data.message);
            router.push('/admin/customers');
        }
    });
}

function updateCountry(country) {
    if (country == null) {
        form.value.country = '';
    }
}

function updatePassword(password) {
    form.value.password = password;
}

function changeActiveStatus(isActive) {
    form.value.is_active = isActive;
}

function changeIsSpecial(isSpecial) {
    form.value.is_special = isSpecial;
}


onMounted(async () => {

})

</script>