import {defineStore} from "pinia";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import {ref} from "vue";

export const useLeadStatusStore = defineStore('lead_status',  () => {

    const lead_status = ref([]);

    function getLeadStatus() {
        return lead_status.value;
    }

    async function getLeadStatusByRefresh() {
        if (getLeadStatus().length === 0) {
            await refreshLeadStatus();
        }
        return getLeadStatus();
    }

    function setLeadStatus(value) {
        lead_status.value = value;
    }

    async function refreshLeadStatus() {
        await axios.post(route('admin.leads.get_status')).then((response) => {
            if (response.status == 200) {
                setLeadStatus(response.data.data);
            } else {
                setLeadStatus([]);
            }
        });
    }

    return { lead_status, getLeadStatus, setLeadStatus, refreshLeadStatus, getLeadStatusByRefresh };
});