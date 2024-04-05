<template>
    <span v-html="getCurrency(amount)"></span>
</template>
<script setup>

const props = defineProps({
    amount: {
        required: true
    },
});

function getCurrency(price, atFirst = 1) {
    return (atFirst ? '&euro; ' : ' ')+price + (!atFirst ? ' &euro;' : '');
}

</script>
<style>
</style>