<template>
    <div>

        <Breadcrumbs :menu-items="breadcrumbConfig.admin.edit(adminId)" :title="$t('Administrator Edit')"/>

        <div class="container-fluid">
            <div class="card">
                <div class="card-body">

                    <ul class="nav nav-tabs search-list" id="top-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link"
                               :class="{ 'show active': showTab === 'profile' }"
                               href="#"
                               @click.prevent="changeTab('profile')"
                            ><i class="fa fa-user"></i> {{ $t('Profile') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                               :class="{ 'show active': showTab === 'commission' }"
                               href="#"
                               @click.prevent="changeTab('commission')"
                            >
                                <i class="fa fa-wpforms"></i> {{ $t('Commissions') }}
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content" id="setting-tab-content">

                        <div class="tab-pane fade show active" v-if="showTab === 'profile'">
                            <Form @submit="updateAdmin" v-slot="{errors}">
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
                                                   rules="min:6"
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
                                                   rules="confirmed:@password"
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
                                            <select class="form-select"
                                                    v-model="form.role_id"
                                            >
                                                <option value="">{{ $t('Select role') }}</option>
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

                                <button type="submit" class="btn btn-primary">{{ $t('Update') }}</button>
                            </Form>
                        </div>

                        <div class="tab-pane fade show active" v-if="showTab === 'commission'">
                            <div class="row">
                                <div class="col-md-4">
                                    <BsDatePicker
                                            v-model:value="datePicker"
                                            type="date"
                                            range
                                            :placeholder="$t('Select date range')"
                                    ></BsDatePicker>
                                </div>
                                <div class="col-md-4">
                                    <button class="btn btn-sm btn-primary"
                                            @click.prevent="createSalespersonCommissionPdf()"
                                    >{{ $t('Create Commission') }}</button>
                                </div>
                                <div class="col-md-4">
                                    <div class="clearfix">
                                        <div class="pull-right">{{ $t('Wallet') }}:
                                            <span v-html="HelperUtils.getCurrency(admin.wallet)"></span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <template v-if="hasCommissions()">
                                <table class="table table-striped m-t-30">
                                    <thead>
                                    <tr>
                                        <th>{{ $t('Id') }}</th>
                                        <th>{{ $t('Period') }}</th>
                                        <th>{{ $t('Date') }}</th>
                                        <th>{{ $t('Total') }}</th>
                                        <th>{{ $t('Paid') }}</th>
                                        <th>{{ $t('Action') }}</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <tr v-for="(commission) in commissions.data"
                                        :key="PasswordGenerator.generate()"
                                    >
                                        <td>#{{ commission.id }}</td>
                                        <td>
                                            {{ DateFormatter.inGerman(commission.commission_from) }} -
                                            {{ DateFormatter.inGerman(commission.commission_to) }}
                                        </td>
                                        <td>{{ DateFormatter.inGerman(commission.commission_date) }}</td>
                                        <td><div v-html="HelperUtils.getCurrency(commission.total)"></div></td>
                                        <td class="switcher-col" style="width: 200px;">
                                            <StatusSwitcher :is_active="commission.paid"
                                                            @toggle="changePaidStatus(commission.id, $event)"
                                            ></StatusSwitcher>
                                        </td>
                                        <td>
                                            <a href="#"
                                               class="btn btn-xs btn-primary"
                                               @click.prevent="downloadCommissionPdf(commission.id)"
                                            >
                                                <i class="fa fa-file-o"></i>
                                            </a>
                                        </td>
                                    </tr>
                                    </tbody>
                                </table>
                            </template>
                            <template v-else>
                                <div class="alert alert-danger m-t-30 alert-t-box">
                                    {{ $t('No Commissions found') }}
                                </div>
                            </template>

                            <div class="m-t-20">
                                <PaginationBar
                                    :data="commissions"
                                    @change="getCommissionLists"
                                ></PaginationBar>
                            </div>
                        </div>

                    </div>

                </div>
            </div>
        </div>

    </div>
</template>
<script setup>
import { Form, Field, ErrorMessage } from 'vee-validate';
import {onMounted, ref} from "vue";
import breadcrumbConfig from "@/storage/data/breadcrumbs";
import { countryList as countries } from "@/storage/data/countrylist";
import axios from "@/libraries/utils/clientapi/axios";
import { useAdminRoleStore } from '@/storage/store/admin_roles';
import { useAuthRoleStore } from '@/storage/store/auth_roles';
import Notifier from "@/libraries/utils/Notifier";
import StatusSwitcher from "@/components/widgets/form/StatusSwitcher";
import {useAuth} from "@/composables/useAuth";
import {useI18n} from "vue-i18n";
import {useRoute, useRouter} from "vue-router";
import route from "@/libraries/utils/ZiggyRoute";
import moment from "moment/moment";
import PaginationBar from "@/components/widgets/form/PaginationBar.vue";
import PasswordGenerator from "@/libraries/utils/helpers/PasswordGenerator";
import __Has from "lodash/has";
import PaginationSetting from "@/storage/data/paginationSetting";
import DateFormatter from "../../../libraries/utils/helpers/DateFormatter";
import HelperUtils from "../../../libraries/utils/helpers/HelperUtils";
import {useApiFetch} from "@/composables/useApiFetch";
import ziggyRoute from "@/libraries/utils/ZiggyRoute";
import {useMeta} from "vue-meta";

const {fetchAndSetCurrentUser, getUser} = useAuth('admin');

const { t: $t } = useI18n()
const router = useRouter();
const routes = useRoute();

useMeta({title: $t('Administrator Edit')});

const props = defineProps({
    data: {
        type: Object,
        required: true
    }
})

const adminId = routes.params.id;
const auth = getUser();
const datePicker = ref(null);

let form = ref(null);
let admin = ref(props.data.value);
const showTab = ref('profile');
const commissions = ref({});

const commissionForm = ref({
    page: 1,
    per_page: PaginationSetting.per_page,
    filters: {
        name: '',
        admin_id: adminId
    },
});

mapUserIntoForm(props.data.value);

const adminRoles = await useAdminRoleStore().getRolesByRefresh();
const authRoles = await useAuthRoleStore().getRolesByRefresh();

function updateAdmin() {
    axios.put(route('admin.admins.update', {id: adminId}), form.value).then(async (response) => {
        if (response.status == 200) {
            Notifier.toastSuccess($t(response.data.message));
            if (adminId == auth.id) {
                fetchAndSetCurrentUser();
            }
            await router.push({name: 'administrator_list'});
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

function mapUserIntoForm(user) {
    form = ref({
        id: user.id,
        first_name: user.first_name,
        last_name: user.last_name,
        password: '',
        password_confirmation: '',
        email: user.email,
        dob_alt: new Date(user.dob),
        dob: user.dob,
        phone_no: user.phone_no,
        gender: user.gender,
        street: user.street,
        postal_code: user.postal_code,
        city: user.city,
        country: user.country,
        role_id: user.role_id,
        auth_role: user.auth_role,
        is_active: user.is_active,
    });
}

function changeTab(tab) {
    showTab.value = tab;
}

function hasCommissions() {
    return __Has(commissions.value, 'data') ? (commissions.value.data.length > 0) : false;
}

const getCommissionLists = async (page = 1, per_page = 0) => {

    setPageNumber(page, per_page);

    await axios.post(route('admin.admins.commissions'), commissionForm.value)
        .then(response => {
            commissions.value = response.data.data;
        });
}

async function getAdminDetail() {
    const { error, data } = await useApiFetch(route('admin.admins.show', {id: adminId}));
    admin.value = data.value;
}

function changePaidStatus(commissionId, paid) {
    axios.post(route('admin.admins.update_commission_paid_status'), {
        commission_id: commissionId,
        paid: paid,
    }).then((response) => {
        if (response.status === 200) {
            getCommissionLists();
            Notifier.toastSuccess(response.data.message);
        }
    });
}

function downloadCommissionPdf(commissionId)
{
    axios.postDownload(route('admin.admins.download_commission'), {
        commission_id: commissionId
    })
        .then((response) => {
            if (response.status === 200) {
                HelperUtils.blobFileDownload(response, commissionId+'.pdf');
            }
        });
}

function setPageNumber(page, per_page) {
    if (typeof page === 'number') {
        commissionForm.value.page = page;
    } else {
        commissionForm.value.page = 1;
    }

    if (typeof per_page === 'number' && per_page > 0) {
        commissionForm.value.per_page = per_page;
    }
}

function createSalespersonCommissionPdf() {
    axios.post(route('admin.admins.create_commission_pdf'), {
        admin_id: adminId,
        date_from: Array.isArray(datePicker.value) ? moment(datePicker.value[0]).format('YYYY-MM-DD') : '',
        date_to: Array.isArray(datePicker.value) ? moment(datePicker.value[1]).format('YYYY-MM-DD') : '',
    }).then((response) => {
        if (response.status === 200) {
            getCommissionLists();
            getAdminDetail();
            if (response.data.data) {
                Notifier.toastSuccess($t(response.data.message));
            } else {
                Notifier.toastError($t(response.data.message));
            }
        }
    });
}

onMounted(() => {
    getCommissionLists();
});

</script>