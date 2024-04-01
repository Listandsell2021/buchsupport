<template>
    <div class="vs-column-filter">

        <div class="dropdown">
            <i class="fa fa-filter" @click="toggleDropdown"></i>
            <Transition>
                <div class="dropdown-menu vs-filter-dropdown-menu dropdown-menu-right" ref="dropdownMenu" v-if="showDropdown">
                    <div class="vs-d-body">
                        <div class="vs-form-group">
                            <label class="vs-filter-label">{{ $t('Auth Role') }}</label>
                            <BsSelect
                                v-model="form.auth_role"
                                :options="authRoles"
                                label="name"
                                :reduce="role => role.id"
                                :clearable="false"
                                @update:model-value="updateAuthRole"
                                :placeholder="$t('Select auth role')"
                            />
                        </div>

                        <div class="vs-form-group" v-if="form.auth_role != auth.salesperson_role">
                            <label class="vs-filter-label">{{ $t('Role') }}</label>
                            <BsSelect
                                v-model="form.role_id"
                                :options="adminRoles"
                                label="name"
                                :reduce="role => role.id"
                                :clearable="false"
                                @update:model-value="updateAdminRole"
                                :placeholder="$t('Select admin role')"
                            />
                        </div>

                    </div>
                    <div class="vs-d-footer clearfix">
                        <button class="btn btn-primary btn-sm pull-right"
                            @click="resetFilterForm"
                        >
                            <i class="fa fa-remove"></i> {{ $t('Clear') }}
                        </button>
                    </div>
                </div>
            </Transition>
        </div>
    </div>
</template>

<script setup>
import {ref} from "vue";
    import debounce from 'lodash/debounce';
    import { onClickOutside } from '@vueuse/core';
    import auth from '@/config/auth';
    import { useAuthRoleStore } from '@/storage/store/auth_roles';
    import { useAdminRoleStore } from '@/storage/store/admin_roles';

    const emit = defineEmits(['changed'])

    let showDropdown = ref(false);
    const dropdownMenu = ref(null);
    const form = ref({auth_role: '', role_id: ''});
    const authRoles = await useAuthRoleStore().getRolesByRefresh();
    const adminRoles = await useAdminRoleStore().getRolesByRefresh();

    function toggleDropdown() {
        showDropdown.value = !showDropdown.value;
    }

    const updateAuthRole = debounce((selected) => {
        if (selected == null) {
            form.value.auth_role = '';
        }
        changedEvent();
    }, 500);

    const updateAdminRole = debounce((selected) => {
        if (selected == null) {
            form.value.role_id = '';
        }
        changedEvent();
    }, 500);

    function changedEvent() {
        emit('changed', form.value);
    }

    function resetFilterForm() {
        form.value.auth_role = '';
        form.value.role_id = '';
        changedEvent();
    }

    onClickOutside(dropdownMenu, () => {
        toggleDropdown();
    })
</script>

<style scoped lang="scss">

</style>
