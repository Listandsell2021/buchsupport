<template>
    <div>

        <Breadcrumbs :menu-items="breadcrumbConfig.role.create()" :title="$t('Role Create')"/>

        <div class="container-fluid">
            <div class="card">
                <div class="card-body">

                    <Form @submit="createRole" v-slot="{errors}">
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

                        <button type="submit" class="btn btn-primary">{{ $t('Create') }}</button>
                    </Form>

                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import {onMounted, ref} from "vue";
import { Form, Field, ErrorMessage } from 'vee-validate';
import breadcrumbConfig from "@/storage/data/breadcrumbs";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import { usePermissionStore } from '@/storage/store/permissions';
import StatusSwitcher from "@/components/widgets/form/StatusSwitcher";
import Notifier from "@/libraries/utils/Notifier";
import {useRouter} from "vue-router";
import {useI18n} from "vue-i18n";
import {useMeta} from "vue-meta";
import {useAdminRoleStore} from "@/storage/store/admin_roles";

const router = useRouter();
const {t: $t} = useI18n();
useMeta({title: $t('Role Create')});

const form = ref({
    name: '',
    is_active: 1,
    permissions: [],
});

function changeActiveStatus(isActive) {
    form.value.is_active = isActive;
}

const permissions = await usePermissionStore().getPermissionsByRefresh();

function createRole() {
    axios.post(route('admin.roles.store'), form.value).then(async (response) => {
        if (response.status == 201) {
            Notifier.toastSuccess(response.data.message);
            await useAdminRoleStore().refreshRoles();
            await router.push({name: 'admin_roles'});
        }
    });
}

onMounted(async () => {

})

</script>