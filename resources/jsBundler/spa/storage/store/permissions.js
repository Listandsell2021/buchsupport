import {defineStore} from "pinia";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import {ref} from "vue";

export const usePermissionStore = defineStore('permissions',  () => {

    const permissions = ref([]);

    function getPermissions() {
        return permissions.value;
    }

    async function getPermissionsByRefresh() {
        if (getPermissions().length === 0) {
            await refreshPermissions();
        }
        return getPermissions();
    }

    function setPermissions(value) {
        permissions.value = value;
    }

    async function refreshPermissions() {
        await axios.post(route('admin.roles.get_permissions')).then((response) => {
            if (response.status == 200) {
                setPermissions(response.data.data);
            } else {
                setPermissions([]);
            }
        });
    }

    return { permissions, getPermissions, setPermissions, refreshPermissions, getPermissionsByRefresh };
});