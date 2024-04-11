import AxiosLib from 'axios';
import config from '@/config/app';
import authConfig from '@/config/auth';
import Cookies from "js-cookie";
import { useLoadingStore } from '@/storage/store/loading';
import { useAuthStore } from '@/storage/store/auth';
import {useAuth} from "@/composables/useAuth";
import Notifier from "@/libraries/utils/Notifier";
import qs from 'qs';
import __has from 'lodash/has';
import {useRouter} from "vue-router";

const axiosInstance = AxiosLib.create({
    baseURL: config.apiServerUrl,
    headers: {
        'X-Requested-With': 'XMLHttpRequest',
    },
    withCredentials: true,
});

// Request interceptor. Runs before your request reaches the server
const onRequest = (config) => {
    // If http method is `post | put | delete` and XSRF-TOKEN cookie is
    // not present, call '/sanctum/csrf-cookie' to set CSRF token, then
    // proceed with the initial response
    if (
        (
            config.method == 'post' ||
            config.method == 'put' ||
            config.method == 'delete'
            /* other methods you want to add here */
        ) &&
        !Cookies.get('XSRF-TOKEN')
    ) {
        return setCSRFToken().then(response => config);
    }
    return config;
}

// A function that calls '/api/csrf-cookie' to set the CSRF cookies. The
// default is 'sanctum/csrf-cookie' but you can configure it to be anything.
const setCSRFToken = () => {
    return axiosInstance.get('/sanctum/csrf-cookie'); // resolves to '/sanctum/csrf-cookie'.
}

// attach your interceptor
axiosInstance.interceptors.request.use(onRequest, (error) => {});

axiosInstance.interceptors.response.use(function (response) {
    return response;
}, async function (error) {

    if (__has(error, 'response') && error.response.status === 401) {

        const authStore = useAuthStore();
        const router = useRouter();

        let auth = useAuth('admin');
        let redirectUrl = authConfig.admin.loginUrl;


        if (authStore.getAuth()) {

            if (authStore.isCustomer()) {
                auth = useAuth('customer');
                redirectUrl = authConfig.customer.loginUrl;
            }

            await auth.fetchAndSetCurrentUser();

            if (!authStore.hasAuth()) {
                await authStore.removeAuth();
                Notifier.toastError('Unauthenticated request');
                window.location.href = redirectUrl;
                //await router.replace(redirectUrl);
            }
        }

    }

    return Promise.reject(error)
});

const axios = {

    loading()  {
        return useLoadingStore();
    },

    setLoading() {
        this.loading().setLoading();
    },

    removeLoading() {
        this.loading().removeLoading();
    },

    async get(endpoint, data = {}, config= {}, loader = false) {
        if (loader) {
            this.setLoading();
        }

        return await axiosInstance.get(`${endpoint}`, {
                ...{
                    params: data,
                    paramsSerializer: params => {
                        return qs.stringify(params)
                    }
                },
                ...config
            })
            .catch((error) => error.response)
            .then((response) => response)
            .finally(async () => {
                if (loader) {
                    this.removeLoading();
                }
            })
    },

    async post(endpoint, data = {}, config = {}, loader = false) {
        if (loader) {
            this.setLoading();
        }

        return await axiosInstance
            .post(`${endpoint}`, data, config)
            .then((response) => response)
            .catch((error) => {

                if (!__has(error, 'response')) {
                    return error;
                }
                if (error.response.status === 422) {
                    this.showValidationErrors(error);
                }
                if (error.response.status === 403) {
                    Notifier.toastError(error.response.data.message);
                }
                return error.response;
            })
            .finally(() => {
                if (loader) {
                    this.removeLoading();
                }
            })
    },

    async put(endpoint, data={}, config = {}, loader = false) {
        if (loader) {
            this.setLoading();
        }
        return await axiosInstance
            .put(`${endpoint}`, data, config)
            .then((response) => response)
            .catch((error) => {
                if (!__has(error, 'response')) {
                    return error;
                }
                if (error.response.status === 422) {
                    this.showValidationErrors(error);
                }
                if (error.response.status === 403) {
                    Notifier.toastError(error.response.data.message);
                }
                return error.response;
            })
            .finally(() => {
                if (loader) {
                    this.removeLoading();
                }
            });
    },

    async delete(endpoint, data = {}, headers = {}, loader = false) {
        if (loader) {
            this.setLoading();
        }
        return await axiosInstance
            .delete(`${endpoint}`, {
                headers: headers,
                data: data
            })
            .then((response) => response)
            .catch((error) => {
                if (!__has(error, 'response')) {
                    return error;
                }
                if (error.response.status === 422) {
                    this.showValidationErrors(error);
                }
                if (error.response.status === 403) {
                    Notifier.toastError(error.response.data.message);
                }
                return error.response;
            })
            .finally(() => {
               if (loader) {
                   this.removeLoading();
               }
            });
    },

    async postDownload(endpoint, data = {}, config = {}, loader = false) {
        if (loader) {
            this.setLoading();
        }
        return await axiosInstance
            .post(`${endpoint}`, data, {...config, ...{responseType: "blob"}})
            .then((response) => response)
            .catch((error) => {
                if (error.code == 'ERR_BAD_REQUEST') {
                    Notifier.toastError('Invalid Request');
                }
                if (!__has(error, 'response')) {
                    return error;
                }
                if (error.response.status === 422) {
                    this.showValidationErrors(error);
                }
                if (error.response.status === 403) {
                    Notifier.toastError(error.response.data.message);
                }
                return error.response;
            })
            .finally(() => {
                if (loader) {
                    this.removeLoading();
                }
            })
    },

    showValidationErrors(error) {
        const errors = error.response?.data?.errors;
        if (errors) {
            let message = "<ul>";
            for (let error of Object.values(errors)){
                message += "<li>"+((error[0] !== undefined) ? error[0] : '')+"</li>";
            }
            message += "</ul>";
            Notifier.toastError(message);
        }
    }
}

export default axios;