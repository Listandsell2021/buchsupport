<template>
    <metainfo>
        <template v-slot:title="{ content }">{{ appConfig.pageTitlePrefix }} | {{ content ? `${content}` : `` }}</template>
    </metainfo>
    <div>
        <Loading></Loading>
        <div class="container-fluid">
            <div class="row ">
                <div class="col-12 p-0">
                    <div class="login-card">
                        <div>
                            <div>
                                <a class="logo">
                                    <img class="img-fluid" src="/assets/admin/images/logo.png" alt="looginpage" />
                                </a>
                            </div>
                            <div class="login-main">
                                <Form class="theme-form" @submit="processLogin" v-slot="{errors}">
                                    <h4>{{ $t('Sign in to account') }}</h4>
                                    <p>{{ $t('Login to admin area') }}</p>
                                    <div class="form-group">
                                        <label class="col-form-label">{{ $t('Email Address')}}</label>
                                        <Field class="form-control"
                                               type="text"
                                               name="email"
                                               :placeholder="$t('Enter email address')"
                                               rules="email"
                                               :class="{'is-invalid': errors.email}"
                                        />
                                        <ErrorMessage class="text-danger d-block" name="email"/>
                                    </div>
                                    <div class="form-group">
                                        <label class="col-form-label">{{ $t('Password') }}</label>
                                        <div class="form-input position-relative">
                                            <Field class="form-control"
                                                   type="password"
                                                   name="password"
                                                   :placeholder="$t('Enter password')"
                                                   rules="min:6"
                                                   :class="{'is-invalid': errors.password}"
                                            />
                                            <ErrorMessage class="text-danger d-block" name="password"/>
                                        </div>
                                    </div>
                                    <div class="form-group mb-0">
                                        <div class="checkbox p-0">
                                            <input id="checkbox1" type="checkbox">
                                            <label class="text-muted" for="checkbox1">{{ $t('Remember password') }}</label>
                                        </div>
                                        <div class="text-end mt-3">
                                            <button class="btn btn-primary btn-block w-100"
                                                    type="submit"
                                            > {{ $t('Login') }} </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import "@/assets/scss/custom/login.scss";
import { Form, Field, ErrorMessage } from 'vee-validate';
import Loading from "@/components/common/Loading";
import {ref} from "vue";
import {useAuth} from "@/composables/useAuth";
import {useMeta} from "vue-meta";
import {useI18n} from "vue-i18n";
import appConfig from "@/config/app";

const errors = ref([])
const { login } = useAuth('admin');
const { t: $t } = useI18n();

useMeta({
    title: $t('Admin Login')
});

async function processLogin(form) {

    await login(form);

}


</script>