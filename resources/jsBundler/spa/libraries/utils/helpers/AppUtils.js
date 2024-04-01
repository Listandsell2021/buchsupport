import app from "@/config/app";


export default {

    getApiUrl(path = '') {
        return app.apiServerUrl+'/'+path;
    },

    getApiStorageUrl(path = '') {
        return app.apiServerUrl+'/storage/'+path;
    },

    getApiProductStorageUrl(path = '') {
        return app.apiServerUrl+'/storage/products/'+path;
    },

    getApiUserProfileStorageUrl(path = '') {
        return app.apiServerUrl+'/storage/user_profile/'+path;
    },

    getEmptyImageUrl() {
        return app.apiServerUrl+'/images/300_400.webp';
    },


};
