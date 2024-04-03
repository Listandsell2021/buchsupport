import {defineStore} from "pinia";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import {ref} from "vue";

export const useServiceStore = defineStore('services',  () => {

    const services = ref([]);

    function getServices() {
        return services.value;
    }

    async function getServicesByRefresh() {
        if (getServices().length === 0) {
            await refreshServices();
        }
        return getServices();
    }

    function setServices(value) {
        services.value = value;
    }

    async function refreshServices() {
        await axios.post(route('admin.services.all')).then((response) => {
            if (response.status == 200) {
                setServices(response.data.data);
            } else {
                setServices([]);
            }
        });
    }

    return { services, getServices, setServices, refreshServices, getServicesByRefresh };
});