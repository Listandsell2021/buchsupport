<template>
    <div class="row">
        <div class="col-md-4 library-col" v-for="product in products">
            <product-item
                :product="product"
                :customer-id="customerId"
                :config="config"
            ></product-item>
        </div>
    </div>
</template>

<script>
import ProductItem from './ProductItem';

export default {

    props: {
        initialProducts: {
            required: true
        },
        customerId: {
            required: true,
        },
        config: {
            required: true,
        },
    },

    components: {
        'product-item': ProductItem,
    },

    data() {
        return {
            products: [],
        }
    },

    computed: {},

    created() {
        this.products = this.initialProducts;
    },

    mounted() {

    },

    methods: {

    }
}

</script>

<style></style>
