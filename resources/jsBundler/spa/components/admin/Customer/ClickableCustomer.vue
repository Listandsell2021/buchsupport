<template>
    <template v-if="props.user">
        <router-link :to="'/admin/customers/'+props.user.id">
            {{ props.user.first_name+" "+props.user.last_name }}
        </router-link>
    </template>
    <template v-else>-</template>
</template>
<script setup>

const props = defineProps({
    user: {
        default: null
    }
});

</script>