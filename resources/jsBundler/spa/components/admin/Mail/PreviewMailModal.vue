<template>
    <div class="modal fade show modal-show" id="add-lead-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" ref="modalDialog">
            <div class="modal-content">
                <div class="modal-body">
                    <a href="#" @click.prevent="closeModal" class="close close-modal" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </a>

                    <iframe class="mail-preview-frame" :srcdoc="previewMail()"></iframe>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {ref} from "vue";
import {onMounted} from "vue";

const emit = defineEmits(['close']);

const props = defineProps({
    layout: {
        type: String,
        default: '{{{ body }}}',
    },
    style: {
        type: String,
        default: '',
    },
    content: {
        required: true
    }
});

function closeModal() {
    emit('close');
}

function previewMail() {
    let layout = props.style+props.layout;

    if (layout.includes('{{{ body }}}')) {
        return layout.replace('{{{ body }}}', props.content);
    }

    return props.style+props.content;
}

onMounted(async () => {

})

</script>

<style scoped lang="scss">
.mail-preview-frame {
    width: 100%;
    height: 400px;
    overflow-y: scroll;
}
</style>
