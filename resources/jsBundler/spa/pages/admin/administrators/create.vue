<template>
    <div>

        <Breadcrumbs :menu-items="breadcrumbConfig.admin.create()" :title="$t('Administrator Create')"/>

        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <Form @submit="createAdmin" v-slot="{errors}">
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
                                    <label>{{ $t('Password') }}</label>
                                    <Field class="form-control"
                                           v-model="form.password"
                                           type="password"
                                           name="password"
                                           :placeholder="$t('Enter password')"
                                           rules="required|min:6"
                                           :class="{'is-invalid': errors.password}"
                                    />
                                    <ErrorMessage class="text-danger d-block" name="password"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ $t('Confirm Password') }}</label>
                                    <Field class="form-control"
                                           v-model="form.password_confirmation"
                                           type="password"
                                           name="password_confirmation"
                                           :placeholder="$t('Enter confirm password')"
                                           rules="required|confirmed:@password"
                                           :class="{'is-invalid': errors.password_confirmation}"
                                    />
                                    <ErrorMessage class="text-danger d-block" name="password_confirmation"/>
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
                                    <label>{{ $t('Date of birth') }}</label>
                                    <div>
                                        <BsDatePicker v-model:value="form.dob"
                                                        value-type="format"
                                                        format="DD.MM.YYYY"
                                                        :placeholder="$t('Select date of birth')"
                                        ></BsDatePicker>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
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
                                        <option value="male">{{ $t('Male') }}</option>
                                        <option value="female">{{ $t('Female') }}</option>
                                    </Field>
                                    <ErrorMessage class="text-danger d-block" name="gender"/>
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
                                           rules="required"
                                           :class="{'is-invalid': errors.phone_no}"
                                    />
                                    <ErrorMessage class="text-danger d-block" name="phone_no"/>
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
                                           rules="required"
                                           :class="{'is-invalid': errors.city}"
                                    />
                                    <ErrorMessage class="text-danger d-block" name="city"/>
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
                                           rules="required"
                                           :class="{'is-invalid': errors.street}"
                                    />
                                    <ErrorMessage class="text-danger d-block" name="street"/>
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
                                           rules="required"
                                           :class="{'is-invalid': errors.postal_code}"
                                    />
                                    <ErrorMessage class="text-danger d-block" name="postal_code"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ $t('Country') }}</label>
                                    <Field class="form-control"
                                           v-model="form.country"
                                           name="country"
                                           :class="{'is-invalid': errors.country}"
                                           as="select"
                                           rules="required"
                                    >
                                        <option value="">{{ $t('Enter country') }}</option>
                                        <option :value="country" v-for="country in countries">
                                            {{ country }}
                                        </option>
                                    </Field>
                                    <ErrorMessage class="text-danger d-block" name="country"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ $t('Auth Role') }}</label>
                                    <Field class="form-select"
                                           v-model="form.auth_role"
                                           name="name"
                                           as="select"
                                           rules="required"
                                           :class="{'is-invalid': errors.role}"
                                           @change="authRoleUpdated"
                                    >
                                        <option value="">{{ $t('Select auth role') }}</option>
                                        <option v-for="role in authRoles"
                                                :key="role.id"
                                                :value="role.id"
                                        >
                                            {{ role.name }}
                                        </option>
                                    </Field>
                                    <ErrorMessage class="text-danger d-block" name="role"/>
                                </div>
                            </div>
                            <div class="col-md-6" v-if="form.auth_role == 'admin'">
                                <div class="form-group">
                                    <label>{{ $t('Admin Role') }}</label>
                                    <select class="form-select" v-model="form.role_id">
                                        <option value="">{{ $t('Select admin role') }}</option>
                                        <option v-for="role in adminRoles"
                                                :key="role.id"
                                                :value="role.id"
                                        >
                                            {{ role.name }}
                                        </option>
                                    </select>
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
import { countryList as countries } from "@/storage/data/countrylist";
import StatusSwitcher from "@/components/widgets/form/StatusSwitcher";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import { useAdminRoleStore } from '@/storage/store/admin_roles';
import { useAuthRoleStore } from '@/storage/store/auth_roles';
import Notifier from "@/libraries/utils/Notifier";
import {useI18n} from "vue-i18n";
import {useRouter} from "vue-router";
import {useMeta} from "vue-meta";

const { t: $t } = useI18n()
const router = useRouter();
useMeta({title: $t('Administrator Create')});

const form = ref({
    first_name: '',
    last_name: '',
    password: '',
    password_confirmation: '',
    email: '',
    dob: '',
    phone_no: '',
    gender: '',
    street: '',
    postal_code: '',
    city: '',
    country: '',
    auth_role: '',
    role_id: '',
    is_active: '',
});


const adminRoles = await useAdminRoleStore().getRolesByRefresh();
const authRoles = await useAuthRoleStore().getRolesByRefresh();

function createAdmin() {
    axios.post(route('admin.admins.store'), form.value).then((response) => {
        if (response.status == 201) {
            Notifier.toastSuccess(response.data.message);
            return router.push('/admin/administrators');
        }
    });
}

function changeActiveStatus(isActive) {
    form.value.is_active = isActive;
}

function authRoleUpdated() {
    if (form.value.auth_role != 'admin') {
        form.value.role_id = null;
    }
}

onMounted(async () => {

})

</script>