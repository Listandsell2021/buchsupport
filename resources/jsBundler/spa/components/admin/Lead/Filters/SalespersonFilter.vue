<template>
    <div class="vs-column-filter">

        <div class="dropdown">
            <i class="fa fa-filter" @click="toggleDropdown"></i>
            <Transition>
                <div class="dropdown-menu vs-filter-dropdown-menu" ref="dropdownMenu"
                     v-if="showDropdown">
                    <div class="vs-d-body">
                        <div class="vs-form-group">
                            <label class="vs-filter-label">{{ $t('Salesperson') }}</label>
                            <BsSelect
                                v-model="form.salesperson_ids"
                                :options="salespersons"
                                label="fullname"
                                :reduce="salesperson => salesperson.id"
                                @update:model-value="updateSalesperson"
                                multiple
                                :placeholder="$t('Select salesperson')"
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
import {onBeforeMount, ref} from "vue";
import debounce from 'lodash/debounce';
import {useSalespersonsStore} from "@/storage/store/salespersons";
import {onClickOutside} from '@vueuse/core';
import __has from "lodash/has";

const props = defineProps({
    filters: {
        type: Object,
        default: () => ({})
    }
});

const emit = defineEmits(['changed'])

let showDropdown = ref(false);
const dropdownMenu = ref(null);
const form = ref({salesperson_ids: []});
let salespersons = await useSalespersonsStore().getSalespersonsByRefresh();

function toggleDropdown() {
    showDropdown.value = !showDropdown.value;
}

function updateSalesperson(selected) {
    if (selected == null) {
        form.value.salesperson_ids = [];
    }
    changedEvent();
}


function changedEvent() {
    emit('changed', form.value);
}

function resetFilterForm() {
    form.value.salesperson_ids = '';
    changedEvent();
}

onClickOutside(dropdownMenu, () => {
    toggleDropdown();
})
onBeforeMount(() => {
    if (__has(props.filters, 'salesperson_ids')) {
        form.value.salesperson_ids = props.filters.salesperson_ids;
    }
})
</script>

<style scoped lang="scss">

</style>
