import {defineStore} from "pinia";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import {ref} from "vue";

export const useSalespersonCommissionStore = defineStore('commissions',  () => {

    const commissions = ref({
        labels: [],
        datasets: [
            {
                data: [],
            },
        ],
    });

    function getCommissions() {
        return commissions.value;
    }

    async function getCommissionsByRefresh(requestData = {}) {
        if (getCommissions().length === 0) {
            await refreshCommissions(requestData);
        }
        return getCommissions();
    }

    function setCommissions(value) {
        commissions.value = value;
    }

    async function refreshCommissions(requestData = {}) {
        await axios.post(route('admin.salespersons.commission_graph'), requestData)
            .then((response) => {
                if (response.status == 200) {
                    setCommissions(response.data.data);
                } else {
                    setCommissions([]);
                }
        });
    }

    return { commissions, getCommissions, setCommissions, refreshCommissions, getCommissionsByRefresh };
});