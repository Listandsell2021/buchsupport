<template>
    <div>

        <Breadcrumbs :menu-items="breadcrumbConfig.invoice.create()" :title="$t('Invoice Create')"/>

        <div class="container-fluid">
            <div class="card">
                <div class="card-body">

                    <div class="create-invoice-header">
                        <div class="row">
                            <div class="col-md-3">
                                <div class="">
                                    <label for="">{{ $t('Select Customer') }}</label>
                                    <BsSelect
                                        :filterable="false"
                                        v-model="form.user_id"
                                        :options="customers"
                                        :reduce="customer => customer.id"
                                        label="name"
                                        @update:model-value="getInvoiceData"
                                        @search="searchCustomers"
                                    >
                                        <template #no-options="{ search, searching, loading }">
                                            {{ (search.length > 0) && searching ? $t('No customers found') : $t('Search customers') }}
                                        </template>
                                    </BsSelect>
                                </div>

                            </div>
                            <div class="col-md-9">
                                <div class="clearfix">
                                    <a href="#"
                                       class="btn btn-info pull-left"
                                       @click.prevent="getInvoiceData"
                                    ><i class="fa fa-refresh"></i> {{ $t('Reload') }}</a>
                                    <button class="btn btn-primary pull-right"
                                            @click.prevent="createCustomInvoice"
                                    >{{ $t('Create Invoice') }}</button>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="invoice__Header">
                        <div class="clearfix">
                            <div class="pull-right">
                                <img src="/assets/admin/images/logo.png" alt="logo">
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-7">
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="inv__Input input__Company m-b-20">
                                            {{ form.__company_address }}
                                        </div>
                                        <div class="inv__Input input__UserGender">
                                            <select v-model="form.user_gender"
                                                    id="gender"
                                                    class="form-control form-control-sm"
                                            >
                                                <option :value="gender.id" v-for="gender in Genders">
                                                    {{ $t(gender.name) }}
                                                </option>
                                            </select>
                                        </div>
                                        <div class="inv__Input input__Username">
                                            <input type="text"
                                                   class="form-control form-control-sm"
                                                   v-model="form.user_name"
                                                   :placeholder="$t('Enter client name')"
                                            />
                                        </div>
                                        <div class="inv__Input input__UserAddress">
                                            <textarea class="form-control form-control-sm"
                                                      v-model="form.user_address"
                                                      :placeholder="$t('Enter client address')"
                                            ></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-5">
                                <div class="m-b-20">
                                    <strong>{{ $t('How to reach us') }}</strong>
                                </div>
                                <div class="row inv__Input">
                                    <div class="col-md-5">{{ $t('Internet') }}</div>
                                    <div class="col-md-7">{{ form.__company_website }}</div>
                                </div>
                                <div class="row inv__Input">
                                    <div class="col-md-5">{{ $t('Inv-Email') }}</div>
                                    <div class="col-md-7">{{ form.__company_email }}</div>
                                </div>
                                <div class="row inv__Input">
                                    <div class="col-md-5">{{ $t('Telephone') }}</div>
                                    <div class="col-md-7">{{ form.__company_phone_no }}</div>
                                </div>
                                <div class="row inv__Input m-t-20">
                                    <div class="col-md-5">{{ $t('Vat Id') }}</div>
                                    <div class="col-md-7">{{ form.__company_vat_id }}</div>
                                </div>
                                <div class="row inv__Input m-t-20">
                                    <div class="col-md-5">{{ $t('Date') }}</div>
                                    <div class="col-md-7">
                                        <BsDatePicker v-model:value="form.invoice_date"
                                                        value-type="format"
                                                        format="DD.MM.YYYY"
                                                        placeholder="DD.MM.YYYY"
                                                        @change="updateInvoiceNo"
                                        ></BsDatePicker>
                                    </div>
                                </div>
                                <div class="row inv__Input">
                                    <div class="col-md-5">{{ $t('Customer') }}</div>
                                    <div class="col-md-7">
                                        <input type="text"
                                               class="form-control form-control-sm"
                                               v-model="form.user_no"
                                               :placeholder="$t('Enter client no')"
                                        />
                                    </div>
                                </div>
                                <div class="row inv__Input">
                                    <div class="col-md-5">{{ $t('Performa-Invoice') }}</div>
                                    <div class="col-md-7">
                                        {{ form.invoice_no }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>


                    <div class="invoice__Body">
                        <div class="invoice__Title">
                            <div v-html="HelperUtils.getInvoiceTemplate(form.__invoice_heading, templateStrings())"></div>
                        </div>

                        <div class="invoice__Services m-t-20">
                            <div class="service__Table">
                                <table class="table">
                                <tbody>
                                    <tr>
                                        <td></td>
                                        <td><strong>{{ $t('Pos') }}</strong></td>
                                        <td><strong>{{ $t('Item no') }}</strong></td>
                                        <td class="col__Service"><strong>{{ $t('Inv-Service') }}</strong></td>
                                        <td><strong>{{ $t('Quantity') }}</strong></td>
                                        <td><strong>{{ $t('Unit Price') }}</strong></td>
                                        <td><strong>{{ $t('Inv Service Total') }}</strong></td>
                                    </tr>
                                    <tr v-for="(service, index) in form.services">
                                        <td>
                                            <a href="#"
                                               class="btn btn-xs btn-danger"
                                               @click.prevent="removeService(index)"
                                               v-if="index>0"
                                            >
                                                <i class="fa fa-trash"></i>
                                            </a>
                                        </td>
                                        <td>{{ index+1 }}</td>
                                        <td>
                                            <input type="text"
                                                   class="form-control form-control-sm"
                                                   v-model="service.item_no"
                                                   :placeholder="$t('Enter item no')"
                                            />
                                        </td>
                                        <td>
                                            <textarea class="form-control form-control-sm"
                                                      v-model="service.service"
                                                      rows="3"
                                                      :placeholder="$t('Enter service description')"
                                            ></textarea>
                                        </td>
                                        <td>
                                            <input type="text"
                                                   class="form-control form-control-sm"
                                                   v-model="service.quantity"
                                                   :placeholder="$t('Enter quantity')"
                                            />
                                        </td>
                                        <td>
                                            <input type="text"
                                                   class="form-control form-control-sm"
                                                   v-model="service.unit_price"
                                                   :placeholder="$t('Enter unit price')"
                                            />
                                        </td>
                                        <td>
                                            <input type="text"
                                                   class="form-control form-control-sm"
                                                   v-model="service.total_price"
                                                   :placeholder="$t('Enter service total')"
                                            />
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="7">
                                            <button class="btn btn-xs btn-primary pull-right"
                                                    @click.prevent="addService"
                                            >
                                                <i class="fa fa-plus"></i>
                                            </button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            </div>

                            <div class="row">
                                <div class="col-md-4 offset-md-8">
                                     <div class="row m-b-10">
                                         <div class="col">{{ $t('Subtotal') }}</div>
                                         <div class="col">
                                             <input type="number"
                                                    v-model="form.subtotal"
                                                    class="form-control form-control-sm"
                                                    :placeholder="$t('Enter subtotal')"
                                             />
                                         </div>
                                     </div>
                                    <div class="row m-b-10">
                                        <div class="col">
                                            <div class="row">
                                                <span class="col">{{ $t('Value Added Tax') }}</span>
                                                <div class="col">
                                                    <input type="text"
                                                           class="form-control form-control-sm"
                                                           v-model="form.vat"
                                                           :placeholder="$t('Enter vat percentage')"
                                                    />
                                                </div>
                                            </div>

                                        </div>
                                        <div class="col">
                                            <input type="number"
                                                   v-model="form.vat_total"
                                                   class="form-control form-control-sm"
                                                   :placeholder="$t('Enter vat total')"
                                            />
                                        </div>
                                    </div>
                                    <div class="row m-b-10 form__Total">
                                        <div class="col"><strong>{{ $t('Invoice Amount') }}</strong></div>
                                        <div class="col">
                                            <input type="number"
                                                   v-model="form.total"
                                                   class="form-control form-control-sm"
                                                   :placeholder="$t('Enter total')"
                                            />
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="invoice__Instruction m-t-20">
                            <div v-html="HelperUtils.getInvoiceTemplate(form.__invoice_description, templateStrings())"></div>
                        </div>

                    </div>

                    <div class="invoice__Footer">
                        <div class="row m-b-20">
                            <div class="col-md-5">
                                <p>{{ $t('Payment Receiver') }}<br>{{ $t('Bank Detail') }}</p>
                            </div>
                            <div class="col-md-7">
                                <div class="m-b-10">{{ $t('Consulting GmbH') }}</div>
                                <div class="m-b-10">
                                    {{ form.__bank_name }}
                                </div>
                                BIC {{ form.__bank_bic_no }},
                                IBAN {{ form.__bank_iban_no }}
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-5">
                                <strong>{{ $t('Managing Director') }}</strong>
                                <div>{{ form.__company_manager }}</div>
                            </div>
                            <div class="col-md-7">
                                <strong>{{ $t('Registration No') }}.</strong><br>
                                {{ form.__company_registration_no }}
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import {onMounted, ref, watch} from "vue";
import breadcrumbConfig from "@/storage/data/breadcrumbs";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import Notifier from "@/libraries/utils/Notifier";
import { GendersSelectable as Genders } from "@/storage/data/genders";
import HelperUtils from "@/libraries/utils/helpers/HelperUtils";
import __debounce from "lodash/debounce";
import __cloneDeep from "lodash/cloneDeep";
import {useI18n} from "vue-i18n";
import {useRouter} from "vue-router";
import {useMeta} from "vue-meta";


const router = useRouter();
const {t: $t} = useI18n();
useMeta({title: $t('Invoice Create')});

const customers = ref([]);
const form = ref({
    user_id: '',
    user_gender: 'male',
    user_name: '',
    user_address: '',
    invoice_date: '',
    user_no: '',
    invoice_no: '',

    services: [],
    service_total: 0,
    subtotal: 0,
    vat: 19,
    vat_total: 0,
    total: 0,

    __invoice_heading: '',
    __invoice_description: '',
    __company_website: '',
    __company_email: '',
    __company_phone_no: '',
    __company_vat_id: '',
    __company_address: '',
    __bank_name: '',
    __bank_bic_no: '',
    __bank_iban_no: '',
    __company_manager: '',
    __company_registration_no: '',
});


watch(() => __cloneDeep(form.value.services), (newServices, oldServices) => {

    let service_total = 0;

    for (let service of newServices) {
        service_total += parseInt(service.total_price);
    }

    form.value.service_total = service_total;
    form.value.vat_total = (form.value.vat * service_total) / 100;
    form.value.subtotal = form.value.service_total - form.value.vat_total;
    form.value.total = form.value.service_total;

})


function createCustomInvoice() {
    axios.post(route('admin.invoices.create_custom'), form.value)
        .then((response) => {
            if (response.status === 200) {
                Notifier.toastSuccess(response.data.message);
                form.value.user_id = '';
                router.push('/admin/invoices');
                getInvoiceData();
            }
    });
}


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

function templateStrings() {

    let customer = '';

    if (form.value.user_gender == 'male') {
        customer += 'Herr ';
    } else {
        customer += 'Frau ';
    }
    customer += form.value.user_name ?? ' ';

    return {
        invoice_no: form.value.invoice_no,
        customer: customer,
        invoice_date: form.value.invoice_date,
        invoice_price: HelperUtils.getInvoiceCurrency(form.value.total),
    };
}


function addService() {
    form.value.services.push({
        item_no: '',
        service: '',
        quantity: 1,
        unit_price: 0,
        total_price: 0
    });
}


function removeService(index) {
    form.value.services.splice(index, 1);
}

function updateInvoiceNo(invoiceDate) {
    if (invoiceDate) {
        axios.post(route('admin.invoices.invoice_no_by_date'), {
            invoice_date: invoiceDate,
        }).then((response) => {
            if (response.status === 200) {
                form.value.invoice_no = response.data.data;
            }
        });
    }
}

async function getInvoiceData(customerId = 0) {

    if (customerId == null) {
        form.value.user_id = '';
    }

    await axios.post(route('admin.invoices.get_invoice_data'), form.value).then((response) => {
        if (response.status === 200) {
            form.value = response.data.data;
        }
    });
}


onMounted(async () => {
    await getInvoiceData();
})

</script>