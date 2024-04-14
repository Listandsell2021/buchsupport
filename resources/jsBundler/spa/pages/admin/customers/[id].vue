<template>
    <div>

        <Breadcrumbs :menu-items="breadcrumbConfig.customer.edit(customerId)" title="">
            <template #header>
                <h3>{{ $t('Customer Edit') }}: {{ customer.uid }}</h3>
                <div class="c-buttons m-l-30">
                    <a href="#"
                       class="btn btn-xs btn-primary m-r-20"
                       v-tooltip="$t('Copy Customer ID')"
                       @click.prevent="copyCustomerInfo()"
                    >
                        <i class="fa fa-copy"></i>
                    </a>
                </div>
            </template>
        </Breadcrumbs>

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
                               :class="{ 'show active': showTab === 'document' }"
                               href="#"
                               @click.prevent="changeTab('document')"
                            >
                                <i class="fa fa-file"></i> {{ $t('Other') }}
                            </a>
                        </li>
                        <li class="nav-item" v-if="false">
                            <a class="nav-link"
                               :class="{ 'show active': showTab === 'invoice' }"
                               href="#"
                               @click.prevent="changeTab('invoice')"
                            >
                                <i class="fa fa-money"></i> {{ $t('Invoice') }}
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content" id="setting-tab-content">

                        <div class="tab-pane fade show active" v-if="showTab === 'profile'">
                            <Form @submit="updateCustomerProfile" v-slot="{errors}">
                                <div class="row">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{ $t('First name') }}</label>
                                            <Field class="form-control"
                                                   v-model="profileForm.first_name"
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
                                                   v-model="profileForm.last_name"
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
                                                   v-model="profileForm.gender"
                                                   as="select"
                                                   rules="required"
                                                   :class="{'is-invalid': errors.gender}"
                                            >
                                                <option value="">{{ $t('Select gender') }}</option>
                                                <option :value="key" v-for="(gender, key) in Genders">{{
                                                        $t(gender)
                                                    }}
                                                </option>
                                            </Field>
                                            <ErrorMessage class="text-danger d-block" name="gender"/>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{ $t('Phone no') }}</label>
                                            <Field class="form-control"
                                                   v-model="profileForm.phone_no"
                                                   type="text"
                                                   name="phone_no"
                                                   :placeholder="$t('Enter phone no')"
                                            />
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{ $t('Street') }}</label>
                                            <Field class="form-control"
                                                   v-model="profileForm.street"
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
                                                   v-model="profileForm.postal_code"
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
                                                   v-model="profileForm.city"
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
                                                v-model="profileForm.country"
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
                                                :initial="profileForm.password"
                                                @change="updatePassword"
                                            ></VisiblePasswordInput>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{ $t('Email') }}</label>
                                            <Field class="form-control"
                                                   v-model="profileForm.email"
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
                                            <BsDatePicker v-model:value="profileForm.dob"
                                                            value-type="format"
                                                            format="DD.MM.YYYY"
                                                            placeholder="DD.MM.YYYY"
                                            ></BsDatePicker>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{ $t('Status') }}</label>
                                            <StatusSwitcher :is_active="profileForm.is_active"
                                                            @toggle="changeActiveStatus"
                                            ></StatusSwitcher>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{ $t('Is Special') }}</label>
                                            <StatusSwitcher :is_active="profileForm.is_special"
                                                            @toggle="changeIsSpecial"
                                            ></StatusSwitcher>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label>{{ $t('Secondary First name') }}</label>
                                            <Field class="form-control"
                                                   v-model="profileForm.secondary_first_name"
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
                                                   v-model="profileForm.secondary_last_name"
                                                   type="text"
                                                   name="secondary_last_name"
                                                   :placeholder="$t('Enter secondary last name')"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <button type="submit" class="btn btn-primary m-t-30">{{ $t('Update') }}</button>
                            </Form>
                        </div>

                        <div class="tab-pane fade show active" v-if="showTab === 'document'">
                            <table class="table-sm">
                                <tr>
                                    <td>{{ $t('Salesperson') }} :</td>
                                    <td>
                                        <template v-if="hasSalesperson()">
                                            <a href="#"
                                               @click.prevent="openSalesperson(customer.salesperson.id)"
                                            >{{ customer.salesperson.first_name + ' ' + customer.salesperson.last_name }}
                                            </a>
                                        </template>
                                        <template v-else>
                                            {{ 'Not Available' }}
                                        </template>
                                    </td>
                                </tr>
                            </table>

                        </div>

                        <div class="tab-pane fade show active" v-if="showTab === 'invoice' && false">
                            <div class="row">
                                <div class="col-md-5">
                                    <div class="invoice-settings">
                                        <div class="form-group">
                                            <label for="auto_invoice" class="ai-label m-r-10">{{ $t('Automatic Invoice') }}</label>
                                            <input type="checkbox"
                                                   id="auto_invoice"
                                                   v-model="invoiceForms.auto_invoice"
                                            />
                                        </div>
                                        <div class="form-group">
                                            <label for="auto_invoice_date" class="ai-label m-r-10">{{ $t('Invoice date of Month') }}</label>
                                            <select v-model="invoiceForms.auto_invoice_date"
                                                    id="auto_invoice_date"
                                                    class="form-control form-control-sm auto_invoice_input"
                                            >
                                                <option :value="date" v-for="date in 31">
                                                    {{ date }}
                                                </option>
                                            </select>
                                        </div>
                                        <button class="btn btn-primary m-t-30"
                                                @click.prevent="updateUserInvoiceSetting"
                                        >{{ $t('Update') }}</button>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import {Form, Field, ErrorMessage} from 'vee-validate';
