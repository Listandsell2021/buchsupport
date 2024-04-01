<template>
    <div>
        <div class="modal fade show" tabindex="-1" style="display: block">
            <div class="modal-dialog modal-lg">
                <div class="modal-content" v-on-click-outside="closeModal">
                    <div class="modal-body">
                        <a href="#" class="close modal-close-btn" @click.prevent="closeModal">
                            <i class="fa fa-close"></i>
                        </a>
                        <div>
                            <div class="form-group">
                                <label for="text">
                                    Ihr Kommentar:
                                </label>
                                <textarea v-model="comment.text"
                                          name="text"
                                          rows="5"
                                          id="text"
                                          class="form-control w-100"
                                          placeholder="Schreiben sie hier ihr Kommentar."
                                          required
                                />
                            </div>
                            <div class="w-100 d-flex justify-content-between">
                                <button class="mt-2 btn btn-primary"
                                        @click.prevent="createOrUpdateComment()"
                                >Absenden
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="modal-backdrop fade show"></div>
    </div>
</template>
<script setup>
import {ref} from "vue";
import {vOnClickOutside} from '@vueuse/components';
import axios from "@/libraries/utils/clientapi/axios";
import route from "@/libraries/utils/ZiggyRoute";

const comment = ref({
    text: '',
});

const emit = defineEmits(['close', 'reload'])

async function createOrUpdateComment() {
    await axios.post(route('customer.dashboard.create_comment'), comment.value)
        .then(response => {
            if (response.status === 200) {
                reloadComment();
                closeModal();
            }
        });
}

function reloadComment() {
    emit('reload');
}

function closeModal() {
    emit('close');
}


</script>
<style lang="sass">
</style>
