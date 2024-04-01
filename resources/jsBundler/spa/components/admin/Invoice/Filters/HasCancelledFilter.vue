<template>
    <div class="vs-column-filter">

        <div class="dropdown">
            <i class="fa fa-filter" @click="toggleDropdown"></i>
            <Transition>
                <div class="dropdown-menu vs-filter-dropdown-menu dropdown-menu-right" ref="dropdownMenu" v-if="showDropdown">
                    <div class="vs-d-body">
                        <div class="vs-form-group">
                            <label class="vs-filter-label">{{ $t('Is Cancelled') }}</label>
                            <BsSelect
                                v-model="form.is_cancelled"
                                :options="Status"
                                label="name"
                                :reduce="status => status.id"
                                @update:model-value="updateStatus"
                                :placeholder="$t('Select Cancelled Status')"
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
    import Status from "@/storage/data/yesnostatus";

    const emit = defineEmits(['changed'])

    let showDropdown = ref(false);
    const dropdownMenu = ref(null);
    const form = ref({is_cancelled: ''});

    function toggleDropdown() {
        showDropdown.value = !showDropdown.value;
    }

    const updateStatus = debounce((selected) => {
        if (selected == null) {
            form.value.is_cancelled = '';
        }
        changedEvent();
    }, 500);

    function changedEvent() {
        emit('changed', form.value);
    }

    function resetFilterForm() {
        form.value.is_cancelled = '';
        changedEvent();
    }

    onClickOutside(dropdownMenu, () => {
        toggleDropdown();
    })
</script>

<style scoped lang="scss">

</style>