import {ref, onMounted} from "vue";
import breadcrumbConfig from "@/storage/data/breadcrumbs";
import {countryList as countries} from "@/storage/data/countrylist";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import Notifier from "@/libraries/utils/Notifier";
import StatusSwitcher from "@/components/widgets/form/StatusSwitcher";
import Genders from "@/storage/data/genders";
import {useMembershipStore} from "@/storage/store/memberships";
import VisiblePasswordInput from "@/components/widgets/form/VisiblePasswordInput";
import HelperUtils from "@/libraries/utils/helpers/HelperUtils";
import DateFormatter from "@/libraries/utils/helpers/DateFormatter";
import {useI18n} from "vue-i18n";
import {useRoute, useRouter} from "vue-router";
import {useMeta} from "vue-meta";

const props = defineProps({
    data: {
        required: true,
        type: Object,
    }
});

const router = useRouter();
const routes = useRoute();
const { t: $t } = useI18n();
useMeta({title: $t('Customer Edit')});

const customerId = routes.params.id;
const showTab = ref('profile');
const customer = ref(props.data.value);

const profileForm = ref({
    id: '',
    uid: '',
    first_name: '',
    last_name: '',
    password: '',
    email: '',
    dob: null,
    phone_no: '',
    gender: '',
    street: '',
    postal_code: 0,
    city: '',
    country: '',
    is_special: 0,
    is_active: 0,
    membership: '',
    secondary_first_name: '',
    secondary_last_name: '',
});

const userForms = ref([]);
const invoiceForms = ref({
    auto_invoice: false,
    auto_invoice_date: 0,
});

mapUserIntoForm(props.data.value);

const memberships = await useMembershipStore().getMembershipsByRefresh();

function changeTab(tab) {
    showTab.value = tab;
}

function updateCountry(country) {
    if (country == null) {
        profileForm.value.country = '';
    }
}

function updatePassword(password) {
    profileForm.value.password = password;
}

function changeActiveStatus(isActive) {
    profileForm.value.is_active = isActive;
}

function changeIsSpecial(isSpecial) {
    profileForm.value.is_special = isSpecial;
}


function mapUserIntoForm(user) {
    profileForm.value.id = user.id;
    profileForm.value.uid = user.uid;
    profileForm.value.first_name = user.first_name;
    profileForm.value.last_name = user.last_name;
    profileForm.value.password = user.password_text;
    profileForm.value.email = user.email;
    profileForm.value.dob = user.dob;
    profileForm.value.phone_no = user.phone_no;
    profileForm.value.gender = user.gender;
    profileForm.value.street = user.street;
    profileForm.value.postal_code = user.postal_code;
    profileForm.value.city = user.city;
    profileForm.value.country = user.country;
    profileForm.value.is_special = user.is_special;
    profileForm.value.is_active = user.is_active;
    profileForm.value.membership = user.membership;
    profileForm.value.secondary_first_name = user.secondary_first_name;
    profileForm.value.secondary_last_name = user.secondary_last_name;

    userForms.value = user.forms;
    invoiceForms.value = {
        auto_invoice: user.auto_invoice,
        auto_invoice_date: user.auto_invoice_date,
    };
}


function hasContractDocument() {
    return customer.value.contract;
}

function downloadContractDocument(customerId, documentName) {
    axios.postDownload(route('admin.customers.download_contract_doc'), {
        user_id: customerId,
    })
        .then((response) => {
            if (response.status === 200) {
                HelperUtils.blobFileDownload(response, documentName);
            }
        });
}

function openSalesperson(salespersonId) {
    router.push('/admin/administrators/' + salespersonId);
}

function hasSalesperson() {
    return customer.value.salesperson;
}

function copyCustomerInfo() {
    HelperUtils.copyText(getCustomerInfo())
    Notifier.toastSuccess('Kopiert');
}

function getCustomerInfo() {
    return 'Ident: ' + HelperUtils.trimSpace(profileForm.value.uid) + ' \n' +
        'Name: ' + profileForm.value.first_name + ' ' + profileForm.value.last_name + '\n' +
        'Passwort: ' + (profileForm.value.password != null ? profileForm.value.password : '') + '\n' +
        '\n' +
        'Geburtsdatum: ' + profileForm.value.dob + '\n' +
        'Stadt: ' + profileForm.value.city + '\n' +
        'Plz: ' + profileForm.value.postal_code + '\n' +
        'Adresse: ' + profileForm.value.street + '\n' +
        profileForm.value.country + '\n' +
        'Registriert seit: ' + DateFormatter.inGerman(profileForm.value.created_at) + '\n' +
        'Mitgliedschaft: ' + profileForm.value.membership;
}

async function getCustomer() {
    await axios.get(route('admin.customers.show', {id: customerId}))
        .then((response) => {
            if (response.status === 200) {
                customer.value = response.data;
                mapUserIntoForm(customer.value);
            }
        });
}

function updateCustomerProfile() {
    axios.put(route('admin.customers.update', {id: customerId}), profileForm.value).then(async (response) => {
        if (response.status === 200) {
            Notifier.toastSuccess(response.data.message);
            await getCustomer();
        }
    });
}

function updateUserInvoiceSetting() {
    axios.post(route('admin.customers.update_invoice_setting'), {...invoiceForms.value, ...{user_id: customerId}})
        .then(async (response) => {
            if (response.status === 200) {
                Notifier.toastSuccess(response.data.message);
                await getCustomer();
            }
        });
}

onMounted(() => {

});

</script>