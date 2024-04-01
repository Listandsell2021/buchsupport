<template>
    <div>
        <Transition>
            <SmartLeadList v-if="showSmartListModal"
                           @close="closeSmartLeads"
                           @show-all="clearAndFetchAllLeads"
                           @show-smart-list="clearAndOpenSmartListLeads"
            ></SmartLeadList>
        </Transition>

        <Transition>
            <GoogleMapModal v-if="googleMapModal"
                           @close="closeGoogleMap"
                            :form="form"
            ></GoogleMapModal>
        </Transition>

        <Transition>
            <AddSmartListModal v-if="addSmartListModal"
                               @close="closeAddSmartListModal"
                               :filters="form.filters"
            ></AddSmartListModal>
        </Transition>

        <Transition>
            <EditBulkLeadSalespersonModal v-if="updateBulkLeadSalespersonModal"
                               @close="closeUpdateBulkLeadSalespersonModal"
                               :filters="form.filters"
            ></EditBulkLeadSalespersonModal>
        </Transition>

        <Transition>
            <EditBulkLeadStatusModal v-if="updateBulkLeadStatusModal"
                                     @close="closeUpdateBulkLeadStatusModal"
                                     :filters="form.filters"
            ></EditBulkLeadStatusModal>
        </Transition>

        <Transition>
            <AddLeadModal v-if="addLeadModal"
                          @close="closeAddLeadModal"
                          @refresh="getLeadList"
            ></AddLeadModal>
        </Transition>

        <Transition>
            <LeadStatusModal v-if="viewLeadStatus"
                             @close="closeLeadStatusModal"
                             @refresh="getLeadList"
            ></LeadStatusModal>
        </Transition>

        <div>
            <div class="page-title">
                <div class="row">
                    <div class="col-2 d-flex">
                        <a href="#" @click.prevent="openSmartLeads" class="smart-lead-o">
                            <i class="fa fa-align-justify"></i>
                        </a>
                        <h3>{{ $t('Leads') }}</h3>
                    </div>
                    <div class="col-10">
                        <div class="clearfix">

                            <div class="dropdown pull-right">
                                <button class="btn btn-xs btn-primary pull-right m-r-15"
                                        @click.prevent="openColumnFilter"
                                >
                                    <i class="fa fa-list"></i> {{ $t('Columns') }}
                                    <i class="fa fa-angle-down"></i>
                                </button>
                                <div class="dropdown-menu column-manager-dropdown dropdown-menu-right d-block" v-on-click-outside="closeColumnFilter" v-if="tableColumnFilter == true">
                                    <ul class="column-manager-list">
                                        <li class="column-manager-item" v-for="filter in form.columns">
                                            <label>
                                                <input type="checkbox" class="checkbox_animated ch-small" v-model="filter.show"/>
                                                {{ $t(filter.name) }}
                                            </label>
                                        </li>
                                    </ul>
                                    <button class="btn btn-primary btn-block btn-sm btn-save-preference"
                                            @click.prevent="saveLeadTablePreference"
                                    >{{ $t('Save Preference') }}</button>
                                </div>
                            </div>

                            <a href="#"
                               class="btn btn-xs btn-primary pull-right m-r-15"
                               @click.prevent="openGoogleMap"
                            >
                                <i class="fa fa-map-marker"></i> {{ $t('View on Map') }}
                            </a>

                            <a href="#"
                               @click.prevent="openAddLeadModal"
                               class="btn btn-xs btn-primary pull-right m-r-15"
                            >
                                <i class="fa fa-plus"></i> {{ $t('Create New') }}
                            </a>

                            <ImportLeads classes="btn btn-xs btn-primary pull-right m-r-15" @imported="getLeadList"></ImportLeads>

                            <a href="#"
                               @click.prevent="openLeadStatusModal"
                               class="btn btn-xs btn-primary pull-right m-r-15"
                            >
                                <i class="fa fa-list"></i> {{ $t('Lead Status') }}
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-4">
                    <span class="btn btn-xs btn-primary m-b-20" @click.prevent="selectAll">
                       {{ form.filters.select_all ? $t('Unselect All') : $t('Select All') }}
                    </span>
                </div>
                <div class="col-md-8">
                    <template v-if="isAnyLeadSelected()">
                        <div class="clearfix">
                            <a href="#"
                               @click.prevent="openAddSmartListModal"
                               class="badge bg-secondary m-r-15 pull-right"
                            >
                                <i class="fa fa-plus"></i> {{ $t('Add Smart Leads') }}
                            </a>
                            <a href="#" class="badge bg-secondary m-r-15 pull-right"
                               @click.prevent="openUpdateBulkLeadSalespersonModal"
                            ><i class="fa fa-edit"></i> {{ $t('Update Salesperson') }}</a>

                            <a href="#" class="badge bg-secondary m-r-15 pull-right"
                               @click.prevent="openUpdateBulkLeadStatusModal"
                            ><i class="fa fa-edit"></i> {{ $t('Update Status') }}</a>
                        </div>
                    </template>

                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-alt">
                            <thead>
                            <Sorting :columns="form.columns"
                                     :filters="form.filters"
                                     @column_changed="getLeadList"
                                     @filter="updateFilters"
                                     classes="vs-sorting-custom"
                            >
                                <template v-slot:sorting_top>
                                    <th class="col-select-all">
                                        <input type="checkbox"
                                               class="checkbox_animated"
                                               v-model="form.filters.select_current"
                                               @change="selectCurrent"
                                        />
                                    </th>
                                </template>
                                <template v-slot:sorting_bottom>
                                    <th class="fixed-t-right">{{ $t('Action') }}</th>
                                </template>
                            </Sorting>
                            </thead>
                            <tbody>
                            <tr v-for="lead in leads.data" :key="lead.id">
                                <td>
                                    <input type="checkbox"
                                           class="checkbox_animated"
                                           :value="lead.id"
                                           :checked="isLeadChecked(lead.id)"
                                            v-model="form.filters.lead_ids"
                                           :id="'checkbox_' + lead.id"
                                    />
                                </td>
                                <td v-if="form.columns.lead_name.show">
                                    <a href="#" @click.prevent="goToEditLead(lead.id)">
                                        {{ lead.first_name }} {{ lead.last_name }}
                                    </a>
                                </td>
                                <td v-if="form.columns.lead_salesperson.show">{{ lead.salesperson }}</td>
                                <td v-if="form.columns.lead_email.show">{{ lead.email }}</td>
                                <td v-if="form.columns.lead_gender.show">{{ $t(lead.gender) }}</td>
                                <td v-if="form.columns.lead_phone_no.show">{{ lead.phone_no }}</td>
                                <td v-if="form.columns.lead_country.show">{{ lead.country }}</td>
                                <td v-if="form.columns.lead_city.show">{{ lead.city }}</td>
                                <td v-if="form.columns.lead_street.show">{{ HelperUtils.truncate(lead.street, 25)}}</td>
                                <td v-if="form.columns.lead_postal_code.show">{{ lead.postal_code }}</td>
                                <td v-if="form.columns.lead_status.show">
                                    <template v-if="lead.lead_status_id">{{ lead.lead_status_name }}</template>
                                    <button v-if="lead.has_conversion_request && !lead.is_converted"
                                            class="btn btn-primary btn-xs"
                                            @click.prevent="convertToCustomer(lead.id)"
                                    >
                                        {{ $t('Add to New Customer') }}
                                    </button>
                                    <div v-if="lead.is_converted">
                                        <button class="btn btn-success btn-xs">{{ $t('Converted') }}</button>
                                    </div>
                                </td>
                                <td>
                                    <button class="btn btn-success btn-xs"
                                            @click="goToEditLead(lead.id)"
                                            v-tooltip="$t('Edit Lead')"
                                    >
                                        <i class="fa fa-edit"></i>
                                    </button>

                                    <button class="btn btn-danger btn-xs ms-1"
                                            @click.prevent="deleteLead(lead.id, lead.first_name+' '+lead.last_name)"
                                            v-tooltip="$t('Delete Lead')"
                                    >
                                        <i class="fa fa-trash"></i>
                                    </button>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                </div>

                <div class="m-4">
                    <PaginationBar
                        :data="leads"
                        @change="getLeadList"
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
import Sorting from '@/components/common/Sorting';
import route from '@/libraries/utils/ZiggyRoute';
import Notifier from "@/libraries/utils/Notifier";
import BtModalHelper from "@/libraries/utils/BtModalHelper";
import AddLeadModal from "@/components/admin/Lead/AddLeadModal";
import LeadStatusModal from "@/components/admin/Lead/LeadStatusModal";
import SmartLeadList from "@/components/admin/Lead/SmartLeadList";
import ImportLeads from "@/components/admin/Lead/ImportLeads";
import __has from 'lodash/has';
import PaginationSetting from "@/storage/data/paginationSetting";
import AddSmartListModal from "@/components/admin/Lead/AddSmartListModal";
import LeadsFilter from "@/components/admin/Lead/Filters/LeadsFilter";
import CountryFilter from "@/components/admin/Lead/Filters/CountryFilter";
import CityFilter from "@/components/admin/Lead/Filters/CityFilter";
import PostCodeFilter from "@/components/admin/Lead/Filters/PostalCodeFilter";
import StatusFilter from "@/components/admin/Lead/Filters/StatusFilter";
import GoogleMapModal from "@/components/admin/Lead/GoogleMapModal";
import { useGeoLocationStore } from '@/storage/store/geolocation';
import { useLoadingStore } from '@/storage/store/loading';
import HelperUtils from "@/libraries/utils/helpers/HelperUtils";
import { vOnClickOutside } from '@vueuse/components';
import __Has from 'lodash/has';
import {useI18n} from "vue-i18n";
import {useRouter} from "vue-router";
import {useMeta} from "vue-meta";
import EditBulkLeadSalespersonModal from "@/components/admin/Lead/Filters/EditBulkLeadSalespersonModal.vue";
import EditBulkLeadStatusModal from "@/components/admin/Lead/Filters/EditBulkLeadStatusModal.vue";
import {useAuthStore} from "@/storage/store/auth";
import SalespersonFilter from "@/components/admin/Lead/Filters/SalespersonFilter.vue";
import EmailFilter from "@/components/admin/Lead/Filters/EmailFilter.vue";
import PhoneFilter from "@/components/admin/Lead/Filters/PhoneFilter.vue";
import GenderFilter from "@/components/admin/Lead/Filters/GenderFilter.vue";
import StreetFilter from "@/components/admin/Lead/Filters/StreetFilter.vue";

