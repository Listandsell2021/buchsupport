<template>
    <div class="media" :class="props.class">
        <div class="media-left">
            <div class="media-object">
                <img class="avatar-img" src="/assets/customer/images/avatar.png" alt="avatar">
            </div>
        </div>
        <div class="media-body">
            <div class="notification-desc">
                <template v-if="isNewCustomerRequest()">
                    <router-link :to="'/admin/leads/'+props.notification.data.lead_id"
                               class="notification-link"
                    >
                        <div v-html="props.notification.description"></div>
                    </router-link>
                </template>
                <template v-else>
                    <div v-html="props.notification.description"></div>
                </template>

                <template v-if="!props.notification.has_read">
                    <a href="#"
                       class="btn-n-mark"
                       @click.prevent="markNotificationAsRead(notification.id)"
                    >
                        <i class="fa fa-check"></i>
                    </a>
                </template>
            </div>

            <div class="notification-date">{{ HelperUtils.getReadableDate(props.notification.created_at) }}</div>
        </div>
    </div>
</template>
    
<script setup>
import {ref} from "vue";
import notificationSetting from "@/storage/data/notificationSetting";
import { useNotificationStore } from '@/storage/store/notifications';
import HelperUtils from "@/libraries/utils/helpers/HelperUtils";;
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';

const props = defineProps({
    notification: {
        required: true
    },
    class: {
        default: '',
    }
});

function isNewCustomerRequest() {
    return props.notification.type === notificationSetting.types.lead_new_customer;
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

</script>
    