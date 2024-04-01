<template>
    <li class="profile-nav pe-0 py-0">
        <router-link :to="'/customer/profile'" class="m-r-25">
            <span class="m-r-5">{{ useAuthStore().user.first_name+' '+useAuthStore().user.last_name }}</span>
            <i class="fa fa-user"></i>
        </router-link>
        <a href="#" @click.prevent="logout">
            <span class="m-r-5">Log out</span>
            <i class="fa fa-sign-out"></i>
        </a>
    </li>
</template>

<script setup>
import {ref} from "vue";
import {useAuthStore} from "@/storage/store/auth";
import {useAuth} from "@/composables/useAuth";

const {logout, user} = useAuth('customer');

</script>
<style>

</style>