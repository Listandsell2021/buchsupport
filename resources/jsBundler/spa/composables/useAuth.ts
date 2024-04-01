import axios from '@/libraries/utils/clientapi/axios';
import authConfig from '@/config/auth';
import Notifier from "@/libraries/utils/Notifier";
import { useAuthStore } from "@/storage/store/auth";
import i18n from '@/libraries/i18n';
import {useRouter} from "vue-router";
import {useApiFetch} from "@/composables/useApiFetch";
import __has from 'lodash/has';

//import localAuth from "@/libraries/utils/clientapi/localAuth";

export type AuthConfig = {
    loginUrl: string;
    logoutUrl: string;
    registerUrl: string;
    emailVerificationUrl: string;
    forgotPasswordUrl: string;
    resetPasswordUrl: string;
    fetchUserUrl: string;

    redirectAfterLoginUrl: string;
    redirectAfterLogoutUrl: string;
};

export type LoginCredentials = {
    email: string;
    password: string;
};

export type RegisterCredentials = {
    name: string;
    email: string;
    password: string;
    password_confirmation: string;
};

export type ResetPasswordCredentials = {
    email: string;
    password: string;
    password_confirmation: string;
    token: string;
};


export const useAuth = (userType: "admin" | "salesperson" | "customer") => {

    const { t: trans } = i18n.global;

    let config = authConfig.customer;

    if (userType == 'admin') {
        config = authConfig.admin;
    }

    if (userType == 'salesperson') {
        config = authConfig.salesperson;
    }

    const auth = useAuthStore();

    const user = auth.getAuth();

    const isLoggedIn = auth.hasAuth();

    const router = useRouter();

    async function refresh() {
        try {
            if (!isLoggedIn) {
                // @ts-ignore
                setUser(await fetchCurrentUser());
            }
        } catch {
            setUser(null);
        }
    }

    async function login(credentials: LoginCredentials) {

        if (isLoggedIn) {
            let authType = 'Customer';
            if (auth.isAdmin()) {
                authType = trans('Admin');
                Notifier.toastSuccess(authType+' '+trans('Already logged in'));
                return;
            }
            if (auth.isCustomer()) {
                authType = trans('Customer');
                Notifier.toastSuccess(authType+' '+trans('Already logged in'));
                return;
            }
        }

        return await axios.post(config.loginUrl, credentials)
            .then(async (response) => {
                if (response.status == 204) {
                    await refresh();
                    Notifier.toastSuccess(trans('Logged in successfully'));
                    await router.replace(config.redirectAfterLoginUrl);
                }
            });
    }

    async function register(credentials: RegisterCredentials) {
        await axios.post(config.registerUrl, credentials);
        await refresh();
    }

    async function resendEmailVerification() {
        return axios.post(config.emailVerificationUrl);
    }

    async function logout() {

        if (!isLoggedIn) return;

        await axios.post(config.logoutUrl).then((response) => {
            Notifier.toastSuccess(trans('Logged out successfully'));
            auth.removeAuth();
            router.replace(config.redirectAfterLogoutUrl);
        }).catch((error) => {
            Notifier.toastError(error?.response?.data?.message ?? trans('Could not log out'));
        });
    }

    async function forgotPassword(email: string) {
        return await axios.post(config.forgotPasswordUrl, {email: email});
    }

    async function resetPassword(credentials: ResetPasswordCredentials) {
        return axios.post(config.resetPasswordUrl, credentials);
    }

    async function fetchCurrentUser() {
        /*return await axios.get(config.fetchUserUrl).then((response) => {
            return response.data;
        }).catch((error) => {
            return null;
        });*/

        let { data } = await useApiFetch(config.fetchUserUrl);

        if (__has(data.value, 'id')) {
            return data.value;
        }

        return null;
    }

    async function fetchAndSetCurrentUser() {
        // @ts-ignore
        setUser(await fetchCurrentUser());
    }

    function getUser() {
        return auth ? (typeof auth.getAuth() === 'object' ? (__has(auth.getAuth(), 'id') ? auth.getAuth() : null) : null) : null;
    }

    function setUser(user: null | object) {
        auth.setAuth(user);
    }

    function getPermissions(): string[] {
        return auth.getPermissions();
    }

    function hasPermission(permission: string[] | string) {
        if(Array.isArray(permission))
            { // @ts-ignore
                return auth.getPermissions().some(i => permission.includes(i))
            }
        else
            return auth.getPermissions().includes(permission)
    }

    function getAuthRole() {
        return auth.getAuthRole();
    }

    function isAdmin() {
        return auth.isAdmin();
    }

    function isSalesPerson() {
        return auth.isSalesperson();
    }

    function isCustomer() {
        return auth.isCustomer();
    }

    return {
        user,
        isLoggedIn,
        getPermissions,
        hasPermission,
        getUser,
        setUser,
        login,
        register,
        resendEmailVerification,
        logout,
        forgotPassword,
        resetPassword,
        refresh,
        fetchCurrentUser,
        fetchAndSetCurrentUser,
        getAuthRole,
        isAdmin,
        isSalesPerson,
        isCustomer,
    };
};


export async function fetchCurrentUser(config: AuthConfig) {
    return await axios.get(config.fetchUserUrl).then((response) => {
        return response.data;
    }).catch((error) => {
        return null;
    });
}
