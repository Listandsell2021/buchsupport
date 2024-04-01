<template>
    <div>
        <Loading></Loading>

        <section class="login-block">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-4 login-sec">
                        <div class="login-container">
                            <a class="callback__icon callback__icon-top-left" :href="getPreviousUrl()">
                                <i class="fa fa-arrow-left"></i>
                            </a>

                            <div class="call-btn-bar"><a :href="appConfig.getTelephoneNoLink">
                                <i class="fa fa-phone"></i></a>
                            </div>

                            <div class="logo-wrapper">
                                <a href="/">
                                    <img class="logo-img"
                                         src="/assets/admin/images/logo-sm.png"
                                         alt="logo"
                                         style="height: 75px;"
                                    />
                                </a>
                            </div>
                            <div class="v-card__title border-bottom">
                                <h1 class="login-title text-center">Los geht’s</h1>
                                <div class="login-txt">
                                    Loggen sie sich <br> hier in Ihren Kundenbereich ein
                                </div>
                            </div>
                            <div class="v-form p-4">
                                <div class="form-group">
                                    <label for="register-number" class="input-label">Registrierungs-Nr.</label>
                                    <input class="form-control input-login"
                                           id="register-number"
                                           type="text"
                                           v-model="loginForm.id"
                                           v-maska
                                           data-maska="#### #### #### ####"
                                           name="registration_no"
                                           placeholder=""
                                    />
                                </div>
                                <div class="form-group">
                                    <label for="password" class="input-label">Passwort</label>
                                    <div class="input-password-group">
                                        <div id="qvrizl">
                                            <input class="form-control input-login"
                                                   id="password"
                                                   type="password"
                                                   name="password"
                                                   v-model="loginForm.password"
                                                   placeholder=""
                                            />
                                        </div>
                                        <span class="password-hider-icon"><i class="mdi mdi-eye"></i></span>
                                    </div>
                                </div>
                                <a href="#" @click.prevent="openForgotPasswordModal" class="forgot-pass-link anchor-link">Passwort vergessen?</a>
                                <div class="v-card__actions login-btn-action">
                                    <button class="btn btn-login btn-block" @click.prevent="processLogin">
                                        <i class="md-icon mdi mdi-lock"></i> Login
                                    </button>
                                </div>
                            </div>
                            <div class="text-center">
                                <a class="register-now-link"
                                   :href="getRegistrationPage()"
                                > Noch kein Konto? Jetzt Registrieren
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 banner-sec">
                        <div class="overlay-dark">
                            <div class="video-controller">
                                <h4 class="video-instruction">
                                    Wie funktioniert's?<br>Jetzt Video anschauen!
                                </h4>
                                <span class="login-play-btn" @click.prevent="openLoginVideo">
                                    <img src="/assets/admin/images/play-btn.svg" alt="play button"/>
                                </span>
                            </div>
                            <div class="bkg-img d-flex flex-column justify-content-end align-items-center ">
                                <div class="txt-center container">
                                    <div class="login-title-right align-self-center">
                                        Ihr exklusiver Zugang zu den Raritäten und Bücherschätzen
                                    </div>
                                    <div class="login-text-right align-self-center">
                                        Der exklusive Zugang zu unserer Plattform soll dem Kunden ermöglichen, seine
                                        eigene
                                        Sammlung unkompliziert zu verwalten, das Finden interessierter Käufer und
                                        attraktiver Angebote zu vereinfachen und einen sicheren und unkomplizierten
                                        Handel
                                        zu betreiben.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <ForgetPasswordModal
                    v-if="passwordForgotModal"
                    @close="closeForgotPasswordModal"
                ></ForgetPasswordModal>

                <LoginVideoModal v-if="loginVideoModal"
                                 @close="closeLoginVideo"
                ></LoginVideoModal>

            </div>
        </section>

    </div>
</template>
<script setup>
import "@/assets/scss/custom/login.scss";
import {ref} from "vue";
import {vMaska} from "maska";
import Loading from "@/components/common/Loading";
import {useAuth} from "@/composables/useAuth";
import {useI18n} from "vue-i18n";
import ForgetPasswordModal from "@/components/customer/login/ForgetPasswordModal.vue";
import BtModalHelper from "@/libraries/utils/BtModalHelper";
import LoginVideoModal from "@/components/customer/login/LoginVideoModal.vue";

const {t: $t} = useI18n();
const errors = ref([])
const {login, user} = useAuth('customer');
const loginForm = ref({
    id: '',
    password: ''
});

const loginVideoModal = ref(false);
const passwordForgotModal = ref(false);
const appConfig = window.Laravel.config;

async function processLogin() {
    await login(loginForm.value);
}

function getRegistrationPage() {
    return appConfig.getContactPageUrl;
}

function getPreviousUrl() {
    let previousUrl = window.Laravel.config.getPreviousUrl;

    return previousUrl ? previousUrl : '/';
}

function openLoginVideo() {
    loginVideoModal.value = true;
    BtModalHelper.open();
}

function closeLoginVideo() {
    loginVideoModal.value = false;
    BtModalHelper.close();
}

function openForgotPasswordModal() {
    passwordForgotModal.value = true;
    BtModalHelper.open();
}

function closeForgotPasswordModal() {
    passwordForgotModal.value = false;
    BtModalHelper.close();
}

</script>