<template>
    <div>

        <Breadcrumbs :menu-items="breadcrumbConfig.invoice.list()" :title="$t('Invoice List')"/>

        <div class="container-fluid">

            <div class="clearfix mb-3">
                <div class="pull-left" v-if="isDataSelected()">
                    <div class="btn-group">
                        <select class="form-control"
                                style="width: 200px;"
                                v-model="form.selection.action"
                        >
                            <option value="">{{ $t('Action') }}</option>
                            <option value="paid">{{ $t('Mark as paid') }}</option>
                            <option value="unpaid">{{ $t('Mark as unpaid') }}</option>
                            <template v-if="false">
                                <option value="payment_reminder">{{ $t('Create payment reminder') }}</option>
                                <option value="payment_warning">{{ $t('Create payment warning') }}</option>
                                <option value="cancel_invoice">{{ $t('Cancel invoice') }}</option>
                            </template>
                            <option value="delete">{{ $t('Delete') }}</option>
                        </select>
                        <button class="btn btn-secondary"
                                @click.prevent="submitBulkAction()"
                        >{{ $t('Submit') }}</button>
                    </div>
                </div>
                <router-link to="invoices/create" class="btn btn-primary pull-right">
                    <i class="fa fa-plus"></i> {{ $t('Create New') }}
                </router-link>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="">
                        <table class="table">
                            <thead>
                            <Sorting :columns="form.columns"
                                     @column_changed="getInvoicesList"
                                     @filter="updateFilters"
                            >
                                <template v-slot:sorting_top>
                                    <th class="col-select-all">
                                        <input type="checkbox"
                                               class="checkbox_animated"
                                               v-model="form.selection.all"
                                               @change="selectAll()"
                                        />
                                    </th>
                                </template>
                                <template v-slot:sorting_bottom>
                                    <th class="fixed-t-right">{{ $t('Action') }}</th>
                                </template>
                            </Sorting>
                            </thead>
                            <tbody>
                            <template v-if="hasInvoices()">
                                <tr v-for="(invoice) in invoices.data"
                                    :key="PasswordGenerator.generate()"
                                >
                                    <td>
                                        <input type="checkbox"
                                               class="checkbox_animated"
                                               v-model="form.selection.data_ids"
                                               :value="invoice.id"
                                        />
                                    </td>
                                    <td>
                                        <router-link :to="'invoices/'+invoice.id">
                                            {{ invoice.invoice_no }}
                                        </router-link>
                                        <a href="#"
                                           class="m-l-10 btn btn-xs btn-primary"
                                           @click.prevent="downloadInvoice(invoice.id, invoice.invoice_no+'.pdf')"
                                        ><i class="fa fa-file"></i></a>
                                    </td>
                                    <td>
                                        <router-link :to="'customers/'+invoice.user_id" v-if="invoice.user_id">
                                            {{ invoice.user_name }}
                                        </router-link>
                                        <span v-else>{{ invoice.user_name }}</span>
                                    </td>
                                    <td>{{ invoice.invoice_date }}</td>
                                    <td><span v-html="HelperUtils.getCurrency(invoice.total)"></span></td>
                                    <td>
                                        <StatusBadge :is_active="invoice.is_paid"
                                                     :active_text="$t('Yes')"
                                                     :inactive_text="$t('No')"
                                        ></StatusBadge>
                                    </td>
                                    <td>
                                        <StatusBadge :is_active="invoice.is_cancelled"
                                                     :active_text="$t('Yes')"
                                                     :inactive_text="$t('No')"
                                        ></StatusBadge>
                                    </td>
                                    <td>
                                        <div class="dropdown">
                                            <i class="fa fa-bars h-cursor dropdown-c-link"
                                               @click.prevent="openInvoiceOption(invoice.id)"
                                            ></i>
                                            <Transition>
                                                <div class="dropdown-menu vs-filter-dropdown-menu dropdown-menu-right dropdown-toggle-manager"
                                                     :class="{ show: (selectedInvoiceId == invoice.id) }"
                                                     v-on-click-outside="closeInvoiceOption"
                                                >
                                                    <div class="vs-d-list">
                                                        <template v-if="invoice.is_paid">
                                                            <a href="#"
                                                               class="vs-d-item"
                                                               @click.prevent="setInvoiceAsUnPaid(invoice.id)"
                                                            ><i class="fa fa-times"></i> {{ $t('Mark as Unpaid') }}</a>
                                                        </template>
                                                        <template v-else>
                                                            <a href="#"
                                                               class="vs-d-item"
                                                               @click.prevent="setInvoiceAsPaid(invoice.id)"
                                                            ><i class="fa fa-check"></i> {{ $t('Mark as Paid') }}</a>
                                                        </template>

                                                        <template v-if="!invoice.is_paid">
                                                            <template v-if="!invoice.payment_reminder">
                                                                <a href="#"
                                                                   class="vs-d-item"
                                                                   @click.prevent="createPaymentReminder(invoice.id)"
                                                                >
                                                                    <i class="fa fa-file"></i>
                                                                    {{ $t('Create Payment Reminder') }}
                                                                </a>
                                                            </template>
                                                            <template v-else>
                                                                <a href="#"
                                                                   class="vs-d-item"
                                                                   @click.prevent="downloadPaymentReminder(invoice.id, invoice.invoice_no)"
                                                                >
                                                                    <i class="fa fa-download"></i>
                                                                    {{ $t('Download Payment Reminder') }}
                                                                </a>
                                                                <a href="#"
                                                                   class="vs-d-item"
                                                                   @click.prevent="sendPaymentReminder(invoice.id)"
                                                                >
                                                                    <i class="fa fa-send"></i>
                                                                    {{ $t('Send Payment Reminder') }}
                                                                </a>
                                                            </template>


                                                            <template v-if="!invoice.payment_warning">
                                                                <a href="#"
                                                                   class="vs-d-item"
                                                                   @click.prevent="createPaymentWarning(invoice.id)"
                                                                >
                                                                    <i class="fa fa-file"></i>
                                                                    {{ $t('Create Payment Warning') }}
                                                                </a>
                                                            </template>
                                                            <template v-else>
                                                                <a href="#"
                                                                   class="vs-d-item"
                                                                   @click.prevent="downloadPaymentWarning(invoice.id, invoice.invoice_no)"
                                                                >
                                                                    <i class="fa fa-download"></i>
                                                                    {{ $t('Download Payment Warning') }}
                                                                </a>
                                                                <a href="#"
                                                                   class="vs-d-item"
                                                                   @click.prevent="sendPaymentWarning(invoice.id)"
                                                                >
                                                                    <i class="fa fa-send"></i>
                                                                    {{ $t('Send Payment Warning') }}
                                                                </a>
                                                            </template>

                                                        </template>

                                                        <template v-if="!invoice.is_cancelled">
                                                            <a href="#"
                                                               class="vs-d-item"
                                                               @click.prevent="cancelInvoice(invoice.id)"
                                                            >
                                                                <i class="fa fa-file"></i>
                                                                {{ $t('Cancel Invoice') }}
                                                            </a>
                                                        </template>
                                                        <template v-else>
                                                            <a href="#"
                                                               class="vs-d-item"
                                                               @click.prevent="downloadCancelledInvoice(invoice.id, invoice.invoice_no)"
                                                            >
                                                                <i class="fa fa-download"></i>
                                                                {{ $t('Download Cancelled Invoice') }}
                                                            </a>
                                                            <a href="#"
                                                               class="vs-d-item"
                                                               @click.prevent="sendCancelledInvoice(invoice.id)"
                                                            >
                                                                <i class="fa fa-send"></i>
                                                                {{ $t('Send Cancelled Invoice') }}
                                                            </a>
                                                        </template>

                                                        <a href="#"
                                                           class="vs-d-item"
                                                           @click.prevent="deleteInvoice(invoice.id, invoice.invoice_no)"
                                                        >
                                                            <i class="fa fa-trash"></i>
                                                            {{ $t('Delete Invoice') }}
                                                        </a>
                                                    </div>
                                                </div>
                                            </Transition>
                                        </div>

                                    </td>
                                </tr>
                            </template>
                            <template v-else>
                                <tr>
                                    <td colspan="8">
                                        <div class="alert alert-danger alert-t-box">
                                            {{ $t('No Invoices found') }}
                                        </div>
                                    </td>
                                </tr>
                            </template>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="m-4">
                    <PaginationBar
                        :data="invoices"
                        @change="getInvoicesList"
                    ></PaginationBar>
                </div>

            </div>
        </div>
    </div>