const router = useRouter();
const { t: $t } = useI18n();
useMeta({title: $t('Lead List')});

const LeadFilterComponent = shallowRef(LeadsFilter);
const CountryFilterComponent = shallowRef(CountryFilter);
const CityFilterComponent = shallowRef(CityFilter);
const PostalCodeFilterComponent = shallowRef(PostCodeFilter);
const StatusFilterComponent = shallowRef(StatusFilter);
const SalespersonFilterComponent = shallowRef(SalespersonFilter);
const EmailFilterComponent = shallowRef(EmailFilter);
const PhoneFilterComponent = shallowRef(PhoneFilter);
const GenderFilterComponent = shallowRef(GenderFilter);
const StreetFilterComponent = shallowRef(StreetFilter);
const loader = useLoadingStore();

const defaultFormValue = () => {

    let userTableColumn = getAuthTableColumns();

    return {
        page: 1,
        per_page: PaginationSetting.per_page,
        filters: {
            name: '',
            country: '',
            street: '',
            city: '',
            email: '',
            gender: '',
            phone_no: '',
            postal_code_start: '',
            postal_code_end: '',
            lead_status_id: '',
            smart_list_id: '',
            lead_ids: [],
            salesperson_ids: [],
            select_current : false,
            select_all: 0,
        },
        columns: {
            lead_name : {
                name: 'Name',
                key: 'leads.first_name',
                sort: 'none',
                component: LeadFilterComponent,
                show: userTableColumn ? userTableColumn.includes('lead_name') : true,
            },
            lead_salesperson : {
                name: 'Salesperson',
                key: 'salesperson',
                sort: 'none',
                component: SalespersonFilterComponent,
                show: userTableColumn ? userTableColumn.includes('lead_salesperson') : true,
            },
            lead_email : {
                name: 'Email',
                key: 'leads.email',
                sort: 'none',
                component: EmailFilterComponent,
                show: userTableColumn ? userTableColumn.includes('lead_email') : true,
            },
            lead_gender : {
                name: 'Gender',
                key: 'leads.gender',
                sort: 'none',
                component: GenderFilterComponent,
                show: userTableColumn ? userTableColumn.includes('lead_gender') : true,
            },
            lead_phone_no : {
                name: 'Phone no',
                key: 'leads.phone_no',
                sort: 'none',
                component: PhoneFilterComponent,
                show: userTableColumn ? userTableColumn.includes('lead_phone_no') : true,
            },
            lead_country : {
                name: 'Country',
                key: 'leads.country',
                sort: 'none',
                component: CountryFilterComponent,
                show: userTableColumn ? userTableColumn.includes('lead_country') : true,
            },
            lead_city : {
                name: 'City',
                key: 'leads.city',
                sort: 'none',
                component: CityFilterComponent,
                show: userTableColumn ? userTableColumn.includes('lead_city') : true,
            },
            lead_street : {
                name: 'Street',
                key: 'leads.street',
                sort: 'none',
                component: StreetFilterComponent,
                show: userTableColumn ? userTableColumn.includes('lead_street') : true,
            },
            lead_postal_code : {
                name: 'Postal Code',
                key: 'leads.postal_code',
                sort: 'none',
                component: PostalCodeFilterComponent,
                show: userTableColumn ? userTableColumn.includes('lead_postal_code') : true,
            },
            lead_status : {
                name: 'Status',
                key: 'leads.lead_status_id',
                sort: 'none',
                component: StatusFilterComponent,
                show: userTableColumn ? userTableColumn.includes('lead_status') : true,
            }
        }
    };
}

