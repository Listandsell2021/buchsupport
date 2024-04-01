<template>
    <div>

        <Breadcrumbs :menu-items="breadcrumbConfig.role.edit(roleId)" :title="$t('Role Edit')"/>

        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <Form @submit="updateRole" v-slot="{errors}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ $t('Name') }}</label>
                                    <Field class="form-control"
                                           v-model="form.name"
                                           type="text"
                                           name="name"
                                           rules="required"
                                           :placeholder="$t('Enter role name')"
                                           :class="{'is-invalid': errors.name}"
                                    />
                                    <ErrorMessage class="text-danger d-block" name="name"/>
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

                        <div class="row">
                            <h4>{{ $t('List of Permissions') }}</h4>
                            <div class="form-group">
                                <div v-for="(permissonName, permissionKey) in permissions">
                                    <label>
                                        <input type="checkbox" v-model="form.permissions" :value="permissionKey">
                                        <span class="m-l-10">{{ $t(permissonName) }}</span>
                                    </label>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">{{ $t('Update') }}</button>
                    </Form>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { Form, Field, ErrorMessage } from 'vee-validate';
import {ref} from "vue";
import breadcrumbConfig from "@/storage/data/breadcrumbs";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import Notifier from "@/libraries/utils/Notifier";
import { usePermissionStore } from '@/storage/store/permissions';
import StatusSwitcher from "@/components/widgets/form/StatusSwitcher";
import {useAuth} from "@/composables/useAuth";
import {useI18n} from "vue-i18n";
import {useRoute, useRouter} from "vue-router";
import {useMeta} from "vue-meta";
import {useAdminRoleStore} from "@/storage/store/admin_roles";

const props = defineProps({
    data: {
        type: Object,
        required: true
    }
})

const {fetchAndSetCurrentUser, getUser} = useAuth('admin');

const router = useRouter();
const routes = useRoute();
const { t: $t } = useI18n()
useMeta({title: $t('Role Edit')});

const roleId = routes.params.id;
const auth = getUser();

let form = ref(null);

mapRoleIntoForm(props.data.value);

const permissions = await usePermissionStore().getPermissionsByRefresh();

function updateRole() {
    axios.put(route('admin.roles.update', {id: roleId}), form.value).then(async (response) => {
        if (response.status == 200) {
            if (roleId == auth.role_id) {
                fetchAndSetCurrentUser();
            }
            await useAdminRoleStore().refreshRoles();
            Notifier.toastSuccess($t(response.data.message));
            await router.push({name: 'admin_roles'});
        }
    });
}

function changeActiveStatus(isActive) {
    form.value.is_active = isActive;
}

function mapRoleIntoForm(role) {
    form = ref({
        id: role.id,
        name: role.name,
        is_active: role.is_active,
        permissions: role.permissions.map((role_permission) => role_permission.permission)
    });
}


</script>