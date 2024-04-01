<template>
    <div class="modal login-video-modal fade show" style="display: block">
        <div class="modal-dialog modal-lg" v-on-click-outside="closeModal">
            <div class="modal-content">
                <a href="#" class="close" @click.prevent="closeModal">
                    <i class="fa fa-close"></i>
                </a>
                <video autoplay="" preload="none" controls="" controlslist="nodownload">
                    <source type="video/mp4" src="/assets/frontend/video/Bibliotheken_ - Buch-Kunstregister.mp4">
                </video>
            </div>
        </div>
    </div>
</template>
<script setup>
import { vOnClickOutside } from '@vueuse/components';

const emit = defineEmits(['close']);

function getEmbedUrl(link) {
    return 'https://www.youtube.com/embed/'+link;
}

function closeModal() {
    emit('close');
}
</script>
<style lang="sass">
</style>
