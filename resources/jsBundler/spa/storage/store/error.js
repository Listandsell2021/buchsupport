import {defineStore} from "pinia";
import {ref} from "vue";

export const useErrorPageStore = defineStore('error_page', () => {

    const error = ref(null)

    function getErrorPage() {
        return error.value;
    }

    async function setErrorPage(code) {
        error.value = code;
    }

    function removeErrorPage() {
        error.value = null;
    }

    return { error, getErrorPage, setErrorPage, removeErrorPage };
})