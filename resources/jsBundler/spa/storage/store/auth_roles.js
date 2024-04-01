import {defineStore} from "pinia";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import {ref} from "vue";

export const useAuthRoleStore = defineStore('auth_roles',  () => {

    const roles = ref([]);

    function getRoles() {
        return roles.value;
    }

    async function getRolesByRefresh() {
        if (getRoles().length === 0) {
            await refreshRoles();
        }
        return getRoles();
    }

    function setRoles(value) {
        roles.value = value;
    }

    async function refreshRoles() {
        await axios.post(route('admin.admins.auth_roles')).then((response) => {
            if (response.status == 200) {
                setRoles(response.data.data);
            } else {
                setRoles([]);
            }
        });
    }

    return { roles, getRoles, refreshRoles, getRolesByRefresh };
});