<template>
    <div>
        <slot v-if="hasPermission()"></slot>
    </div>
</template>

<script setup>
import {ref} from "vue";
import {onMounted} from "vue";
import {useAuth} from "@/composables/useAuth";

const props = defineProps({
    permission: {
        type: String,
        default: '',
    },
});

let auth = useAuth('admin');

function hasPermission() {
    return auth.hasPermission(props.permission);
}

onMounted(async () => {

})

</script>

<style scoped lang="scss">

</style>
