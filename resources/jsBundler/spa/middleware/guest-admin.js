import Notifier from "@/libraries/utils/Notifier";
import {useAuthStore} from "@/storage/store/auth";

export default (to, from) => {

    const auth = useAuthStore();

    if (auth.hasAuth()) {
        if (auth.isAdmin()) {
            Notifier.toastSuccess('Already logged in');
            return { path: "/admin/dashboard" };
        }
    }
}
