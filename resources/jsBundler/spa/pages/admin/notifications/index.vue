<template>
    <div>

        <Breadcrumbs :menu-items="breadcrumbConfig.notification.list()" :title="$t('Notifications')"/>

        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">

                    <div class="panel">
                        <ul class="dropdown-list-items p-0">
                            <li>
                                <a href="#"
                                   class="notification-tab-link clearfix"
                                   :class="{ 'active': showTab === 'all' }"
                                   @click.prevent="changeTab('all')"
                                >
                                    <span class="title">
                                        <i class="fa fa-inbox fa-lg m-r-10"></i>
                                        {{ $t('All') }}
                                    </span>
                                    <span class="badge pull-right">({{ notifications.total }})</span>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                   class="notification-tab-link clearfix"
                                   :class="{ 'active': showTab === 'unread' }"
                                   @click.prevent="changeTab('unread')"
                                >
                                    <span class="title">
                                        <i class="fa fa-envelope-o fa-lg m-r-10"></i>
                                        {{ $t('Unread') }}
                                    </span>
                                    <span class="badge pull-right">({{ unreadNotifications.total }})</span>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                   class="notification-tab-link clearfix"
                                   :class="{ 'active': showTab === 'read' }"
                                   @click.prevent="changeTab('read')"
                                >
                                    <span class="title">
                                        <i class="fa fa-envelope-open-o fa-lg m-r-10"></i>
                                        {{ $t('Read') }}
                                    </span>
                                    <span class="badge pull-right">({{ readNotifications.total }})</span>
                                </a>
                            </li>
                        </ul>
                    </div>

                </div>
                <div class="col-md-9">
                    <div class="card">
                        <div class="card-body">

                            <div class="tab-content" id="setting-tab-content">

                                <div class="tab-pane fade show active" v-if="showTab === 'all'">

                                    <div class="notification-section">
                                        <div class="notification-header clearfix"
                                             v-if="hasAllNotifications()"
                                        >
                                            <a class="pull-right mark-all"
                                               href="#"
                                               @click.prevent="markAllNotificationsAsRead(getAllNotificationIds())"
                                            >{{ $t('Mark all read') }}</a>
                                        </div>

                                        <ul class="dropdown-list-items p-0" v-if="hasAllNotifications()">
                                            <li class="notification-item"
                                                :key="notification.id"
                                                v-for="notification in notifications.data"
                                            >
                                                <NotificationItem :notification="notification"></NotificationItem>
                                            </li>
                                        </ul>

                                        <div class="alert alert-danger no-notifications" v-else>
                                            {{ $t('No notifications') }}
                                        </div>

                                        <div class="m-t-40">
                                            <PaginationBar
                                                :data="notifications"
                                                @change="getAllNotifications"
                                            ></PaginationBar>
                                        </div>
                                    </div>

                                </div>

                                <div class="tab-pane fade show active" v-if="showTab === 'unread'">

                                    <div class="notification-section">

                                        <div class="notification-header clearfix"
                                             v-if="hasUnreadNotifications()"
                                        >
                                            <a class="pull-right mark-all"
                                               href="#"
                                               @click.prevent="markAllNotificationsAsRead(getUnreadNotificationIds())"
                                            >{{ $t('Mark all read') }}</a>
                                        </div>

                                        <ul class="dropdown-list-items p-0"
                                            v-if="hasUnreadNotifications()"
                                        >
                                            <li class="notification-item"
                                                :key="notification.id"
                                                v-for="notification in unreadNotifications.data"
                                            >
                                                <NotificationItem :notification="notification"></NotificationItem>
                                            </li>
                                        </ul>

                                        <div class="alert alert-danger no-notifications" v-else>
                                            {{ $t('No unread notifications') }}
                                        </div>

                                        <div class="m-t-40">
                                            <PaginationBar
                                                :data="unreadNotifications"
                                                @change="getUnreadNotifications"
                                            ></PaginationBar>
                                        </div>
                                    </div>

                                </div>

                                <div class="tab-pane fade show active" v-if="showTab === 'read'">

                                    <div class="notification-section">

                                        <ul class="dropdown-list-items p-0"
                                            v-if="hasReadNotifications()"
                                        >
                                            <li class="notification-item"
                                                :key="notification.id"
                                                v-for="notification in readNotifications.data"
                                            >
                                                <NotificationItem :notification="notification"></NotificationItem>
                                            </li>
                                        </ul>

                                        <div class="alert alert-danger no-notifications" v-else>
                                            {{ $t('No read notifications') }}
                                        </div>

                                        <div class="m-t-40">
                                            <PaginationBar
                                                :data="readNotifications"
                                                @change="getReadNotifications"
                                            ></PaginationBar>
                                        </div>
                                    </div>

                                </div>

                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>
<script setup>
import {onMounted, ref} from "vue";
import axios from '@/libraries/utils/clientapi/axios';
import breadcrumbConfig from "@/storage/data/breadcrumbs";
import route from '@/libraries/utils/ZiggyRoute';
import PaginationBar from "@/components/widgets/form/PaginationBar";
import HelperUtils from "@/libraries/utils/helpers/HelperUtils";
import NotificationItem from "@/components/admin/Notification/NotificationItem";
import Notifier from "@/libraries/utils/Notifier";
import {useI18n} from "vue-i18n";
import {useRouter} from "vue-router";
import {useMeta} from "vue-meta";


const router = useRouter();
const { t: $t } = useI18n();
useMeta({title: $t('Notifications')});

const showTab = ref('all');
const notifications = ref({data: [], total: 0});
const readNotifications = ref({data: [], total: 0});
const unreadNotifications = ref({data: [], total: 0});


function getAllNotifications(page = 1) {

    axios.post(route('admin.notifications.all'), {page: page}, {}, true).then(response => {
        if (response.status === 200) {
            notifications.value = response.data.data;
        }
    });
}

function getUnreadNotifications(page = 1) {

    axios.post(route('admin.notifications.unread'), {
        page: page
    }).then(response => {
        if (response.status === 200) {
            unreadNotifications.value = response.data.data;
        }
    });
}

function getReadNotifications(page = 1) {

    axios.post(route('admin.notifications.read'), {
        page: page
    }).then(response => {
        if (response.status === 200) {
            readNotifications.value = response.data.data;
        }
    });
}

function markNotificationAsRead(notificationId, reload = 'all') {
    axios.post(route('admin.notifications.mark_read'), {
        notification_ids: [notificationId],
    }).then((response) => {
        if (response.status === 200) {
            getAllNotifications();
            getReadNotifications();
            getUnreadNotifications();
        }
    });
}

function markAllNotificationsAsRead(notificationIds) {
    axios.post(route('admin.notifications.mark_read'), {
        notification_ids: notificationIds,
    }).then((response) => {
        if (response.status === 200) {
            getAllNotifications();
            getReadNotifications();
            getUnreadNotifications();
        }
    });
}

function getAllNotificationIds() {
    return notifications.value.data.map((notification) => notification.id);
}

function getUnreadNotificationIds() {
    return unreadNotifications.value.data.map((notification) => notification.id);
}

function getReadNotificationIds() {
    return readNotifications.value.data.map((notification) => notification.id);
}

function hasAllNotifications() {
    return notifications.value.data.length > 0;
}

function hasUnreadNotifications() {
    return unreadNotifications.value.data.length > 0;
}

function hasReadNotifications() {
    return readNotifications.value.data.length > 0;
}

function changeTab(tab) {
    showTab.value = tab;
}

onMounted(async () => {
    getAllNotifications();
    getUnreadNotifications();
    getReadNotifications();
})

</script>