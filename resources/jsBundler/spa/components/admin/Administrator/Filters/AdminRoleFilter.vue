<template>
    <div class="vs-column-filter">

        <div class="dropdown">
            <i class="fa fa-filter" @click="toggleDropdown"></i>
            <Transition>
                <div class="dropdown-menu vs-filter-dropdown-menu dropdown-menu-right" ref="dropdownMenu" v-if="showDropdown">
                    <div class="vs-d-body">
                        <div class="vs-form-group">
                            <label class="vs-filter-label">{{ $t('Role') }}</label>
                            <BsSelect
                                v-model="form.role_id"
                                :options="roles"
                                label="name"
                                :reduce="role => role.id"
                                :clearable="false"
                                @update:model-value="updateRole"
                                :placeholder="$t('Select Role')"
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
    import { useAdminRoleStore } from '@/storage/store/admin_roles';

    const emit = defineEmits(['changed'])

    let showDropdown = ref(false);
    const dropdownMenu = ref(null);
    const form = ref({role_id: ''});
    const roles = await useAdminRoleStore().getRolesByRefresh();

    function toggleDropdown() {
        showDropdown.value = !showDropdown.value;
    }

    const updateRole = debounce((selected) => {
        if (selected == null) {
            form.value.role_id = '';
        }
        changedEvent();
    }, 500);

    function changedEvent() {
        emit('changed', form.value);
    }

    function resetFilterForm() {
        form.value.role_id = '';
        changedEvent();
    }

    onClickOutside(dropdownMenu, () => {
        toggleDropdown();
    })
</script>

<style scoped lang="scss">

</style>
