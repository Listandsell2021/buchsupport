<template>
    <div class="p-t-30">

        <div class="row widget-grid">

            <WelcomeCard></WelcomeCard>

            <InfoCards></InfoCards>

            <SalespersonGraph v-if="false"></SalespersonGraph>

        </div>

    </div>
</template>
<script setup>
import {onMounted} from "vue";
import WelcomeCard from "@/components/admin/Dashboard/WelcomeCard";
import InfoCards from "@/components/admin/Dashboard/InfoCards";
import SalespersonGraph from "@/components/admin/Dashboard/SalespersonGraph";
import {useAuth} from "@/composables/useAuth";
import { useMeta } from 'vue-meta';
import {useI18n} from "vue-i18n";

const {user, isLoggedIn} = useAuth('admin');
const {t: $t} = useI18n()
useMeta({title: $t('Admin Dashboard')});

onMounted(async () => {

})

</script>