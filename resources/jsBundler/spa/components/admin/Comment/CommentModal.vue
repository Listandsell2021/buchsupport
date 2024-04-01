<template>
    <div class="modal fade show modal-show" id="add-lead-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" ref="modalDialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ $t('Comment') }}</h5>
                    <a href="#" @click.prevent="closeModal" class="close close-modal" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <div class="modal-body">
                    <div v-html="props.comment.text"></div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {onMounted, ref} from "vue";
import { onClickOutside } from '@vueuse/core';

const props = defineProps({
    comment: {
        required: true,
        type: Object,
    }
});

const emit = defineEmits(['close']);
const modalDialog = ref(null);

function closeModal() {
    emit('close');
}

onClickOutside(modalDialog, () => {
    closeModal();
})

</script>

<style scoped lang="scss">

</style>