</template>
<script setup>
import {onMounted, ref, shallowRef} from "vue";
import axios from '@/libraries/utils/clientapi/axios';
import PaginationBar from "@/components/widgets/form/PaginationBar"
import breadcrumbConfig from "@/storage/data/breadcrumbs";
import Sorting from '@/components/common/Sorting';
import route from '@/libraries/utils/ZiggyRoute';
import Notifier from "@/libraries/utils/Notifier";
import StatusBadge from "@/components/widgets/form/StatusBadge";
import PaginationSetting from "@/storage/data/paginationSetting";
import __has from 'lodash/has';
import InvoiceNoFilter from "@/components/admin/Invoice/Filters/InvoiceNoFilter";
import InvoiceDatesFilter from "@/components/admin/Invoice/Filters/InvoiceDatesFilter";
import CustomerNameFilter from "@/components/admin/Invoice/Filters/CustomerNameFilter";
import HasPaidFilter from "@/components/admin/Invoice/Filters/HasPaidFilter";
import HasCancelledFilter from "@/components/admin/Invoice/Filters/HasCancelledFilter";
import __Has from "lodash/has";
import HelperUtils from "@/libraries/utils/helpers/HelperUtils";
import { vOnClickOutside } from '@vueuse/components'
import {useRouter} from "vue-router";
import {useI18n} from "vue-i18n";
import PasswordGenerator from "@/libraries/utils/helpers/PasswordGenerator";
import {useMeta} from "vue-meta";


