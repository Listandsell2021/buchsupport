<template>
    <span class="badge badge-success" v-if="is_active">{{ $t(active_text) }}</span>
    <template v-else>
        <span class="badge badge-danger"
              v-if="!hide_inactive"
        >{{ inactive_text }}</span>
    </template>
</template>
<script setup>

const props = defineProps({
    is_active: {
        required: true,
    },
    active_text: {
        default: 'Active'
    },
    inactive_text: {
        default: 'Inactive',
    },
    hide_inactive: {
        default: 0,
    }
})


</script>