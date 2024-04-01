<template>
    <div>

        <Breadcrumbs :menu-items="breadcrumbConfig.setting.list()" :title="$t('Settings')"/>

        <div class="container-fluid">
            <div class="card">
                <div class="card-body">

                    <ul class="nav nav-tabs search-list" id="top-tab" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link"
                               :class="{ 'show active': showTab === 'company' }"
                               href="#"
                               @click.prevent="changeTab('company')"
                            ><i class="fa fa-info"></i> {{ $t('Basic Information') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                               :class="{ 'show active': showTab === 'bank' }"
                               href="#"
                               @click.prevent="changeTab('bank')"
                            >
                                <i class="fa fa-bank"></i> {{ $t('Bank Information') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                               :class="{ 'show active': showTab === 'commission' }"
                               href="#"
                               @click.prevent="changeTab('commission')"
                            >
                                <i class="fa fa-money"></i> {{ $t('Commission') }}
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link"
                               :class="{ 'show active': showTab === 'invoice' }"
                               href="#"
                               @click.prevent="changeTab('invoice')"
                            >
                                <i class="fa fa-inbox"></i> {{ $t('Invoice') }}
                            </a>
                        </li>
                    </ul>

                    <div class="tab-content" id="setting-tab-content">

                        <div class="tab-pane fade show active" v-if="showTab === 'company'">
                            <Form @submit="updateSettings(companyInfo)" v-slot="{errors}">
                                <div class="setting-list row">
                                    <div class="col-md-6">
                                    <div class="form-group">
                                        <label>{{ $t('Company Name') }}</label>
                                        <Field class="form-control"
                                               v-model="settings.company_name"
                                               type="text"
                                               name="company_name"
                                               rules="required"
                                               :placeholder="$t('Enter company name')"
                                               :class="{'is-invalid': errors.company_name}"
                                        />
                                        <ErrorMessage class="text-danger d-block" name="company_name"/>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ $t('Street') }}</label>
                                        <Field class="form-control"
                                               v-model="settings.company_street_address"
                                               type="text"
                                               name="street_address"
                                               rules="required"
                                               :placeholder="$t('Enter Street')"
                                               :class="{'is-invalid': errors.street_address}"
                                        />
                                        <ErrorMessage class="text-danger d-block" name="street_address"/>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ $t('Postal Code') }}</label>
                                        <Field class="form-control"
                                               v-model="settings.company_postal_code"
                                               type="text"
                                               name="postal_code"
                                               rules="required"
                                               :placeholder="$t('Enter Postal Code')"
                                               :class="{'is-invalid': errors.postal_code}"
                                        />
                                        <ErrorMessage class="text-danger d-block" name="postal_code"/>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ $t('City') }}</label>
                                        <Field class="form-control"
                                               v-model="settings.company_city"
                                               type="text"
                                               name="city"
                                               rules="required"
                                               :placeholder="$t('Enter City')"
                                               :class="{'is-invalid': errors.city}"
                                        />
                                        <ErrorMessage class="text-danger d-block" name="city"/>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ $t('Phone No') }}</label>
                                        <Field class="form-control"
                                               v-model="settings.company_phone_no"
                                               type="text"
                                               name="phone_no"
                                               rules="required"
                                               :placeholder="$t('Enter Phone No')"
                                               :class="{'is-invalid': errors.phone_no}"
                                        />
                                        <ErrorMessage class="text-danger d-block" name="phone_no"/>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ $t('Email') }}</label>
                                        <Field class="form-control"
                                               v-model="settings.company_email"
                                               type="text"
                                               name="email"
                                               rules="required"
                                               :placeholder="$t('Enter Email')"
                                               :class="{'is-invalid': errors.email}"
                                        />
                                        <ErrorMessage class="text-danger d-block" name="email"/>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ $t('Fax') }}</label>
                                        <Field class="form-control"
                                               v-model="settings.company_fax"
                                               type="text"
                                               name="fax"
                                               rules="required"
                                               :placeholder="$t('Enter Fax')"
                                               :class="{'is-invalid': errors.fax}"
                                        />
                                        <ErrorMessage class="text-danger d-block" name="fax"/>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ $t('Website') }}</label>
                                        <Field class="form-control"
                                               v-model="settings.company_website"
                                               type="text"
                                               name="website"
                                               rules="required"
                                               :placeholder="$t('Enter Website')"
                                               :class="{'is-invalid': errors.website}"
                                        />
                                        <ErrorMessage class="text-danger d-block" name="website"/>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ $t('Registration Court/No') }}</label>
                                        <Field class="form-control"
                                               v-model="settings.company_registration_no"
                                               type="text"
                                               name="registration_no"
                                               rules="required"
                                               :placeholder="$t('Enter Registration Court/No')"
                                               :class="{'is-invalid': errors.registration_no}"
                                        />
                                        <ErrorMessage class="text-danger d-block" name="registration_no"/>
                                    </div>
                                    <div class="form-group">
                                        <label>{{ $t('Managing Director') }}</label>
                                        <Field class="form-control"
                                               v-model="settings.company_manager"
                                               type="text"
                                               name="company_manager"
                                               rules="required"
                                               :placeholder="$t('Enter Managing Director')"
                                               :class="{'is-invalid': errors.company_manager}"
                                        />
                                        <ErrorMessage class="text-danger d-block" name="company_manager"/>
                                    </div>
                                </div>
                                </div>
                                <button type="submit" class="btn btn-primary">{{ $t('Update') }}</button>
                            </Form>
                        </div>

                        <div class="tab-pane fade show active" v-if="showTab === 'bank'" >
                            <Form @submit="updateSettings(bankInfo)" v-slot="{errors}">
                                <div class="setting-list row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ $t('Bank Name') }}</label>
                                            <Field class="form-control"
                                                   v-model="settings.bank_name"
                                                   type="text"
                                                   name="bank_name"
                                                   rules="required"
                                                   :placeholder="$t('Enter bank name')"
                                                   :class="{'is-invalid': errors.bank_name}"
                                            />
                                            <ErrorMessage class="text-danger d-block" name="bank_name"/>
                                        </div>
                                        <div class="form-group">
                                            <label>{{ $t('Bank IBAN No') }}</label>
                                            <Field class="form-control"
                                                   v-model="settings.bank_iban_no"
                                                   type="text"
                                                   name="iban_no"
                                                   rules="required"
                                                   :placeholder="$t('Enter IBAN No')"
                                                   :class="{'is-invalid': errors.iban_no}"
                                            />
                                            <ErrorMessage class="text-danger d-block" name="iban_no"/>
                                        </div>
                                        <div class="form-group">
                                            <label>{{ $t('Bank BIC No') }}</label>
                                            <Field class="form-control"
                                                   v-model="settings.bank_bic_no"
                                                   type="text"
                                                   name="bic_no"
                                                   rules="required"
                                                   :placeholder="$t('Enter BIC No')"
                                                   :class="{'is-invalid': errors.bic_no}"
                                            />
                                            <ErrorMessage class="text-danger d-block" name="bic_no"/>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">{{ $t('Update') }}</button>
                            </Form>
                        </div>

                        <div class="tab-pane fade show active" v-if="showTab === 'commission'" >
                            <Form @submit="updateSettings(commissionInfo)" v-slot="{errors}">
                                <div class="setting-list row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label>{{ $t('Commission %') }}</label>
                                            <Field class="form-control"
                                                   v-model="settings.commission_percentage"
                                                   type="text"
                                                   name="commission_percentage"
                                                   rules="required"
                                                   :placeholder="$t('Enter Commission %')"
                                                   :class="{'is-invalid': errors.commission_percentage}"
                                            />
                                            <ErrorMessage class="text-danger d-block" name="bank_name"/>
                                        </div>
                                        <div class="form-group">
                                            <label>{{ $t('Commission Threshold Amount') }}</label>
                                            <Field class="form-control"
                                                   v-model="settings.threshold_amount"
                                                   type="text"
                                                   name="threshold_amount"
                                                   rules="required"
                                                   :placeholder="$t('Enter Threshold Amount')"
                                                   :class="{'is-invalid': errors.threshold_amount}"
                                            />
                                            <ErrorMessage class="text-danger d-block" name="threshold_amount"/>
                                        </div>
                                        <div class="form-group">
                                            <label>{{ $t('Commission % after Threshold Amount') }}</label>
                                            <Field class="form-control"
                                                   v-model="settings.percentage_above_threshold"
                                                   type="text"
                                                   name="percentage_above_threshold"
                                                   rules="required"
                                                   :placeholder="$t('Enter Threshold Commission %')"
                                                   :class="{'is-invalid': errors.percentage_above_threshold}"
                                            />
                                            <ErrorMessage class="text-danger d-block" name="percentage_above_threshold"/>
                                        </div>
                                    </div>
                                </div>
                                <button type="submit" class="btn btn-primary">{{ $t('Update') }}</button>
                            </Form>
                        </div>

                        <div class="tab-pane fade show active" v-if="showTab === 'invoice'" >

                            <Form @submit="updateSettings(invoiceInfo)" v-slot="{errors}">
                                <div class="setting-list invoice-settings">

                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label>{{ $t('Vat ID') }}</label>
                                                <Field class="form-control"
                                                       v-model="settings.vat_id"
                                                       type="text"
                                                       name="vat_id"
                                                       rules="required"
                                                       :placeholder="$t('Enter Vat ID')"
                                                       :class="{'is-invalid': errors.vat_id}"
                                                />
                                                <ErrorMessage class="text-danger d-block" name="vat_id"/>
                                            </div>
                                            <div class="form-group">
                                                <label>{{ $t('VAT %') }}</label>
                                                <Field class="form-control"
                                                       v-model="settings.vat_percentage"
                                                       type="text"
                                                       name="vat_percentage"
                                                       rules="required"
                                                       :placeholder="$t('Enter Vat %')"
                                                       :class="{'is-invalid': errors.vat_percentage}"
                                                />
                                                <ErrorMessage class="text-danger d-block" name="vat_percentage"/>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="gap-maintainer"></div>

                                    <div class="group-tabs">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{ $t('Invoice Heading') }}</label>

                                                    <div class="mail-variable-list m-b-15">
                                                        <a href="#"
                                                           class="mail-variable-item m-r-10"
                                                           @click.prevent="addVariableToEditor(invoiceHeading.getEditor(), 'invoice_no')"
                                                        >
                                                            <i class="fa fa-anchor"></i> invoice_no
                                                        </a>
                                                    </div>
                                                    <BsEditor
                                                        :api-key="PluginConfig.tinyMce.key"
                                                        :init="PluginConfig.tinyMce.config"
                                                        v-model="settings.invoice_heading"
                                                        ref="invoiceHeading"
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{ $t('Invoice Description') }}</label>
                                                    <div class="mail-variable-list m-b-15">
                                                        <a href="#"
                                                           class="mail-variable-item m-r-10"
                                                           @click.prevent="addVariableToEditor(invoiceDescription.getEditor(), 'customer')"
                                                        >
                                                            <i class="fa fa-anchor"></i> Customer
                                                        </a>
                                                        <a href="#"
                                                           class="mail-variable-item m-r-10"
                                                           @click.prevent="addVariableToEditor(invoiceDescription.getEditor(), 'invoice_date')"
                                                        >
                                                            <i class="fa fa-anchor"></i> Invoice Date
                                                        </a>
                                                        <a href="#"
                                                           class="mail-variable-item m-r-10"
                                                           @click.prevent="addVariableToEditor(invoiceDescription.getEditor(), 'invoice_price')"
                                                        >
                                                            <i class="fa fa-anchor"></i> Invoice Price
                                                        </a>
                                                    </div>
                                                    <BsEditor
                                                        :api-key="PluginConfig.tinyMce.key"
                                                        :init="PluginConfig.tinyMce.config"
                                                        v-model="settings.invoice_description"
                                                        ref="invoiceDescription"
                                                    />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{ $t('Invoice Starting No') }}</label>
                                                    <Field class="form-control"
                                                           v-model="settings.invoice_starting_no"
                                                           type="number"
                                                           name="invoice_starting_no"
                                                           :placeholder="$t('Enter Invoice Starting No')"
                                                           :class="{'is-invalid': errors.invoice_starting_no}"
                                                    />
                                                    <ErrorMessage class="text-danger d-block" name="invoice_starting_no"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{ $t('Enable Invoice Starting No') }}</label>
                                                    <StatusSwitcher :is_active="settings.enable_invoice_starting_no"
                                                                    @toggle="($event) => (settings.enable_invoice_starting_no = $event)"
                                                    ></StatusSwitcher>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="gap-maintainer"></div>

                                    <div class="group-tabs">

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{ $t('Cancelled Invoice Heading') }}</label>
                                                    <BsEditor
                                                        :api-key="PluginConfig.tinyMce.key"
                                                        :init="PluginConfig.tinyMce.config"
                                                        v-model="settings.cancelled_invoice_heading"
                                                        ref="cancelledInvoiceHeading"
                                                    />
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{ $t('Cancelled Invoice Description') }}</label>
                                                    <BsEditor
                                                        :api-key="PluginConfig.tinyMce.key"
                                                        :init="PluginConfig.tinyMce.config"
                                                        v-model="settings.cancelled_invoice_description"
                                                        ref="cancelledInvoiceDescription"
                                                    />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{ $t('Cancelled Invoice Starting No') }}</label>
                                                    <Field class="form-control"
                                                           v-model="settings.cancelled_invoice_starting_no"
                                                           type="number"
                                                           name="cancellation_starting_no"
                                                           :placeholder="$t('Enter Cancelled Invoice Starting No')"
                                                           :class="{'is-invalid': errors.cancelled_invoice_starting_no}"
                                                    />
                                                    <ErrorMessage class="text-danger d-block" name="cancelled_invoice_starting_no"/>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label>{{ $t('Enable Cancelled Invoice Starting No') }}</label>
                                                    <StatusSwitcher :is_active="settings.enable_cancelled_invoice_starting_no"
                                                                    @toggle="($event) => (settings.enable_cancelled_invoice_starting_no = $event)"
                                                    ></StatusSwitcher>
                                                </div>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="gap-maintainer"></div>

                                    <div class="group-tabs">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label>{{ $t('Payment Reminder') }}</label>
                                                    <div class="mail-variable-list m-b-15">
                                                        <a href="#"
                                                           class="mail-variable-item m-r-10"
                                                           @click.prevent="addVariableToEditor(paymentReminder.getEditor(), 'invoice_no')"
                                                        >
                                                            <i class="fa fa-anchor"></i> Invoice No
                                                        </a>
                                                        <a href="#"
                                                           class="mail-variable-item m-r-10"
                                                           @click.prevent="addVariableToEditor(paymentReminder.getEditor(), 'customer')"
                                                        >
                                                            <i class="fa fa-anchor"></i> Customer
                                                        </a>
                                                        <a href="#"
                                                           class="mail-variable-item m-r-10"
                                                           @click.prevent="addVariableToEditor(paymentReminder.getEditor(), 'invoice_date')"
                                                        >
                                                            <i class="fa fa-anchor"></i> Invoice Date
                                                        </a>
                                                        <a href="#"
                                                           class="mail-variable-item m-r-10"
                                                           @click.prevent="addVariableToEditor(paymentReminder.getEditor(), 'invoice_price')"
                                                        >
                                                            <i class="fa fa-anchor"></i> Invoice Price
                                                        </a>
                                                        <a href="#"
                                                           class="mail-variable-item m-r-10"
                                                           @click.prevent="addVariableToEditor(paymentReminder.getEditor(), 'company_name')"
                                                        >
                                                            <i class="fa fa-anchor"></i> Company Name
                                                        </a>
                                                    </div>
                                                    <BsEditor
                                                        :api-key="PluginConfig.tinyMce.key"
                                                        :init="PluginConfig.tinyMce.config"
                                                        v-model="settings.payment_reminder_text"
                                                        ref="paymentReminder"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="gap-maintainer"></div>

                                    <div class="group-tabs">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <div class="form-group">
                                                    <label>{{ $t('Payment Warning') }}</label>
                                                    <div class="mail-variable-list m-b-15">
                                                        <a href="#"
                                                           class="mail-variable-item m-r-10"
                                                           @click.prevent="addVariableToEditor(paymentWarning.getEditor(), 'customer')"
                                                        >
                                                            <i class="fa fa-anchor"></i> Customer Name
                                                        </a>
                                                        <a href="#"
                                                           class="mail-variable-item m-r-10"
                                                           @click.prevent="addVariableToEditor(paymentWarning.getEditor(), 'invoice_date')"
                                                        >
                                                            <i class="fa fa-anchor"></i> Invoice Date
                                                        </a>
                                                        <a href="#"
                                                           class="mail-variable-item m-r-10"
                                                           @click.prevent="addVariableToEditor(paymentWarning.getEditor(), 'current_date')"
                                                        >
                                                            <i class="fa fa-anchor"></i> Current Date
                                                        </a>
                                                        <a href="#"
                                                           class="mail-variable-item m-r-10"
                                                           @click.prevent="addVariableToEditor(paymentWarning.getEditor(), 'invoice_price')"
                                                        >
                                                            <i class="fa fa-anchor"></i> Invoice Price
                                                        </a>
                                                        <a href="#"
                                                           class="mail-variable-item m-r-10"
                                                           @click.prevent="addVariableToEditor(paymentWarning.getEditor(), 'invoice_price_with_charge')"
                                                        >
                                                            <i class="fa fa-anchor"></i> Invoice Price With Charge
                                                        </a>
                                                        <a href="#"
                                                           class="mail-variable-item m-r-10"
                                                           @click.prevent="addVariableToEditor(paymentWarning.getEditor(), 'company_name')"
                                                        >
                                                            <i class="fa fa-anchor"></i> Company Name
                                                        </a>
                                                    </div>
                                                    <BsEditor
                                                        :api-key="PluginConfig.tinyMce.key"
                                                        :init="PluginConfig.tinyMce.config"
                                                        v-model="settings.payment_warning_text"
                                                        ref="paymentWarning"
                                                    />
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="gap-maintainer"></div>

                                </div>
                                <button type="submit" class="btn btn-primary">{{ $t('Update') }}</button>
                            </Form>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import {onMounted, ref} from "vue";
