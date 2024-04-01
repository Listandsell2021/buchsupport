<template>
    <li class="">
        <div class="notification-box">
            <a href="#"
               @click.prevent="toggleNotification"
               ref="notificationBtn"
            >
                <svg>
                    <use href="/assets/frontend/svg/icon-sprite.svg#notification"></use>
                </svg>
            </a>
            <span class="badge rounded-pill badge-secondary">{{ countNotifications() }}</span>
        </div>
        <div class="notification-dropdown dropdown-menu dropdown-menu-right"
             :class="{ show: showNotification }"
             v-on-click-outside="closeNotification"
        >
            <div class="notification-header clearfix">
                <h5 class="pull-left notification-main-title">{{ $t('Notifications') }}</h5>
                <a class="pull-right mark-all"
                   href="#"
                   v-if="hasNotifications()"
                   @click.prevent="markAllNotificationsAsRead"
                >{{ $t('Mark all read') }}</a>
            </div>

            <div class="bs-notification-list">
                <template v-if="hasNotifications()">
                    <div class="bsn-list-item"
                         v-for="notification in useNotificationStore().notifications.data"
                         :key="notification.id"
                    >

                        <NotificationItem :notification="notification"
                                          class="nav-notification"
                        ></NotificationItem>

                    </div>
                </template>

                <div class="bsn-list-item" v-else>
                    <div class="bs-notification-box">
                        <div class="notification-desc">{{ $t('No notifications') }}</div>
                    </div>
                </div>

                <div class="bsn-list-footer clearfix">
                    <a href="#" @click.prevent="goToNotification()" class="bsn-view-all pull-right">
                        <span>{{ $t('View All') }}</span>
                    </a>
                </div>
            </div>

            <Bootstrap5Pagination :data="useNotificationStore().notifications.data"
                                  class="m-l-25"
                                  @pagination-change-page="pageChanged"
                                  :limit="2"
            ></Bootstrap5Pagination>
        </div>

    </li>
</template>

<script setup>
import {ref} from "vue";
import { vOnClickOutside } from '@vueuse/components';
import { useNotificationStore } from '@/storage/store/notifications';
import { Bootstrap5Pagination } from 'laravel-vue-pagination';
import axios from "@/libraries/utils/clientapi/axios";
import Notifier from "@/libraries/utils/Notifier";
import route from '@/libraries/utils/ZiggyRoute';
import NotificationItem from "@/components/admin/Notification/NotificationItem";
import router from "@/router";


const notificationBtn = ref(null);
let showNotification = ref(false);

await useNotificationStore().refreshNotifications();

function toggleNotification() {
    showNotification.value = !showNotification.value;
}

function createNewCustomer(data, notificationId) {
    axios.post(route('admin.leads.approve_new_customer'), {
        lead_id: data.lead_id,
    })
        .then((response) => {
            if (response.status === 200) {
                markNotificationAsRead(notificationId);
                Notifier.toastSuccess(response.data.message);
            }
        });
}

function markNotificationAsRead(notificationId) {
    axios.post(route('admin.notifications.mark_read'), {
        notification_ids: [notificationId],
    }).then((response) => {
        if (response.status === 200) {
            useNotificationStore().refreshNotifications();
        }
    });
}

function markAllNotificationsAsRead() {
    axios.post(route('admin.notifications.mark_read'), {
        notification_ids: useNotificationStore().notifications.data.map((notification) => notification.id),
    }).then((response) => {
        if (response.status === 200) {
            useNotificationStore().refreshNotifications();
        }
    });
}

function pageChanged(page = 1) {
    useNotificationStore().refreshNotifications(page);
}

function countNotifications() {
    return useNotificationStore().notifications.total;
}

function hasNotifications() {
    return countNotifications() > 0;
}

function goToNotification() {
    showNotification.value = false;
    return router.push('/admin/notifications');
}

const closeNotification = [
    () => {
        showNotification.value = false;
    },
    { ignore: [notificationBtn] }
];

</script>
