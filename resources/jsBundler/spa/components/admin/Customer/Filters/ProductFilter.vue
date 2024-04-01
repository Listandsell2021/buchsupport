<template>
    <div class="vs-column-filter">

        <div class="dropdown">
            <i class="fa fa-filter" @click="toggleDropdown"></i>
            <Transition>
                <div class="dropdown-menu vs-filter-dropdown-menu dropdown-menu-right" ref="dropdownMenu" v-if="showDropdown">
                    <div class="vs-d-body">
                        <div class="vs-form-group">
                            <label class="vs-filter-label">{{ $t('Products') }}</label>
                            <BsSelect
                                id="product_ids"
                                :options="products"
                                v-model="form.product_ids"
                                :reduce="product => product.id"
                                label="name"
                                @update:model-value="updateProducts"
                                :placeholder="$t('Select Product')"
                                :clearable="false"
                                multiple
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
    import { useProductStore } from '@/storage/store/products';

    const emit = defineEmits(['changed'])

    let showDropdown = ref(false);
    const dropdownMenu = ref(null);
    const form = ref({product_ids: []});
    const products = await useProductStore().getProductsByRefresh();

    function toggleDropdown() {
        showDropdown.value = !showDropdown.value;
    }

    const updateProducts = debounce((selected) => {
        if (selected == null) {
            form.value.product_ids = [];
        }
        changedEvent();
    }, 500);

    function changedEvent() {
        emit('changed', form.value);
    }

    function resetFilterForm() {
        form.value.product_ids = [];
        changedEvent();
    }

    onClickOutside(dropdownMenu, () => {
        toggleDropdown();
    })
</script>

<style scoped lang="scss">

</style>
