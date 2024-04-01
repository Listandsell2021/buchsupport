import appConfig from '@/config/app';
import { useFetch } from '@vueuse/core';
import Cookies from "js-cookie";

export const useApiFetch = (url: string, opts: any) => {

    const xsrfToken = Cookies.get('XSRF-TOKEN')

    let headers = {
        accept: 'application/json',
        ...opts?.headers,
    }

    if (xsrfToken && xsrfToken.value !== null) {
        headers['X-XSRF-TOKEN'] = xsrfToken;
    }

    return useFetch(url, {
        baseURL: appConfig.apiServerUrl,
        headers,
        credentials: 'include',
        ...opts,
    }).get().json();
}