import axios from '@/libraries/utils/clientapi/axios';
import breadcrumbConfig from "@/storage/data/breadcrumbs";
import route from '@/libraries/utils/ZiggyRoute';
import { Form, Field, ErrorMessage } from 'vee-validate';
import PluginConfig from "@/config/plugins";
import StatusSwitcher from "@/components/widgets/form/StatusSwitcher";
import Notifier from "@/libraries/utils/Notifier";
import {useRouter} from "vue-router";
import {useI18n} from "vue-i18n";
import {useMeta} from "vue-meta";

const router = useRouter();
const { t: $t } = useI18n();
useMeta({title: $t('Settings')});

const invoiceHeading = ref(null);
const invoiceDescription = ref(null);
const cancelledInvoiceHeading = ref(null);
const cancelledInvoiceDescription = ref(null);
const paymentReminder = ref(null);
const paymentWarning = ref(null);
const creditNoteHeading = ref(null);
const creditNoteDescription = ref(null);

const showTab = ref('company');

const companyInfo = {
    company_name: '',
    company_street_address: '',
    company_postal_code: '',
    company_city: '',
    company_phone_no: '',
    company_email: '',
    company_fax: '',
    company_website: '',
    company_directors: '',
    company_registration_no: '',
    company_manager: '',
}

