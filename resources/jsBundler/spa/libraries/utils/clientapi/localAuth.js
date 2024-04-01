import config from "@/config/auth";
import HelperUtils from "@/libraries/utils/helpers/HelperUtils";
import { useStorage } from '@vueuse/core';
import __is_Object from 'lodash/isObject';
import __has from 'lodash/has';



export default {

    authKey: 'laravel_auth_key',
    authCookieKey: 'laravel_auth_cookie',

    hasAuth() {
        let auth = this.getAuth();

        if (auth == null) {
            return false;
        }

        if (!__is_Object(auth) && __has(auth, 'id')) {
            return false;
        }

        if ((typeof this.getAuthCookie()) == 'undefined') {
            return false;
        }

        return this.getAuthCookie();
    },

    getAuth() {
        let auth = localStorage.getItem(this.authKey);

        if (auth == null) {
            return null;
        }

        auth = JSON.parse(auth);

        if (!__is_Object(auth)) {
            return null;
        }

        if (!__has(auth, 'id')) {
            return null;
        }

        return auth;
    },

    setAuth(auth)  {
        this.setAuthCookie();
        localStorage.setItem(this.authKey, JSON.stringify(auth));
    },

    setAuthCookie() {
        HelperUtils.setCookie(this.authCookieKey, true);
    },

    getAuthCookie() {
        return HelperUtils.getCookie(this.authCookieKey);
    },

    getAuthRole() {
        if (this.hasAuth()) {
            return __has(this.getAuth(), 'auth_role') ? this.getAuth().auth_role : '';
        }
        return '';
    },

    getAuthId() {
        if (this.hasAuth()) {
            return __has(this.getAuth(), 'id') ? this.getAuth().id : '';
        }
        return '';
    },

    getPermissions() {
        return this.hasAuth() ? this.getAuth().permissions : [];
    },

    isAdmin() {
        return (this.getAuthRole() === config.admin_role) || (this.getAuthRole() === config.super_admin_role);
    },

    isSalesperson() {
        return this.getAuthRole() === config.salesperson_role;
    },

    isCustomer() {
        return this.getAuthRole() === config.customer_role;
    },

    getRoutes() {
        if (!this.hasAuth()) {
            return null;
        }
        if (this.isAdmin()) {
            return config.admin;
        }
        if (this.isSalesperson()) {
            return config.salesperson;
        }
        return config.customer;
    },

    removeAuth() {
        HelperUtils.removeCookie(this.authCookieKey);
        localStorage.setItem(this.authKey, JSON.stringify(null));
    },

    saveLeadTableColumns(columns) {
        let auth = this.getAuth();
        if (auth) {
            auth.lead_table_columns = columns;
            this.setAuth(auth);
            return true;
        }
        return false;
    }
};
