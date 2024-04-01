<template>
    <div>

        <Breadcrumbs :menu-items="breadcrumbConfig.role.list()" :title="$t('Role List')"/>

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
                <router-link to="roles/create" class="btn btn-primary pull-right">
                    <i class="fa fa-plus"></i> {{ $t('Create New') }}
                </router-link>
            </div>

            <div class="card">

                <div class="card-body">
                    <div class="">
                        <table class="table">
                            <thead>
                                <Sorting :columns="form.columns"
                                         @column_changed="getRoleList"
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
                            <template v-if="hasRoles()">
                                <tr v-for="(role, index) in roles.data"
                                    :key="PasswordGenerator.generate()"
                                >
                                    <td>
                                        <input type="checkbox"
                                               class="checkbox_animated"
                                               v-model="form.selection.data_ids"
                                               :value="role.id"
                                        />
                                    </td>
                                    <td>{{ role.name }}</td>
                                    <td>
                                        <StatusBadge :is_active="role.default"
                                                     :active_text="'Yes'"
                                                     :hide_inactive="1"
                                        ></StatusBadge>
                                    </td>
                                    <td class="switcher-col">
                                        <StatusSwitcher :is_active="role.is_active"
                                                        @toggle="changeRoleStatus(role.id, $event)"
                                        ></StatusSwitcher>
                                    </td>
                                    <td>
                                        <button class="btn btn-success btn-xs"
                                                @click="goToEditPage(role.id)"
                                                v-tooltip="$t('Edit Role')"
                                        >
                                            <i class="fa fa-edit"></i>
                                        </button>

                                        <button class="btn btn-danger btn-xs ms-1"
                                                @click.prevent="deleteRole(role.id, role.name)"
                                                v-tooltip="$t('Delete Role')"
                                        >
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            </template>
                            <template v-else>
                                <tr>
                                    <td colspan="4">
                                        <div class="alert alert-danger alert-t-box">
                                            {{ $t('No Roles found') }}
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
                        :data="roles"
                        @change="getRoleList"
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
import StatusSwitcher from "@/components/widgets/form/StatusSwitcher";
import StatusBadge from "@/components/widgets/form/StatusBadge";
import NameFilter from "@/components/admin/Role/Filters/NameFilter";
import IsActiveFilter from "@/components/admin/Role/Filters/IsActiveFilter";
import __Has from "lodash/has";
import __has from "lodash/has";
import {useRouter} from "vue-router";
import {useI18n} from "vue-i18n";
import PasswordGenerator from "@/libraries/utils/helpers/PasswordGenerator";
import {useMeta} from "vue-meta";


const router = useRouter();
const {t: $t} = useI18n();
useMeta({title: $t('Role List')});

const NameFilterComponent = shallowRef(NameFilter);
const IsActiveFilterComponent = shallowRef(IsActiveFilter);

const form = ref({
    page: 1,
    filters: {
        name: '',
        is_active: '',
    },
    selection: {
        all: false,
        data_ids: [],
        action: '',
    },
    columns: [
        {
            name: 'Role',
            key: 'roles.name',
            sort: 'none',
            component: NameFilterComponent,
        },
        {
            name: 'Default',
            key: 'roles.default',
            sort: 'none',
        },
        {
            name: 'Status',
            key: 'roles.is_active',
            sort: 'none',
            component: IsActiveFilterComponent,
        }
    ]
});


const roles = ref({});

const getRoleList = async (page = 1) => {

    setPageNumber(page);

    await axios.get(route('admin.roles.index'), form.value, {}, true).then(response => {
        roles.value = response.data;
    });
}

let debounceController = null;

const filterRoleList = () => {
    clearTimeout(debounceController);
    debounceController = setTimeout(() => {
        getRoleList();
    }, 500);
}

function goToEditPage(adminId) {
    return router.push('roles/'+adminId);
}

function changeRoleStatus(roleId, isActive) {
    axios.post(route('admin.roles.change_status'), {
        role_id: roleId,
        is_active: isActive,
    }).then((response) => {
        if (response.status === 200) {
            Notifier.toastSuccess(response.data.message);
            //getRoleList();
        }
    });
}

function deleteRole(roleId, roleName) {
    Notifier.toastConfirm($t('Delete Role'), $t('Do you want to delete this role "{role}"?', {role: roleName}), () => {
        axios.delete(route('admin.roles.destroy', { id: roleId }), { role_id: roleId})
            .then((response) => {
                if (response.status == 2000) {
                    Notifier.toastSuccess(response.data.message);
                }
                getRoleList();
            });
    }, $t('Yes'), $t('No'));
}

function hasRoles() {
    return __has(roles.value, 'data') ? (roles.value.data.length > 0) : roles.value;
}

function setPageNumber(page) {
    if (typeof page === 'number') {
        form.value.page = page;
    } else {
        form.value.page = 1;
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
        getRoleList();
    }

}

function selectAll() {
    if (form.value.selection.all) {
        form.value.selection.data_ids = roles.value.data.map(data => data.id)
    } else {
        form.value.selection.data_ids = [];
    }
}

function isDataSelected() {
    return form.value.selection.data_ids.length > 0;
}

function submitBulkAction() {
    Notifier.toastConfirm($t('Do you want to perform bulk action?'), '', () => {
        axios.post(route('admin.roles.bulk_action'), {
            data_ids: form.value.selection.data_ids,
            action: form.value.selection.action,
        }).then((response) => {
            if (response.status === 200) {
                form.value.selection = {action: '', data_ids: [], all: false};
                getRoleList();
                Notifier.toastSuccess(response.data.message);
            }
        });
    });
}


onMounted(async () => {
    await getRoleList();
})

</script>