let form = ref(defaultFormValue());
const leads = ref({});
let addLeadModal = ref(false);
let showSmartListModal = ref(false);
let addSmartListModal = ref(false);
let updateBulkLeadSalespersonModal = ref(false);
let updateBulkLeadStatusModal = ref(false);
let viewLeadStatus = ref(false);
let googleMapModal = ref(false);
let tableColumnFilter = ref(false);
let debounceController = null;

const getLeadList = async (page = 1, per_page = 0) => {

    unSelectAll();
    setPageNumber(page, per_page);

    await axios.get(route('admin.leads.index'), form.value, {}, true).then(response => {
        leads.value = response.data.data;
    });
}

function hasLeads() {
    return __has(leads.value, 'data') ? (leads.value.data.length > 0) : leads.value;
}

const filterLeadList = () => {
    clearTimeout(debounceController);
    debounceController = setTimeout(() => {
        getLeadList();
    }, 500);
}

function goToEditLead(adminId) {
    return router.push('leads/' + adminId, true);
}

function deleteLead(leadId, leadName) {
    Notifier.toastConfirm($t('Delete Lead'), $t('Do you want to delete "{name}"?', {name: leadName}), () => {
        axios.delete(route('admin.leads.destroy', {id: leadId}), {lead_id: leadId})
            .then((response) => {
                Notifier.toastSuccess(response.data.message);
                getLeadList();
            });
    });
}

