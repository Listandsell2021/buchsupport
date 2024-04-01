<template>
    <div class="vs-column-filter">

        <div class="dropdown">
            <i class="fa fa-filter" @click="toggleDropdown"></i>
            <Transition>
                <div class="dropdown-menu vs-filter-dropdown-menu dropdown-menu-right" ref="dropdownMenu"
                     v-if="showDropdown">
                    <div class="vs-d-body">
                        <div class="vs-form-group">
                            <label class="vs-filter-label">{{ $t('Gender') }}</label>
                            <BsSelect
                                v-model="form.gender"
                                :options="GendersSelectable"
                                :reduce="gender => gender.id"
                                label="name"
                                @update:model-value="updateGender"
                                :placeholder="$t('Select gender')"
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
import {onClickOutside} from '@vueuse/core';
import {useLeadStatusStore} from '@/storage/store/lead_status';
import __has from "lodash/has";
import {GendersSelectable} from "@/storage/data/genders";

const props = defineProps({
    filters: {
        type: Object,
        default: () => ({})
    }
});

const emit = defineEmits(['changed'])

let showDropdown = ref(false);
const dropdownMenu = ref(null);
const form = ref({gender: ''});
await useLeadStatusStore().getLeadStatusByRefresh();

function toggleDropdown() {
    showDropdown.value = !showDropdown.value;
}

function updateGender(selected) {
    if (selected == null) {
        form.value.gender = '';
    }
    changedEvent();
}

function changedEvent() {
    emit('changed', form.value);
}

function resetFilterForm() {
    form.value.gender = '';
    changedEvent();
}

onClickOutside(dropdownMenu, () => {
    toggleDropdown();
})
onBeforeMount(() => {
    if (__has(props.filters, 'gender')) {
        form.value.gender = props.filters.gender;
    }
})
</script>

<style scoped lang="scss">

</style>
