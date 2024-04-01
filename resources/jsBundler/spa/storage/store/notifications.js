import {defineStore} from "pinia";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import {ref} from "vue";

export const useNotificationStore = defineStore('notifications',  () => {

    const notifications = ref([]);

    function getNotifications() {
        return notifications.value;
    }

    async function getNotificationsByRefresh(page = 1) {
        if (getNotifications().length === 0) {
            await refreshNotifications(page);
        }
        return getNotifications();
    }

    function setNotifications(value) {
        notifications.value = value;
    }

    async function refreshNotifications(page = 1) {
        await axios.post(route('admin.notifications.unread'), {
            page: page,
            per_page: 5
        })
            .then((response) => {
            if (response.status == 200) {
                setNotifications(response.data.data);
            } else {
                setNotifications([]);
            }
        });
    }


    return { notifications, getNotifications, setNotifications, refreshNotifications, getNotificationsByRefresh };
});