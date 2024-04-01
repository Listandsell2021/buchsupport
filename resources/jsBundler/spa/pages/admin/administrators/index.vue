<template>
    <div>

        <Breadcrumbs :menu-items="breadcrumbConfig.admin.list()" :title="$t('Administrator List')"/>

        <div class="container-fluid">

            <div class="clearfix mb-3">
                <div class="pull-left" v-if="isDataSelected()">
                    <div class="btn-group">
                        <select class="form-control"
                                style="width: 200px;"
                                v-model="form.selection.action"
                        >
                            <option value="">{{ $t('Action') }}</option>
                            <option value="active">{{ $t('Active') }}</option>
                            <option value="inactive">{{ $t('Inactive') }}</option>
                            <option value="delete">{{ $t('Delete') }}</option>
                        </select>
                        <button class="btn btn-secondary"
                                @click.prevent="submitBulkAction()"
                        >{{ $t('Submit') }}</button>
                    </div>
                </div>
                <router-link to="administrators/create" class="btn btn-primary pull-right">
                    <i class="fa fa-plus"></i> {{ $t('Create New') }}
                </router-link>
            </div>

            <div class="card">
                <div class="card-body">

                    <div class="">
                        <table class="table">
                            <thead>
                            <Sorting :columns="form.columns"
                                     @column_changed="getAdminList"
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
                            <template v-if="hasAdmins()">
                                <tr v-for="(admin, index) in admins.data"
                                    :key="PasswordGenerator.generate()"
                                >
                                    <td>
                                        <input type="checkbox"
                                               class="checkbox_animated"
                                               v-model="form.selection.data_ids"
                                               :value="admin.id"
                                        />
                                    </td>
                                    <td>
                                        <a href="#" @click.prevent="goToEditAdmin(admin.id)">
                                            {{ admin.first_name }} {{ admin.last_name }}
                                        </a>
                                    </td>
                                    <td>{{ HelperUtils.truncate(admin.email, 25, '..') }}</td>
                                    <td>{{ admin.city }}</td>
                                    <td>{{ admin.auth_role == 'admin' ? admin.role_name : $t(admin.auth_role) }}</td>
                                    <td class="switcher-col">
                                        <StatusSwitcher :is_active="admin.is_active"
                                                        @toggle="changeActiveStatus(admin.id, $event)"
                                        ></StatusSwitcher>
                                    </td>
                                    <td>
                                        <button class="btn btn-success btn-xs"
                                                @click="goToEditAdmin(admin.id)"
                                                v-tooltip="$t('Edit Admin')"
                                        >
                                            <i class="fa fa-edit"></i>
                                        </button>
                                        <button class="btn btn-danger btn-xs ms-1"
                                                @click.prevent="deleteAdmin(admin.id, admin.first_name+' '+admin.last_name)"
                                                v-tooltip="$t('Delete Admin')"
                                        >
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                            <template v-else>
                                <tr>
                                    <td colspan="9">
                                        <div class="alert alert-danger alert-t-box">
                                            {{ $t('No Administrators found') }}
                                        </div>
                                    </td>
                                </tr>
                            </template>
                            </tbody>
                        </table>
                    </div>

                    <div class="mt-4">
                        <PaginationBar
                                :data="admins"
                                @change="getAdminList"
                        ></PaginationBar>
                    </div>

                </div>


            </div>

        </div>
    </div>
</template>
<script setup>
import {onMounted, ref, shallowRef} from "vue";
import axios from '@/libraries/utils/clientapi/axios';
import Breadcrumbs from "@/components/Breadcrumbs.vue";
import PaginationBar from "@/components/widgets/form/PaginationBar";
import breadcrumbConfig from "@/storage/data/breadcrumbs";
import Sorting from '@/components/common/Sorting';
import route from '@/libraries/utils/ZiggyRoute';
import Notifier from "@/libraries/utils/Notifier";
import HelperUtils from "@/libraries/utils/helpers/HelperUtils";
import StatusSwitcher from "@/components/widgets/form/StatusSwitcher";
import __has from 'lodash/has';
import PaginationSetting from "@/storage/data/paginationSetting";
import NameFilter from "@/components/admin/Administrator/Filters/NameFilter";
import EmailFilter from "@/components/admin/Administrator/Filters/EmailFilter";
import CityFilter from "@/components/admin/Administrator/Filters/CityFilter";
import IsActiveFilter from "@/components/admin/Administrator/Filters/IsActiveFilter";
import AdminRoleFilter from "@/components/admin/Administrator/Filters/AdminRoleFilter";
import AuthRoleFilter from "@/components/admin/Administrator/Filters/AuthRoleFilter";
import __Has from "lodash/has";
import {useRouter} from "vue-router";
import {useI18n} from "vue-i18n";
import PasswordGenerator from "@/libraries/utils/helpers/PasswordGenerator";
import {useMeta} from "vue-meta";


