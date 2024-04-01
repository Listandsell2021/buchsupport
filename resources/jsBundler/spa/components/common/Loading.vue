<template>
    <div class="loader-container" v-if="store.loading">
        <div class="loader-box">
            <div class="loader-5"></div>
        </div>
    </div>
</template>
<script setup>
import { useLoadingStore } from '@/storage/store/loading';
const store = useLoadingStore();
</script>
<style>
</style>