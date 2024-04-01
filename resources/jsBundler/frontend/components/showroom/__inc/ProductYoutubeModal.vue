<template>
    <div class="modal fade show ms-overlap">
        <div class="modal-dialog">
            <div class="modal-content" v-click-outside="closeModal">
                <div class="modal-header">
                    <h5 class="modal-title">Produkt Übersicht</h5>
                    <button @click.prevent="closeModal" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div v-if="hasYoutubeLink()">
                        <iframe :src="'https://www.youtube.com/embed/'+product.yt_link"
                                title="YouTube video player" frameborder="0"
                                class="produt-yt-iframe"
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                                allowfullscreen
                        ></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import vClickOutside from 'click-outside-vue3';

export default {

    props: {
        product: {
            required: true
        }
    },

    components: {},

    data() {
        return {}
    },

    created() {
    },

    mounted() {

    },

    directives: {
        clickOutside: vClickOutside.directive
    },

    methods: {

        getProductListing(page = 1) {

        },

        closeModal() {
            this.$emit('close-modal');
        },

        hasYoutubeLink() {
            if (this.product.yt_link != null) {
                return this.product.yt_link.length > 0;
            }
            return false;
        },

    }
}

</script>

<style></style>