const bankInfo = {
    bank_name: '',
    bank_iban_no: '',
    bank_bic_no: '',
}

const commissionInfo = {
    commission_percentage: '',
    threshold_amount: '',
    percentage_above_threshold: '',
}

const invoiceInfo = {
    vat_id: '',
    vat_percentage: '',

    invoice_heading: '',
    invoice_description: '',
    invoice_starting_no: '',
    enable_invoice_starting_no: 0,

    cancelled_invoice_heading: '',
    cancelled_invoice_description: '',
    cancelled_invoice_starting_no: '',
    enable_cancelled_invoice_starting_no: 0,

    payment_reminder_text: '',

    payment_warning_text: '',

    credit_note_heading: '',
    credit_note_description: '',
    credit_note_starting_no: '',
    enable_credit_note_starting_no: 0,

    invoice_signature: '',
}

const settings = ref(Object.assign({}, companyInfo, bankInfo, commissionInfo, invoiceInfo));

const getSettingList = async () => {

    await axios.get(route('admin.settings.list'), {}, {}, true).then(response => {
        settings.value = response.data.data;
    });

}

function updateSettings(data) {
    axios.post(route('admin.settings.update'), getFormData(data)).then(response => {
        if (response.status === 200) {
            Notifier.toastSuccess(response.data.message);
            getSettingList();
        }
    });
}

function addVariableToEditor(editor, variable) {
    editor.selection.setContent('{'+variable+'}');
}

function changeTab(tab) {
    showTab.value = tab;
}

function getFormData(data) {

    let form = {};

    for (let key in data) {
        form[key] = settings.value[key];
    }

    return form;
}


onMounted(async () => {
    await getSettingList();
})

</script>