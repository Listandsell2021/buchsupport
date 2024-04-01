<template>
    <div>
        <div class="page-title">
            <div class="row">
                <div class="col-md-7">
                    <div class="d-flex">
                        <h3>{{ title }}</h3>
                        <slot name="header"></slot>
                    </div>
                </div>
                <div class="col-md-5">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item">
                            <router-link :to="{ path: '/admin/dashboard' }">
                                <svg class="stroke-icon">
                                    <use href="/assets/frontend/svg/icon-sprite.svg#stroke-home"></use>
                                </svg>
                            </router-link>
                        </li>
                        <li class="breadcrumb-item" :class="{'active': menu.active}"
                            v-for="menu in menuItems"
                        >
                            <router-link :to="{ path: menu.url }" v-if="menu.url">
                                {{ $t(menu.name) }}
                            </router-link>
                            <span v-else>{{ getMenuName(menu.name) }}</span>
                        </li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import isInteger from "lodash/isInteger";

export default {
    components: {},
    props: {
        title: {
            required: true,
        },
        menuItems: {
            required: true,
            default: [],
            type: Array
        },
    },
    methods: {
        getMenuName(name) {
            if (parseInt(name) === 'NaN') {
                return this.$t(name);
            }

            return name;
        }
    }
};
</script>
