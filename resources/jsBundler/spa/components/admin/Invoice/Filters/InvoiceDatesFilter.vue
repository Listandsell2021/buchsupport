<template>
    <div class="vs-column-filter">

        <div class="dropdown">
            <i class="fa fa-filter" @click="toggleDropdown"></i>
            <Transition>
                <div class="dropdown-menu vs-filter-dropdown-menu" v-on-click-outside="onClickOutsideHandler" v-if="showDropdown">
                    <div class="vs-d-body">
                        <div class="vs-form-group">
                            <div class="row">
                                <div class="col">
                                    <label class="vs-filter-label">{{ $t('Date From') }}</label>
                                    <BsDatePicker v-model:value="form.invoice_date_from"
                                                    value-type="format"
                                                    format="DD.MM.YYYY"
                                                    placeholder="DD.MM.YYYY"
                                                    @change="inputChanged"
                                    ></BsDatePicker>
                                </div>
                                <div class="col">
                                    <label class="vs-filter-label">{{ $t('Date To') }}</label>
                                    <BsDatePicker v-model:value="form.invoice_date_to"
                                                    value-type="format"
                                                    format="DD.MM.YYYY"
                                                    placeholder="DD.MM.YYYY"
                                                    @change="inputChanged"
                                    ></BsDatePicker>
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
    import { vOnClickOutside } from '@vueuse/components'

    const emit = defineEmits(['changed'])

    let showDropdown = ref(false);
    const dropdownMenu = ref(null);
    const form = ref({invoice_date_from: '', invoice_date_to: ''});

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
        form.value.invoice_date_from = '';
        form.value.invoice_date_to = '';
        changedEvent();
    }

    const onClickOutsideHandler = [
        (ev) => {
            if (hasSomeParentTheClass(ev.target, 'mx-datepicker-main') ) return;

            toggleDropdown();
        },
        { ignore: [] }
    ]

    function hasSomeParentTheClass(element, classname) {
        if (typeof(element.className) != "undefined") {
            if (element.className.split(' ').indexOf(classname)>=0) {
                return true
            }
        }
        return element.parentNode && hasSomeParentTheClass(element.parentNode, classname);
    }
</script>

<style scoped lang="scss">

</style>
