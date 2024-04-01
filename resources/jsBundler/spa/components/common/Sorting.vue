<template>
    <tr class="vs-sorting-column vs-sorting-custom" :class="classes">
        <slot name="sorting_top"></slot>
        <template v-for="column in columns" :key="column.key">
            <th class="vs-sorting-column-item" v-if="isVisible(column)">
                <div class="vs-sorting-column-inner">
                    <div class="vs-sorting-label">
                        {{ $t(column.name) }}
                        <span class="vs-sorting-icon">
                        <span class="vs-sorting-icon-trigger"
                              v-if="column.sort == 'none'"
                              @click.prevent="sortBy(column.key, 'none')"
                        >
                            <i class="fa fa-sort vs-sorting-icon-asc"></i>
                        </span>
                        <span class="vs-sorting-icon-trigger"
                              v-if="column.sort == 'asc'"
                              @click.prevent="sortBy(column.key, 'asc')"
                        >
                            <i class="fa fa-angle-down vs-sorting-icon-asc"></i>
                        </span>
                        <span class="vs-sorting-icon-trigger"
                              v-if="column.sort == 'desc'"
                              @click.prevent="sortBy(column.key, 'desc')"
                        >
                            <i class="fa fa-angle-up vs-sorting-icon-desc"></i>
                        </span>
                    </span>
                    </div>
                    <component @changed="changedFilters" :filters="filters" :is="column.component"></component>
                </div>
            </th>
        </template>
        <slot name="sorting_bottom"></slot>
    </tr>
</template>

<script>

import __has from "lodash/has";
import __is_Object from "lodash/isObject";
import __is_Array from "lodash/isArray";

export default {

    props: {
        columns: {
            required: true,
        },
        classes: {
            default: '',
        },
        filters: {
            type: Object,
            default: () => ({})
        }
    },

    components: {

    },

    data() {
        return {
           //sortingColumns: [],
        }
    },

    created() {
        //this.sortingColumns = this.columns;
    },

    methods: {

        async sortBy(columnKey, sortType) {
            await this.setColumnSorting(columnKey, sortType);
            await this.fireEventSortingColumnChanged();
        },

        setColumnSorting(columnKey, sortType) {

            if (__is_Array()) {
                this.columns.forEach((column) => {
                    if (column.key === columnKey) {
                        if (sortType === 'none') {
                            column.sort = 'asc';
                        }
                        if (sortType === 'asc') {
                            column.sort = 'desc';
                        }
                        if (sortType === 'desc') {
                            column.sort = 'none';
                        }
                   } else {
                       column.sort = 'none';
                   }
                }, columnKey, sortType);
            }

            if (__is_Object(this.columns)) {
                Object.keys(this.columns).forEach((key) => {
                    let column = this.columns[key];
                    if (column.key === columnKey) {
                        if (sortType === 'none') {
                            column.sort = 'asc';
                        }
                        if (sortType === 'asc') {
                            column.sort = 'desc';
                        }
                        if (sortType === 'desc') {
                            column.sort = 'none';
                        }
                    } else {
                        column.sort = 'none';
                    }
                }, columnKey, sortType);
            }
        },

        fireEventSortingColumnChanged() {
            this.$emit('column_changed', this.columns);
        },

        changedFilters(filters) {
            this.$emit('filter', filters);
        },

        isVisible(column) {
            return __has(column, 'show') ? column.show : true;
        }
    },

}
</script>

<style>

</style>