const router = useRouter();
const {t: $t} = useI18n()
useMeta({title: $t('Administrator List')});

const NameFilterComponent = shallowRef(NameFilter);
const EmailFilterComponent = shallowRef(EmailFilter);
//const GenderFilterComponent = shallowRef(GenderFilter);
const CityFilterComponent = shallowRef(CityFilter);
const IsActiveFilterComponent = shallowRef(IsActiveFilter);
const AdminRoleFilterComponent = shallowRef(AdminRoleFilter);
const AuthRoleFilterComponent = shallowRef(AuthRoleFilter);

const form = ref({
    page: 1,
    per_page: PaginationSetting.per_page,
    selection: {
        all: false,
        data_ids: [],
        action: '',
    },
    filters: {
        name: '',
        email: '',
        gender: '',
        city: '',
        role_id: '',
        is_active: '',
    },
    columns: [
        {
            name: 'Name',
            key: 'admins.first_name',
            sort: 'none',
            component: NameFilterComponent
        },
        {
            name: 'Email',
            key: 'admins.email',
            sort: 'none',
            component: EmailFilterComponent
        },
        /*{
            name: 'Gender',
            key: 'admins.gender',
            sort: 'none',
            component: GenderFilterComponent
        },*/
        {
            name: 'City',
            key: 'admins.city',
            sort: 'none',
            component: CityFilterComponent
        },
        {
            name: 'Role',
            key: 'admins.auth_role',
            sort: 'none',
            component: AuthRoleFilterComponent
        },
        {
            name: 'Status',
            key: 'admins.is_active',
            sort: 'none',
            component: IsActiveFilterComponent
        }
    ]
});

const admins = ref({});

const getAdminList = async (page = 1, per_page = 0) => {

    setPageNumber(page, per_page);

    await axios.get(route('admin.admins.index'), form.value, {}, true).then(async (response) => {
        admins.value = response.data.data;
    });
}


let debounceController = null;

const filterAdminList = () => {
    clearTimeout(debounceController);
    debounceController = setTimeout(() => {
        getAdminList();
    }, 500);
}

function goToEditAdmin(adminId) {
    return router.push({name: 'administrator_edit', params: {id: adminId}});
}

function deleteAdmin(adminId, adminName) {
    Notifier.toastConfirm($t('Delete Admin'), $t('Do you want to delete "{name}"?', {name: adminName}), () => {
        axios.delete(route('admin.admins.destroy', {id: adminId}))
            .then((response) => {
                if (response.status === 200) {
                    Notifier.toastSuccess(response.data.message);
                }
                getAdminList();
            });
    });
}

function changeActiveStatus(adminId, isActive) {
    axios.post(route('admin.admins.change_status'), {
        admin_id: adminId,
        is_active: isActive,
    }).then((response) => {
        if (response.status === 200) {
            Notifier.toastSuccess(response.data.message);
            getAdminList();
        }
    });
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
        getAdminList();
    }
}

function hasAdmins() {
    return __has(admins.value, 'data') ? (admins.value.data.length > 0) : admins.value;
}

function isDataSelected() {
    return form.value.selection.data_ids.length > 0;
}

function selectAll() {
    if (form.value.selection.all) {
        form.value.selection.data_ids = admins.value.data.map(data => data.id)
    } else {
        form.value.selection.data_ids = [];
    }
}

function submitBulkAction() {
    Notifier.toastConfirm($t('Do you want to perform bulk action?'), '', () => {
        axios.post(route('admin.admins.bulk_action'), {
            data_ids: form.value.selection.data_ids,
            action: form.value.selection.action,
        }).then((response) => {
            if (response.status === 200) {
                form.value.selection = {action: '', data_ids: [], all: false};
                getAdminList();
                Notifier.toastSuccess(response.data.message);
            }
        });
    });
}

onMounted(async () => {
    await getAdminList();
})

</script>