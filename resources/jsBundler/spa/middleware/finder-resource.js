import {useApiFetch} from "@/composables/useApiFetch";
import __has from "lodash/has";
import {isArray} from "lodash";
import {useLoadingStore} from "@/storage/store/loading";

export default async (url, to) => {

    useLoadingStore().setLoading();

    const { error, data } = await useApiFetch(url);

    let pathInArray = to.path.substring(1).split('/');

    if (__has(to, 'matched') && isArray(to.matched) && to.matched.length > 0) {
        if (__has(to.matched[0], 'name') && to.matched[0].name === 'admin_section') {
            pathInArray.shift();
        }
    }

    useLoadingStore().removeLoading();

    if (error.value) {
        return {
            name: 'NotFound',
            params: { pathMatch: pathInArray },
            query: to.query,
            hash: to.hash,
        }
    }
    to.meta.data = data
}
