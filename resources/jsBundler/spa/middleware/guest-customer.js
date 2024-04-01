import Notifier from "@/libraries/utils/Notifier";
import {useAuthStore} from "@/storage/store/auth";

export default (to, from) => {

    const auth = useAuthStore();

    if (auth.getAuth()) {
        if (auth.isCustomer()) {
            Notifier.toastSuccess('Already logged in');
            return { path: "/customer/dashboard" };
        }
    }

}
