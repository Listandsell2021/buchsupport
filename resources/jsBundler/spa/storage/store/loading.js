import {defineStore} from "pinia";
import {ref} from "vue";

export const useLoadingStore = defineStore('loading', () => {
    const loading = ref(false)

    function setLoading() {
        loading.value = true;
    }

    function removeLoading() {
        loading.value = false;
    }

    return { loading, setLoading, removeLoading };
})