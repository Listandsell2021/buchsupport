import {defineStore} from "pinia";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import {ref} from "vue";

export const useMembershipStore = defineStore('memberships',  () => {

    const memberships = ref([]);

    function getMemberships() {
        return memberships.value;
    }

    async function getMembershipsByRefresh() {
        if (getMemberships().length === 0) {
            await refreshMemberships();
        }
        return getMemberships();
    }

    function setMemberships(value) {
        memberships.value = value;
    }

    async function refreshMemberships() {
        await axios.post(route('admin.customers.memberships')).then((response) => {
            if (response.status === 200) {
                setMemberships(response.data.data);
            } else {
                setMemberships([]);
            }
        });
    }

    return { memberships, getMemberships, setMemberships, refreshMemberships, getMembershipsByRefresh };
});