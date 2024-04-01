<template>
    <div class="col-xxl-8 col-sm-6 box-col-6">
        <div class="row">
            <div class="col-md-4" v-for="card in cards" :key="card">
                <div class="card small-widget">
                    <div :class="card.cardClass">
                        <span class="f-light">{{ card.title }}</span>
                        <div class="d-flex align-items-end gap-1">
                            <h4>{{ card.dataInNumber }}</h4>
                            <span class="f-12 f-w-500" :class="card.spanClass">
                                <i :class="card.iconClass"></i>
                                <span>{{ card.status }}</span>
                            </span>
                        </div>
                        <div class="bg-gradient">
                            <svg class="stroke-icon svg-fill">
                                <use :xlink:href="getImgURL(card.svgIcon)"></use>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import { useDashboardSummaryStore } from "@/storage/store/dashboardcards";

export default {
    setup() {
        const cardStore = useDashboardSummaryStore();

        cardStore.getCardsByRefresh();

        return { cardStore };
    },
    data() {
        return {
        }
    },
    computed: {
        cards() {
            return this.cardStore.cards;
        },
    },
    methods: {

        getImgURL(path) {
            return '/assets/admin/images/icon-sprite.svg/' + `#${path}`
        }
    }
}
</script>
    