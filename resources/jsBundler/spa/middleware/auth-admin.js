import Notifier from "@/libraries/utils/Notifier";
import {useAuthStore} from "@/storage/store/auth";

export default (to, from) => {

    const auth = useAuthStore();

    if (!auth.hasAuth() || !auth.isAdmin()) {
        Notifier.toastError('You are not logged in');
        return { path: "/admin/login" };
    }
}