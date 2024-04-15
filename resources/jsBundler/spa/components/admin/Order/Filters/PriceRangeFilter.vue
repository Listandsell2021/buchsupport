<template>
    <div class="vs-column-filter">

        <div class="dropdown">
            <i class="fa fa-filter" @click="toggleDropdown"></i>
            <Transition>
                <div class="dropdown-menu vs-filter-dropdown-menu" ref="dropdownMenu"
                     v-if="showDropdown">
                    <div class="vs-d-body">
                        <div class="vs-form-group">
                            <label class="vs-filter-label">{{ $t('Price Range') }}</label>
                            <div class="m-b-10">
                                <input type="number"
                                       v-model="form.price_from"
                                       class="form-control"
                                       :placeholder="$t('Price from')"
                                       @input="inputChanged"
                                />
                            </div>
                            <div class="">
                                <input type="number"
                                       v-model="form.price_to"
                                       class="form-control"
                                       @input="inputChanged"
                                       :placeholder="$t('Price to')"
                                />
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
import {onBeforeMount, ref} from "vue";
import {useServiceStore} from "@/storage/store/services";
import {onClickOutside} from '@vueuse/core';
import __has from "lodash/has";
import debounce from "lodash/debounce";

const props = defineProps({
    filters: {
        type: Object,
        default: () => ({})
    }
});

const emit = defineEmits(['changed'])

let showDropdown = ref(false);
const dropdownMenu = ref(null);
const form = ref({price_from: '', price_to: ''});

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
    form.value.price_from = '';
    form.value.price_to = '';
    changedEvent();
}

onClickOutside(dropdownMenu, () => {
    toggleDropdown();
})

</script>

<style scoped lang="scss">

</style>
