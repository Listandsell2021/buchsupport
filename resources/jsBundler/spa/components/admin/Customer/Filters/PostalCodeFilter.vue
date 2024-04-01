<template>
    <div class="vs-column-filter">

        <div class="dropdown">
            <i class="fa fa-filter" @click="toggleDropdown"></i>
            <Transition>
                <div class="dropdown-menu vs-filter-dropdown-menu" ref="dropdownMenu" v-if="showDropdown">
                    <div class="vs-d-body">
                        <div class="vs-form-group">
                            <div class="row">
                                <div class="col">
                                    <label class="vs-filter-label">{{ $t('Starting') }}</label>
                                    <input type="text"
                                           class="form-control"
                                           v-model="form.postal_code_start"
                                           @input="inputChanged"
                                           placeholder="0"
                                    />
                                </div>
                                <div class="col">
                                    <label class="vs-filter-label">{{ $t('Ending') }}</label>
                                    <input type="text"
                                           class="form-control"
                                           v-model="form.postal_code_end"
                                           @input="inputChanged"
                                           placeholder="99999"
                                    />
                                </div>
                            </div>

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

    const emit = defineEmits(['changed'])

    let showDropdown = ref(false);
    const dropdownMenu = ref(null);
    const form = ref({postal_code_start: '', postal_code_end: ''});

    function toggleDropdown() {
        showDropdown.value = !showDropdown.value;
    }

    const inputChanged = debounce(() => {
        changedEvent();
    }, 500);

    function changedEvent() {
        emit('changed', form.value);
    }

    function resetFilterForm() {
        form.value.postal_code_start = '';
        form.value.postal_code_end = '';
        changedEvent();
    }

    onClickOutside(dropdownMenu, () => {
        toggleDropdown();
    })
</script>

<style scoped lang="scss">

</style>
