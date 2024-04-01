<template>
    <div class="modal fade show modal-show d-block" id="profile-password-editor" tabindex="-1" role="dialog">
        <div class="modal-dialog" ref="modalDialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">{{ $t('Neues Passwort zuweisen') }}</h5>
                    <a href="#" @click.prevent="closeModal" class="close close-modal" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="password-editor">

                        <div class="form-group">
                            <label for="password">Passwort</label>
                            <VisiblePasswordInput
                                @change="setPassword"
                                :generator="false"
                            ></VisiblePasswordInput>
                        </div>

                        <div class="form-group">
                            <label for="password">Passwort bestätigen</label>
                            <VisiblePasswordInput
                                @change="setConfirmPassword"
                                :generator="false"
                            ></VisiblePasswordInput>
                        </div>

                        <div class="clearfix m-t-30">
                            <button class="btn btn-secondary pull-left" @click.prevent="closeModal">{{ $t('Cancel') }}</button>
                            <button class="btn btn-primary pull-right" @click.prevent="updatePassword">{{ $t('Save') }}</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {onMounted, ref} from "vue";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import { onClickOutside } from '@vueuse/core';
import Notifier from "@/libraries/utils/Notifier";
import VisiblePasswordInput from "@/components/widgets/form/VisiblePasswordInput";

const props = defineProps({
    user_id: {
        required: true
    }
});

const emit = defineEmits(['close']);
const modalDialog = ref(null);

const form = ref({
    user_id: props.user_id,
    password: '',
    confirm_password: '',
});

onClickOutside(modalDialog, () => {
    closeModal();
})

function updatePassword() {
    axios.post(route('customer.profile.update_password'), form.value).then((response) => {
        if (response.status === 200) {
            Notifier.toastSuccess(response.data.message);
            closeModal();
        }
    });
}

function setPassword(password) {
    form.value.password = password;
    form.value.confirm_password = password;
}

function setConfirmPassword(password) {
    form.value.confirm_password = password;
}

function closeModal() {
    emit('close');
}


onMounted(async () => {

})

</script>

<style scoped lang="scss">

</style>
