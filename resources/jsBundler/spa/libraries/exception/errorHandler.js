import {useRoute, useRouter} from "vue-router";


export default {

    async showError404() {
        await useRouter().push({
            name: 'NotFound',
            params: {pathMatch: useRoute().path.substring(1).split('/')},
            query: useRoute().query,
            hash: useRoute().hash,
        });
         //window.location.href = '/admin/404';
        //return useRouter().replace('/admin/404');
    },

}