function convertToCustomer(leadId) {
    axios.post(route('admin.leads.approve_new_customer'), { lead_id: leadId })
        .then(async (response) => {
            if (response.status === 200) {
                Notifier.toastSuccess(response.data.message);
                await getLeadList();
            }
        });
}

function getAuthTableColumns() {
    return useAuthStore().getLeadTableColumns();
}

function saveLeadTablePreference() {
    axios.post(route('admin.leads.save_table_preference'), {
        columns: getLeadTableActiveColumns()
    })
        .then(async (response) => {
            if (response.status === 200) {
                Notifier.toastSuccess(response.data.message);
                useAuthStore().saveLeadTableColumns(getLeadTableActiveColumns())
            }
        });
}

function getLeadTableActiveColumns() {
    let columns = [];

    for (const column_name in form.value.columns) {
        const column = form.value.columns[column_name];
        if (__has(column, 'show') && column.show == true) {
            columns.push(column_name);
        }
    }

    return columns;
}

function clearAndFetchAllLeads() {
    setFormDefaultValues()
    getLeadList();
    closeSmartLeads();
}


function clearAndOpenSmartListLeads(smartListId) {
    setFormDefaultValues();
    form.value.filters.smart_list_id = smartListId;
    getLeadList();
    closeSmartLeads();
}