const router = useRouter();
const {t: $t} = useI18n();
useMeta({title: $t('Invoice List')});

const CustomerNameFilterComponent = shallowRef(CustomerNameFilter);
const InvoiceNoFilterComponent = shallowRef(InvoiceNoFilter);
const InvoiceDatesFilterComponent = shallowRef(InvoiceDatesFilter);
const HasPaidFilterComponent = shallowRef(HasPaidFilter);
const HasCancelledFilterComponent = shallowRef(HasCancelledFilter);
let selectedInvoiceId = ref(0);

const form = ref({
    page: 1,
    per_page: PaginationSetting.per_page,
    selection: {
        all: false,
        data_ids: [],
        action: '',
    },
    filters: {
        invoice_no: '',
        user_name: '',
        invoice_date_from: '',
        invoice_date_to: '',
        is_paid: '',
    },
    columns: [
        {
            name: 'Invoice No',
            key: 'invoices.invoice_no',
            sort: 'none',
            component: InvoiceNoFilterComponent
        },
        {
            name: 'Customer',
            key: 'invoices.user_name',
            sort: 'none',
            component: CustomerNameFilterComponent
        },
        {
            name: 'Date',
            key: 'invoices.invoice_date',
            sort: 'none',
            component: InvoiceDatesFilterComponent
        },
        {
            name: 'Price',
            key: 'invoices.grand_total_price',
            sort: 'none',
        },
        {
            name: 'Has Paid',
            key: 'invoices.is_paid',
            sort: 'none',
            component: HasPaidFilterComponent
        },
        {
            name: 'Is Cancelled',
            key: 'invoices.is_cancelled',
            sort: 'none',
            component: HasCancelledFilterComponent
        }
    ]
});


const invoices = ref({});

const getInvoicesList = async (page = 1, per_page = 0) => {

    setPageNumber(page, per_page);

    await axios.get(route('admin.invoices.list'), form.value, {}, true).then(response => {
        invoices.value = response.data.data;
    });
}

function hasInvoices() {
    return __has(invoices.value, 'data') ? (invoices.value.data.length > 0) : invoices.value;
}

function goToEdit(adminId) {
    return router.push('invoices/' + adminId);
}

function openInvoiceOption(invoiceId) {
    if (selectedInvoiceId.value === invoiceId) {
        selectedInvoiceId.value = 0;
        return;
    }
    selectedInvoiceId.value = invoiceId;
}

const closeInvoiceOption = [
    (ev) => {
        if (ev.target.className.includes('dropdown-c-link')) {
            return;
        }
        selectedInvoiceId.value = 0;
    },
    { ignore: [] }
]

function downloadInvoice(invoiceId, invoiceName)
{
    axios.postDownload(route('admin.invoices.download_invoice'), {
        invoice_id: invoiceId
    })
        .then((response) => {
            if (response.status === 200) {
                HelperUtils.blobFileDownload(response, invoiceName);
            }
        });
}

function setInvoiceAsPaid(invoiceId) {
    axios.post(route('admin.invoices.set_paid'), {invoice_id: invoiceId}, {}, 1)
        .then((response) => {
            Notifier.toastSuccess(response.data.message);
            getInvoicesList();
        });
}

function setInvoiceAsUnPaid(invoiceId) {
    axios.post(route('admin.invoices.set_unpaid'), {invoice_id: invoiceId})
        .then((response) => {
            Notifier.toastSuccess(response.data.message);
            getInvoicesList();
        });
}

function createPaymentReminder(invoiceId) {
    axios.post(route('admin.invoices.create_payment_reminder'), {invoice_id: invoiceId})
        .then((response) => {
            Notifier.toastSuccess(response.data.message);
            getInvoicesList();
        });
}

