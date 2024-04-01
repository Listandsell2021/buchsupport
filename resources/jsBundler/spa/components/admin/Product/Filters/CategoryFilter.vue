<template>
    <div class="vs-column-filter">

        <div class="dropdown">
            <i class="fa fa-filter" @click="toggleDropdown"></i>
            <Transition>
                <div class="dropdown-menu vs-filter-dropdown-menu" ref="dropdownMenu" v-if="showDropdown">
                    <div class="vs-d-body">
                        <div class="vs-form-group">
                            <label class="vs-filter-label">{{ $t('Category') }}</label>
                            <BsSelect
                                v-model="form.category_id"
                                :options="categories"
                                label="name"
                                :reduce="category => category.id"
                                :clearable="false"
                                @update:model-value="updateCategory"
                                :placeholder="$t('Select Category')"
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
    import { useProductCategoryStore } from '@/storage/store/product_categories';

    const emit = defineEmits(['changed'])

    let showDropdown = ref(false);
    const dropdownMenu = ref(null);
    const form = ref({category_id: ''});
    const categories = await useProductCategoryStore().getCategoriesByRefresh();

    function toggleDropdown() {
        showDropdown.value = !showDropdown.value;
    }

    const updateCategory = debounce((selected) => {
        if (selected == null) {
            form.value.category_id = '';
        }
        changedEvent();
    }, 500);

    function changedEvent() {
        emit('changed', form.value);
    }

    function resetFilterForm() {
        form.value.category_id = '';
        changedEvent();
    }

    onClickOutside(dropdownMenu, () => {
        toggleDropdown();
    })
</script>

<style scoped lang="scss">

</style>
