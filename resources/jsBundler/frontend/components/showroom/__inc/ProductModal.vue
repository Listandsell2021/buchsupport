<template>
    <div class="modal fade show ms-overlap">
        <div class="modal-dialog">
            <div class="modal-content" v-click-outside="closeModal">
                <div class="modal-header">
                    <h5 class="modal-title">Produkt Übersicht</h5>
                    <button @click.prevent="closeModal()" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="product-description" style="margin-bottom: 30px;">
                        <h3>Produkt-Beschreibung</h3>
                        <div v-html="product.note"></div>
                    </div>
                    <div class="product-description-additional" v-if="hasProductAdditionalNote(product)" style="margin-bottom: 30px;">
                        <h3>Zusätzliche Produktinformation</h3>
                        <div v-html="getProductAdditionalNote(product)"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import vClickOutside from 'click-outside-vue3';
import __Has from 'lodash/has';

export default {

    props: {
        product: {
            required: true
        }
    },

    directives: {
        clickOutside: vClickOutside.directive
    },

    components: {},

    data() {
        return {}
    },

    methods: {

        getProductListing(page = 1) {

        },

        closeModal() {
            this.$emit('close-modal');
        },

        getProductAdditionalNote(product) {
            if (__Has(product, 'pivot')) {
                return product.pivot.note;
            }
            if (__Has(product, 'user_product_note')) {
                return product.user_product_note;
            }
            return '';
        },

        hasProductAdditionalNote(product) {
            if (__Has(product, 'pivot')) {
                if (typeof product.pivot.note == 'string') {
                    return product.pivot.note.length != 0;
                }
            }
            if (__Has(product, 'user_product_note')) {
                if (typeof product.user_product_note == 'string') {
                    return product.user_product_note.length != 0;
                }
            }
            return 0;
        }

    }
}

</script>

<style></style>