function downloadPaymentReminder(invoiceId, invoiceNo)
{
    axios.postDownload(route('admin.invoices.download_payment_reminder'), {
        invoice_id: invoiceId
    })
        .then((response) => {
            if (response.status === 200) {
                HelperUtils.blobFileDownload(response, 'zahlungserinnerung_'+invoiceNo+'.pdf');
            }
        });
}

function sendPaymentReminder(invoiceId) {
    axios.post(route('admin.invoices.send_payment_reminder'), {invoice_id: invoiceId})
        .then((response) => {
            if (response.status === 200) {
                response.data.data ? Notifier.toastSuccess(response.data.message) : Notifier.toastError(response.data.message);
            }
        });
}


function createPaymentWarning(invoiceId) {
    axios.post(route('admin.invoices.create_payment_warning'), {invoice_id: invoiceId})
        .then((response) => {
            Notifier.toastSuccess(response.data.message);
            getInvoicesList();
        });
}

function downloadPaymentWarning(invoiceId, invoiceNo)
{
    axios.postDownload(route('admin.invoices.download_payment_warning'), {
        invoice_id: invoiceId
    })
        .then((response) => {
            if (response.status === 200) {
                HelperUtils.blobFileDownload(response, 'mahnung_'+invoiceNo+'.pdf');
            }
        });
}

function sendPaymentWarning(invoiceId) {
    axios.post(route('admin.invoices.send_payment_warning'), {invoice_id: invoiceId})
        .then((response) => {
            if (response.status === 200) {
                response.data.data ? Notifier.toastSuccess(response.data.message) : Notifier.toastError(response.data.message);
            }
        });
}

function cancelInvoice(invoiceId) {
    axios.post(route('admin.invoices.cancel_invoice'), {invoice_id: invoiceId})
        .then((response) => {
            if (response.status === 200) {
                Notifier.toastSuccess(response.data.message);
                getInvoicesList();
            }
        });
}

function downloadCancelledInvoice(invoiceId, invoiceNo)
{
    axios.postDownload(route('admin.invoices.download_cancelled_invoice'), {
        invoice_id: invoiceId
    })
        .then((response) => {
            if (response.status === 200) {
                HelperUtils.blobFileDownload(response, 'stornorechnung_'+invoiceNo+'.pdf');
            }
        });
}

function sendCancelledInvoice(invoiceId) {
    axios.post(route('admin.invoices.send_cancelled_invoice'), {invoice_id: invoiceId})
        .then((response) => {
            if (response.status === 200) {
                response.data.data ? Notifier.toastSuccess(response.data.message) : Notifier.toastError(response.data.message);
            }
        });
}


function deleteInvoice(invoiceId, invoiceNo) {
    Notifier.toastConfirm($t('Delete Invoice'), $t('Do you want to delete this invoice #{invoice_no}?', {invoice_no: invoiceNo}), () => {
        axios.delete(route('admin.invoices.destroy', {id: invoiceId}))
            .then((response) => {
                Notifier.toastSuccess(response.data.message);
                getInvoicesList();
            });
    }, $t('Yes'), $t('No'));
}

function setPageNumber(page, per_page) {
    if (typeof page === 'number') {
        form.value.page = page;
    } else {
        form.value.page = 1;
    }

    if (typeof per_page === 'number' && per_page > 0) {
        form.value.per_page = per_page;
    }
}

function updateFilters(filters) {

    let hasFilter = false;

    for (let filterName in filters) {
        if (__Has(filters, filterName)) {
            form.value.filters[filterName] = filters[filterName];
            hasFilter = true;
        }
    }

    if (hasFilter) {
        getInvoicesList();
    }
}

function isDataSelected() {
    return form.value.selection.data_ids.length > 0;
}

function selectAll() {
    if (form.value.selection.all) {
        form.value.selection.data_ids = invoices.value.data.map(data => data.id)
    } else {
        form.value.selection.data_ids = [];
    }
}

function submitBulkAction() {
    Notifier.toastConfirm($t('Do you want to perform bulk action?'), '', () => {
        axios.post(route('admin.invoices.bulk_action'), {
            data_ids: form.value.selection.data_ids,
            action: form.value.selection.action,
        }).then((response) => {
            if (response.status === 200) {
                form.value.selection = {action: '', data_ids: [], all: false};
                getInvoicesList();
                Notifier.toastSuccess(response.data.message);
            }
        });
    });
}

onMounted(async () => {
    await getInvoicesList();
})

</script>