<template>
    <div class="vs-column-filter">

        <div class="dropdown">
            <i class="fa fa-filter" @click="toggleDropdown"></i>
            <Transition>
                <div class="dropdown-menu vs-filter-dropdown-menu" ref="dropdownMenu"
                     v-if="showDropdown">
                    <div class="vs-d-body">
                        <div class="vs-form-group">
                            <label class="vs-filter-label">{{ $t('Services') }}</label>
                            <BsSelect
                                v-model="form.service_ids"
                                :options="services"
                                label="name"
                                :reduce="service => service.id"
                                @update:model-value="updateService"
                                multiple
                                :placeholder="$t('Select services')"
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
import {useServiceStore} from "@/storage/store/services";
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
const form = ref({service_ids: []});
let services = await useServiceStore().getServicesByRefresh();

function toggleDropdown() {
    showDropdown.value = !showDropdown.value;
}

function updateService(selected) {
    if (selected == null) {
        form.value.service_ids = [];
    }
    changedEvent();
}


function changedEvent() {
    emit('changed', form.value);
}

function resetFilterForm() {
    form.value.service_ids = [];
    changedEvent();
}

onClickOutside(dropdownMenu, () => {
    toggleDropdown();
})

onBeforeMount(() => {
    if (__has(props.filters, 'service_ids')) {
        form.value.service_ids = props.filters.service_ids;
    }
})
</script>

<style scoped lang="scss">

</style>
