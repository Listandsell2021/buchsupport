import {defineStore} from "pinia";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import {ref} from "vue";

export const useProductStore = defineStore('products',  () => {

    const products = ref([]);

    function getProducts() {
        return products.value;
    }

    async function getProductsByRefresh() {
        if (getProducts().length === 0) {
            await refreshProducts();
        }
        return getProducts();
    }

    function setProducts(value) {
        products.value = value;
    }

    async function refreshProducts() {
        await axios.post(route('admin.products.all')).then((response) => {
            if (response.status == 200) {
                setProducts(response.data.data);
            } else {
                setProducts([]);
            }
        });
    }

    return { products, getProducts, setProducts, refreshProducts, getProductsByRefresh };
});