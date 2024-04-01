import {defineStore} from "pinia";
import config from "@/config/auth";
import localAuth from "@/libraries/utils/clientapi/localAuth";
import {ref} from "vue";
import __has from "lodash/has";

export const useAuthStore = defineStore('auth',  () => {

    const user = ref(localAuth.getAuth());

    function hasAuth() {
        return localAuth.hasAuth();
    }

    function getAuth() {
        return localAuth.hasAuth() ? localAuth.getAuth() : null;
    }

    function setAuth(auth) {
        localAuth.setAuth(auth);
        user.value = auth;
    }

    function getAuthRole() {
        return localAuth.getAuthRole();
    }

    function getAuthId() {
        return localAuth.getAuthId();
    }

    function getPermissions() {
        return getAuth() ? user.value.permissions : [];
    }

    function isAdmin() {
        return localAuth.isAdmin();
    }

    function isSalesperson() {
        return localAuth.isSalesperson();
    }

    function isCustomer() {
        return localAuth.isCustomer();
    }

    function getLeadTableColumns() {
        let auth = getAuth();
        return auth ? (__has(auth, 'lead_table_columns') ? auth.lead_table_columns : null) : null;
    }

    function saveLeadTableColumns(columns) {
        return localAuth.saveLeadTableColumns(columns);
    }


    function getRoutes() {
        if (!hasAuth()) {
            return null;
        }
        if (isAdmin()) {
            return config.admin;
        }
        if (isSalesperson()) {
            return config.salesperson;
        }
        return config.customer;
    }

    function removeAuth() {
        localAuth.removeAuth();
    }

    function refreshAuthCookie() {
        localAuth.setAuthCookie();
    }

    return { user, getAuth, setAuth, hasAuth, getAuthRole, getAuthId,
        isAdmin, isSalesperson, isCustomer, getPermissions, getRoutes, removeAuth, refreshAuthCookie,
        getLeadTableColumns, saveLeadTableColumns
    };
});
