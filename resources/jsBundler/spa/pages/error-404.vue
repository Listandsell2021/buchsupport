<template>
    <div class="page-wrapper compact-wrapper" id="pageWrapper">
        <!-- error-400 start-->
        <div class="error-wrapper">
            <div class="container">
                <img class="img-100" src="/assets/admin/images/sad.png" alt="error"/>
                <div class="error-heading">
                    <h4 class="headline font-info">Page not found</h4>
                </div>
                <div class="col-md-8 offset-md-2">
                    <p class="sub-content">404 Message</p>
                </div>
                <div>
                    <button @click="handleError"
                            class="btn btn-info-gradien btn-lg"
                    >Back to home page</button>
                </div>
            </div>
        </div>
        <!-- error-400 end-->
    </div>
</template>
<script setup>
import {useAuthStore} from "@/storage/store/auth";
import {useRouter} from "vue-router";
import "@/assets/scss/app.scss";

const authStore = useAuthStore();
const router = useRouter();

let redirectUrl = '/';

if (authStore.getRoutes()) {
    redirectUrl = authStore.getRoutes().redirectAfterLoginUrl;
}

const handleError = () => router.push(redirectUrl);

</script>
