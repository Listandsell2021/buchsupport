<template>
    <div class="vs-column-filter">

        <div class="dropdown">
            <i class="fa fa-filter" @click="toggleDropdown"></i>
            <Transition>
                <div class="dropdown-menu vs-filter-dropdown-menu dropdown-menu-right" ref="dropdownMenu"
                     v-if="showDropdown">
                    <div class="vs-d-body">
                        <div class="vs-form-group">
                            <label class="vs-filter-label">{{ $t('Status') }}</label>
                            <BsSelect
                                v-model="form.lead_status_id"
                                :options="useLeadStatusStore().lead_status"
                                label="name"
                                :reduce="status => status.id"
                                @update:model-value="updateStatus"
                                :placeholder="$t('Select Status')"
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
import {onClickOutside} from '@vueuse/core';
import {useLeadStatusStore} from '@/storage/store/lead_status';
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
const form = ref({lead_status_id: ''});
await useLeadStatusStore().getLeadStatusByRefresh();

function toggleDropdown() {
    showDropdown.value = !showDropdown.value;
}

const updateStatus = debounce((selected) => {
    if (selected == null) {
        form.value.lead_status_id = '';
    }
    changedEvent();
}, 500);

function changedEvent() {
    emit('changed', form.value);
}

function resetFilterForm() {
    form.value.lead_status_id = '';
    changedEvent();
}

onClickOutside(dropdownMenu, () => {
    toggleDropdown();
})
onBeforeMount(() => {
    if (__has(props.filters, 'lead_status_id')) {
        form.value.lead_status_id = props.filters.lead_status_id;
    }
})
</script>

<style scoped lang="scss">

</style>
