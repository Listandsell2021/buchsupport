<template>
    <template v-if="props.lead">
        <router-link :to="'/admin/leads/'+props.lead.id">
            {{ showId ? props.lead.id : (props.lead.first_name+" "+props.lead.last_name) }}
        </router-link>
    </template>
    <template v-else>-</template>
</template>
<script setup>

const props = defineProps({
    lead: {
        default: null
    },
    showId: {
        default: false,
    }
});

</script>