function setFormDefaultValues() {
    form = ref(defaultFormValue());
}

function selectCurrent() {
    if (form.value.filters.select_current) {
        form.value.filters.lead_ids = leads.value.data.map(lead => lead.id)
    } else {
        form.value.filters.lead_ids = [];
    }
}

function selectAll() {
    form.value.filters.select_all = +(!form.value.filters.select_all);
}

function unSelectAll() {
    form.value.filters.select_current = false;
    form.value.filters.select_all = 0;
    form.value.filters.lead_ids = [];
}

function isLeadChecked(leadId) {
    return form.value.filters.lead_ids.includes(leadId) || form.value.filters.select_all;
}

function isAnyLeadSelected() {
    return form.value.filters.lead_ids.length > 0 || form.value.filters.select_all;
}

function onLeadSelection(event) {
    const checked = event.target.checked;
    const value = parseInt(event.target.value);
    if (checked) {
        const exists = form.value.filters.lead_ids.includes(value);
        if (!exists) {
            form.value.filters.lead_ids.push(value);
        }
    } else {
        return form.value.filters.lead_ids.filter((leadId) => { return value !== leadId })
    }
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

function openLeadStatusModal() {
    viewLeadStatus.value = true;
    BtModalHelper.open();
}

function closeLeadStatusModal() {
    viewLeadStatus.value = false;
    BtModalHelper.close();
}

function openAddSmartListModal() {
    addSmartListModal.value = true;
    BtModalHelper.open();
}

function closeAddSmartListModal() {
    addSmartListModal.value = false;
    BtModalHelper.close();
}

function openUpdateBulkLeadSalespersonModal() {
    updateBulkLeadSalespersonModal.value = true;
    BtModalHelper.open();
}

function closeUpdateBulkLeadSalespersonModal() {
    updateBulkLeadSalespersonModal.value = false;
    BtModalHelper.close();
    getLeadList();
}


function openUpdateBulkLeadStatusModal() {
    updateBulkLeadStatusModal.value = true;
    BtModalHelper.open();
}

function closeUpdateBulkLeadStatusModal() {
    updateBulkLeadStatusModal.value = false;
    BtModalHelper.close();
    getLeadList();
}


function openAddLeadModal() {
    addLeadModal.value = true;
    BtModalHelper.open();
}

function closeAddLeadModal() {
    addLeadModal.value = false;
    BtModalHelper.close();
}

async function openGoogleMap() {

    loader.setLoading();

    await useGeoLocationStore().refreshLocation(() => {
        loader.removeLoading();
        googleMapModal.value = true;
        BtModalHelper.open();
    });
}

function closeGoogleMap() {
    googleMapModal.value = false;
    BtModalHelper.close();
}

function openColumnFilter() {
    tableColumnFilter.value = true;
}

function closeColumnFilter() {
    tableColumnFilter.value = false;
}

function openSmartLeads() {
    showSmartListModal.value = true;
}

function closeSmartLeads() {
    showSmartListModal.value = false;
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
        getLeadList();
    }

}

onMounted(async () => {
    await getLeadList();
})

</script>