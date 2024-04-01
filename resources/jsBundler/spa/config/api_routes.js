import appConfig from './app';
const adminUrl = appConfig.apiServerUrl+"/admin";

export default {

    admin: {
        admin_list: {
            url: adminUrl+"/admins",
            type: 'get',
        },
        admin_get: adminUrl+"/admins/:id",
    }

}