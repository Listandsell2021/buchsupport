<template>
    <div>
        <div class="modal fade in show" style="display: block">
            <div class="modal-dialog" v-on-click-outside="closeModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Haben Sie Ihr Passwort vergessen?</h5>
                        <a href="#" class="close" data-dismiss="modal" @click.prevent="$emit('close')">
                            <i class="fa fa-close"></i>
                        </a>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="account_no">Bibliotheknummer *</label>
                            <input class="form-control"
                                   id="account_no"
                                   name="account_no"
                                   v-model="forgetPasswordForm.user_id"
                                   v-maska
                                   data-maska="#### #### #### ####"
                                   placeholder="16-stellige Bibliotheksnummer"
                            />
                        </div>
                        <div class="form-group">
                            <label for="username">Name *</label>
                            <input class="form-control"
                                   v-model="forgetPasswordForm.username"
                                   id="username"
                                   type="text"
                                   placeholder="Geben Sie Ihren Namen ein"
                            />
                        </div>
                        <div class="form-group">
                            <label for="phone_no">Telefonnummer *</label>
                            <input class="form-control"
                                   v-model="forgetPasswordForm.phone_no"
                                   id="phone_no"
                                   type="text"
                                   placeholder="+49XXXXXXXXXX"
                            />
                        </div>
                        <div class="form-group mt-4">
                            <button class="btn btn-block btn-site btn-login"
                                    @click.prevent="sendPasswordForgotRequest"
                            >Rückruf anfordern</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import { vOnClickOutside } from '@vueuse/components';
import Axios from "@/libraries/utils/clientapi/axios";
import Notifier from "@/libraries/utils/Notifier";
import {ref} from "vue";
import {vMaska} from "maska";
//v-on-click-outside="$emit('close')"

const emit = defineEmits(['close']);

const forgetPasswordForm = ref({
    user_id: '',
    username: '',
    phone_no: '',
});

function sendPasswordForgotRequest() {
    Axios.post('password-forgot-request', forgetPasswordForm.value)
        .then((response) => {
            if (response.status === 200) {
                Notifier.toastSuccess(response.data.message);
                closeModal();
            }
        });
}

function closeModal() {
    emit('close');
}
</script>
<style lang="sass">
</style>
