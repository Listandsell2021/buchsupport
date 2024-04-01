<template>
    <div class="vs-column-filter">

        <div class="dropdown">
            <i class="fa fa-filter" @click="toggleDropdown"></i>
            <Transition>
                <div class="dropdown-menu vs-filter-dropdown-menu" ref="dropdownMenu" v-if="showDropdown">
                    <div class="vs-d-body">
                        <div class="vs-form-group">
                            <label class="vs-filter-label">{{ $t('Email') }}</label>
                            <input type="text" class="form-control" v-model="form.email" @input="inputChanged">
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
const form = ref({email: ''});

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
    form.value.email = '';
    changedEvent();
}

onClickOutside(dropdownMenu, () => {
    toggleDropdown();
})

onBeforeMount(() => {
    if (__has(props.filters, 'email')) {
        form.value.email = props.filters.email;
    }
})
</script>

<style scoped lang="scss">

</style>
