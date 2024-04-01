import {integer} from "@vee-validate/rules";

export default {

    frontend: {
        home: "/",
        showroom: '/sammlung',
        login: '/login',
        imprint: '/impressum',
        data_protection: "/datenschutz",
        books: (id, query = '') => {
            return '/books/' + id + (query !== '' ? '?'+query : '');
        },
        libraries: (id, query) => {
            return '/libraries/' + id + (query !== '' ? '?'+query : '');
        }
    }

}