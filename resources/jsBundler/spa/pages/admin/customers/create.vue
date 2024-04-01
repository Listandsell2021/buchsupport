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
                                    <label>{{ $t('Membership') }}</label>
                                    <BsSelect
                                        v-model="form.membership"
                                        :options="memberships"
                                        label="name"
                                        :reduce="membership => membership.id"
                                        :clearable="false"
                                        :placeholder="$t('Select Membership')"
                                    ></BsSelect>
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


                        <div class="mt-3 clearfix">
                            <button class="btn btn-primary pull-right" @click.prevent="addForm">
                                <i class="m-r-5 fa fa-plus"></i> {{ $t('Add Form') }}
                            </button>
                        </div>

                        <div class="product-addition-container">
                            <div class="p-addition-item" v-for="(form, formIndex) in form.forms" :key="form.id">

                                <div class="p-addition-item-controller">
                                    <div class="row">
                                        <div class="col-md-8 offset-md-2">
                                            <div class="row">
                                                <div class="col">
                                                    <label>{{ $t('Purchased Date') }}</label>
                                                    <div class="vue-google-datepicker-wrapper">
                                                        <BsDatePicker v-model:value="form.purchase_date"
                                                                     value-type="format"
                                                                     format="DD.MM.YYYY"
                                                                     placeholder="DD.MM.YYYY"
                                                        ></BsDatePicker>
                                                    </div>
                                                </div>
                                                <div class="col">
                                                    <label>{{ $t('Status') }}</label>
                                                    <StatusSwitcher :is_active="form.status"
                                                                    @toggle="changeFormStatus(form, $event)"
                                                    ></StatusSwitcher>
                                                </div>
                                                <div class="col">
                                                    <button @click.prevent="removeForm(formIndex)"
                                                            class="btn btn-pasi-form-remove btn-danger btn-sm">
                                                        <i class="m-r-5 fa fa-trash"></i>
                                                        {{ $t('Remove Form') }}
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 mt-3">
                                    <button class="btn btn-sm btn-primary" @click.prevent="addProductToForm(formIndex)">
                                        <i class="m-r-5 fa fa-plus"></i>
                                        {{ $t('Add Product') }}
                                    </button>
                                </div>

                                <div class="p-addition-sub-item" v-for="(product, productIndex) in form.products" :key="product.id">
                                    <button @click.prevent="removeProduct(form.products, productIndex)"
                                            class="btn btn-pasi-remove btn-danger btn-sm">
                                        <i class="fa fa-trash"></i>
                                    </button>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <label>{{ $t('Product') }}</label>
                                            <BsSelect :options="products"
                                                       v-model="product.product_id"
                                                       :reduce="product => product.id"
                                                       label="name"
                                                       :placeholder="$t('Select Product')">
                                                <div slot="no-options">{{ $t('Sorry no matching result') }}</div>
                                            </BsSelect>
                                        </div>
                                        <div class="col-md-2">
                                            <label>{{ $t('Price') }}</label>
                                            <Field class="form-control"
                                                   v-model="product.price"
                                                   type="number"
                                                   :name="'product_price_'+formIndex+'_'+productIndex"
                                                   min="1"
                                                   :placeholder="$t('Enter Price')"
                                            />
                                        </div>
                                        <div class="col-md-2">
                                            <label>{{ $t('Quantity') }}</label>
                                            <Field class="form-control"
                                                   v-model="product.quantity"
                                                   type="number"
                                                   :name="'product_quantity_'+formIndex+'_'+productIndex"
                                                   min="1"
                                                   :placeholder="$t('Enter Quantity')"
                                            />
                                        </div>
                                        <div class="col-md-1">
                                            <label>{{ $t('Condition') }}</label>
                                            <div>
                                                <i v-for="number in product.condition"
                                                   class="product-form-star fa fa-star"
                                                ></i>
                                            </div>
                                            <div>
                                                <div class="btn-group product-form-condition-action">
                                                    <button class="btn btn-primary btn-xs"
                                                            @click.prevent="decreaseProductCondition(product)">
                                                        <i class="fa fa-minus"></i>
                                                    </button>
                                                    <button class="btn btn-primary btn-xs"
                                                            @click.prevent="increaseProductCondition(product)">
                                                        <i class="fa fa-plus"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label>{{ $t('Note') }}</label>
                                                <textarea class="form-control"
                                                          rows="3"
                                                          :placeholder="$t('Enter Note')"
                                                          v-model="product.note"
                                                ></textarea>
                                            </div>
                                        </div>
                                    </div>

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
import {onMounted, ref, watch} from "vue";
import { Form, Field, ErrorMessage } from 'vee-validate';
import breadcrumbConfig from "@/storage/data/breadcrumbs";
import { countryList as countries } from "@/storage/data/countrylist";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import StatusSwitcher from "@/components/widgets/form/StatusSwitcher";
import Notifier from "@/libraries/utils/Notifier";
import Genders from "@/storage/data/genders";
import { useMembershipStore } from "@/storage/store/memberships";
import moment from "moment";
import VisiblePasswordInput from "@/components/widgets/form/VisiblePasswordInput";
import PasswordGenerator from "@/libraries/utils/helpers/PasswordGenerator";
import { useProductStore } from "@/storage/store/products";
import {useI18n} from "vue-i18n";
import {useRouter} from "vue-router";
import {useMeta} from "vue-meta";


const router = useRouter();
const { t: $t } = useI18n();
useMeta({title: $t('Customer Create')});

const memberships = await useMembershipStore().getMembershipsByRefresh();
const products = await useProductStore().getProductsByRefresh();

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
    is_active: '',
    membership: '',
    secondary_first_name: '',
    secondary_last_name: '',
    forms: [],
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

function changeFormStatus(form, isActive) {
    form.status = isActive;
}

function addForm() {
    form.value.forms.push({
        id: PasswordGenerator.getString(10),
        purchase_date: null,
        status: 1,
        products: [],
    });
}

function addProductToForm(formIndex) {
    form.value.forms[formIndex].products.push({
        id: PasswordGenerator.getString(10),
        product_id: '',
        price: 10,
        quantity: 1,
        condition: 5,
        note: '',
        position: 0,
        is_hidden: 0,
        show_price: 0,
        show_purchase_date: 0,
    });
}

function decreaseProductCondition(product) {
    if (product.condition === 1) {
        return;
    }
    --product.condition;
}

function increaseProductCondition(product) {
    if (product.condition === 5) {
        return;
    }
    ++product.condition;
}

function removeForm(formIndex) {
    form.value.forms.splice(formIndex, 1);
}

function removeProduct(products, index) {
    products.splice(index, 1);
}

onMounted(async () => {

})

</script>