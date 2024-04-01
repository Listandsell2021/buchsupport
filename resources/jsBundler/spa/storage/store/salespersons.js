import {defineStore} from "pinia";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import {ref} from "vue";

export const useSalespersonsStore = defineStore('salespersons',  () => {

    const salespersons = ref([]);

    function getSalespersons() {
        return salespersons.value;
    }

    async function getSalespersonsByRefresh() {
        if (getSalespersons().length === 0) {
            await refreshSalespersons();
        }
        return getSalespersons();
    }

    function setSalespersons(value) {
        salespersons.value = value;
    }

    async function refreshSalespersons() {
        await axios.post(route('admin.salespersons.get_active')).then((response) => {
            if (response.status == 200) {
                setSalespersons(response.data.data);
            } else {
                setSalespersons([]);
            }
        });
    }

    return { salespersons, getSalespersons, setSalespersons, refreshSalespersons, getSalespersonsByRefresh };
});