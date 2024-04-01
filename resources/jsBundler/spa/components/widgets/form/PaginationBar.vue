<template>
    <div class="pagination-bar" :class="props.class">
        <div class="d-flex justify-content-between">
            <div class="flex mb-3 sm:mb-0">
                <div class="pagination-text-sec text-gray-700 text-base" v-if="!isEmpty(props.data) && props.data.total > 0">
                    Zeige <span class="font-medium">{{ props.data.from }}</span> bis
                    <span class="font-medium">{{ props.data.to }}</span> von
                    <span class="font-medium">{{ props.data.total }}</span> Ergebnissen
                </div>
            </div>
            <div class="d-flex">
                <template v-if="props.data.total > PaginationSetting.per_page">
                    <BsSelect
                        :clearable="false"
                        v-model="form.per_page"
                        :options="PaginationSetting.per_page_options"
                        :placeholder="$t('Per Page')"
                        @update:model-value="updatePerPage"
                        append-to-body
                        :calculate-position="withPopper"
                    >

                    </BsSelect>
                </template>
                <Bootstrap5Pagination :data="props.data"
                                      class="m-l-25"
                                    @pagination-change-page="pageChanged"
                                    :limit="PaginationSetting.pagination_bar_limit"
                ></Bootstrap5Pagination>
            </div>
        </div>
    </div>
</template>

<script setup>
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import __isEmpty from 'lodash/isEmpty';
import PaginationSetting from "@/storage/data/paginationSetting";
import { createPopper } from '@popperjs/core';
import {ref} from "vue";

const emit = defineEmits(['change']);

const props = defineProps({
    data: {
        required: true,
    },
    class: {
        default: ''
    }
})

const form = ref({
   per_page: PaginationSetting.per_page,
   page_no: 1,
});

let placement = ref('bottom');

function pageChanged(page = 1) {
    form.value.page = page;
    onChange();
}

function updatePerPage(selected) {
    form.value.per_page = selected;
    onChange();
}

function onChange() {
    emit('change', form.value.page, form.value.per_page);
}

function isEmpty(data) {
    return __isEmpty(data);
}

function withPopper(dropdownList, component, { width }) {
    /**
     * We need to explicitly define the dropdown width since
     * it is usually inherited from the parent with CSS.
     */
    dropdownList.style.width = width

    /**
     * Here we position the dropdownList relative to the $refs.toggle Element.
     *
     * The 'offset' modifier aligns the dropdown so that the $refs.toggle and
     * the dropdownList overlap by 1 pixel.
     *
     * The 'toggleClass' modifier adds a 'drop-up' class to the Vue Select
     * wrapper so that we can set some styles for when the dropdown is placed
     * above.
     */
    const popper = createPopper(component.$refs.toggle, dropdownList, {
        placement: placement.value,
        modifiers: [
            {
                name: 'offset',
                options: {
                    offset: [0, -1],
                },
            },
            {
                name: 'toggleClass',
                enabled: true,
                phase: 'write',
                fn({ state }) {
                    component.$el.classList.toggle(
                        'drop-up',
                        state.placement === 'top'
                    )
                },
            },
        ],
    })

    /**
     * To prevent memory leaks Popper needs to be destroyed.
     * If you return function, it will be called just before dropdown is removed from DOM.
     */
    return () => popper.destroy()
}

</script>

<style scoped>
.v-select {
    width: 90px;
}
.vs__dropdown-toggle {
    padding: 2px 0 7px;
}


.v-select.drop-up.vs--open .vs__dropdown-toggle {
    border-radius: 0 0 4px 4px;
    border-top-color: transparent;
    border-bottom-color: rgba(60, 60, 60, 0.26);
}

[data-popper-placement='top'] {
    border-radius: 4px 4px 0 0;
    border-top-style: solid;
    border-bottom-style: none;
    box-shadow: 0 -3px 6px rgba(0, 0, 0, 0.15);
}

</style>
