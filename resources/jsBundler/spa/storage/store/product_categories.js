import {defineStore} from "pinia";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import {ref} from "vue";

export const useProductCategoryStore = defineStore('product_categories',  () => {

    const product_categories = ref([]);

    function getCategories() {
        return product_categories.value;
    }

    async function getCategoriesByRefresh() {
        if (getCategories().length === 0) {
            await refreshCategories();
        }
        return getCategories();
    }

    function setCategories(value) {
        product_categories.value = value;
    }

    async function refreshCategories() {
        await axios.post(route('admin.product_categories.get_active')).then((response) => {
            if (response.status == 200) {
                setCategories(response.data.data);
            } else {
                setCategories([]);
            }
        });
    }

    return { product_categories, getCategories, setCategories, refreshCategories, getCategoriesByRefresh };
});