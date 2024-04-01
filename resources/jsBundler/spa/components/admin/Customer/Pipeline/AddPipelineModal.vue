<template>
    <div class="modal fade show modal-show" id="add-pipeline-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" ref="modalDialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ $t('Create Pipeline') }}</h5>
                    <a href="#" @click.prevent="closeModal" class="close close-modal" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">{{ $t('Name') }}</label>
                        <input type="text" class="form-control" v-model="form.name"/>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary"
                                @click.prevent="createNewPipeline"
                        >{{ $t('Save') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ref } from "vue";
import { onClickOutside } from '@vueuse/core';
import axios from "@/libraries/utils/clientapi/axios";
import route from "@/libraries/utils/ZiggyRoute";
import Notifier from "@/libraries/utils/Notifier";

const props = defineProps({});

const emit = defineEmits(['close']);
const modalDialog = ref(null);
const form = ref({
    name: '',
});

function closeModal() {
    emit('close');
}

function createNewPipeline() {
    axios.post( route('admin.pipeline.store'), form.value )
        .then(response => {
            if (response.status === 201) {
                Notifier.toastSuccess(response.data.message);
                emit('refresh');
            }
        });
}

onClickOutside(modalDialog, () => {
    closeModal();
})

</script>

<style scoped lang="scss">

</style>
