<template>
    <li class="profile-nav pe-0 py-0">
        <div class="media profile-media">
            <!--<img class="b-r-10 a-profile-pic" src="/assets/admin/images/profile.png" alt=""/>-->
            <div class="media-body"
                 @click.prevent="toggleDropdownMenu"
                 ref="profileDropdownBtn"
            >
                <div class="">
                    <span>{{ useAuthStore().user.first_name+' '+useAuthStore().user.last_name }}</span>
                </div>
                <p class="mb-0 font-roboto">
                     <i class="middle fa fa-angle-down"></i>
                </p>
            </div>
        </div>

        <ul class="profile-dropdown dropdown-menu dropdown-menu-right"
            :class="{ show: showDropdownMenu }"
            v-on-click-outside="closeDropdownMenu"
        >
            <li>
                <router-link :to="'/admin/administrators/'+auth.getAuth().id"><i class="fa fa-user"></i> <span>{{ $t('Account') }}</span></router-link>
            </li>
            <li>
                <router-link :to="'/admin/settings'"><i class="fa fa-cog"></i><span>{{ $t('Settings') }}</span></router-link>
            </li>
            <li>
                <a href="#" @click.prevent="logout"><i class="fa fa-sign-out"></i><span>{{ $t('Logout') }}</span></a>
            </li>
        </ul>
    </li>
</template>

<script setup>
import {useAuth} from "@/composables/useAuth";
import { vOnClickOutside } from '@vueuse/components';
import {useAuthStore} from "@/storage/store/auth";
import {ref} from "vue";

const {logout} = useAuth('admin');
const auth = useAuthStore();

const showDropdownMenu = ref(false);
const profileDropdownBtn = ref(null);

function toggleDropdownMenu() {
    showDropdownMenu.value = !showDropdownMenu.value;
}

const closeDropdownMenu = [
    () => {
        showDropdownMenu.value = false;
    },
    { ignore: [profileDropdownBtn] }
];


//user.admin_role
</script>
<style>

</style>