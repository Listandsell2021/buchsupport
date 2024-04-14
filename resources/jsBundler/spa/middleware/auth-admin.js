import Notifier from "@/libraries/utils/Notifier";
import {useAuthStore} from "@/storage/store/auth";
import {useServiceStore} from "@/storage/store/services";

export default async (to, from) => {

    await useServiceStore().refreshServices();
    const auth = useAuthStore();

    if (!auth.hasAuth() || !auth.isAdmin()) {
        Notifier.toastError('You are not logged in');
        return {path: "/admin/login"};
    }
}