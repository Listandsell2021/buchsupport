<template>
    <div class="p-t-30">
        <div class="container-fluid">
            <div class="card">
                <div class="card-body">
                    <FullCalendar id="calendar" :options="calendarOptions"/>
                </div>
            </div>
        </div>
    </div>
</template>
<script setup>
import {onMounted, ref} from "vue";
import axios from '@/libraries/utils/clientapi/axios';
import FullCalendar from "@fullcalendar/vue3";
import dayGridPlugin from '@fullcalendar/daygrid'
import route from '@/libraries/utils/ZiggyRoute';
import moment from "moment";
import {useI18n} from "vue-i18n";
import {useRouter} from "vue-router";
import deLocale from '@fullcalendar/core/locales/de';
import enLocale from '@fullcalendar/core/locales/en-gb';
import {useMeta} from "vue-meta";


const router = useRouter();
const {t: $t} = useI18n()
useMeta({title: $t('Birthday Calendar')});

const calendarOptions = ref({
    plugins: [dayGridPlugin],
    locales: [ deLocale, enLocale ],
    locale: 'de',
    initialView: "dayGridMonth",
    eventSources: [
        {
            events(date, callback) {
                axios.post(route('admin.customers.birthdays'), {
                    start: moment(date.start).format('YYYY-MM-DD'),
                    end: moment(date.end).format('YYYY-MM-DD')
                }, {}, true)
                    .then(response => {
                        callback(response.data.data);
                    })
            },
        },
    ],
    eventClick: (info) => {
        router.push('/admin/customers/' + info.event._def.extendedProps.customer_id)
        //info.event._def.extendedProps.customer_id
    },
    editable: true,
    dayMaxEvents: true,
    headerToolbar: {
        left: "prev,next",
        center: "title",
        right: "dayGridMonth",
    },
});


onMounted(async () => {

})

</script>