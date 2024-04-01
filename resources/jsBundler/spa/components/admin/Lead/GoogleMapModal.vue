<template>
    <div class="modal fade show modal-show" id="add-lead-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" ref="modalDialog">
            <div class="modal-content">
                <div class="modal-body">
                    <a href="#" @click.prevent="closeModal" class="close close-modal" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </a>
                    <GMapMap
                        ref="myMapMarker"
                        :center="center"
                        :zoom="15"
                        map-type-id="terrain"
                        style="height: 450px"
                    >
                        <GMapCluster :zoomOnClick="true">
                            <GMapMarker
                                :key="marker.id"
                                v-for="(marker) in markers"
                                :position="marker.position"
                                :clickable="true"
                                :draggable="true"
                                @click="openMarker(marker.id)"
                            >
                                <GMapInfoWindow
                                    :closeclick="true"
                                    @closeclick="openMarker(null)"
                                    :opened="openedMarkerId === marker.id"
                                >
                                    <div>{{ marker.name }}</div>
                                </GMapInfoWindow>
                            </GMapMarker>
                        </GMapCluster>
                    </GMapMap>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {onMounted, ref} from "vue";
import { onClickOutside } from '@vueuse/core';
import { useGeoLocationStore } from '@/storage/store/geolocation';
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import {useI18n} from "vue-i18n";
import {useRouter} from "vue-router";

const props = defineProps({
    form: {
        required: true,
    }
})

const emit = defineEmits(['close']);

const { t: $t } = useI18n();
const router = useRouter();
const modalDialog = ref(null);
const myMapMarker = ref(null);
const geoLocation = await useGeoLocationStore().getLocationByRefresh();
const center = ref(geoLocation);
const markers = ref([]);
const openedMarkerId = ref(null);

onClickOutside(modalDialog, () => {
    closeModal();
})

function loadLeadsLocation() {
    axios.post(route('admin.leads.locations'), props.form).then(response => {
        if (response.status === 200) {
            for(let lead of response.data.data) {
                markers.value.push({
                    position: {
                        lat: Number.parseFloat(lead.lat),
                        lng: Number.parseFloat(lead.lng)
                    },
                    name: lead.fullname,
                    id: lead.id
                });
            }
        }
    });
}

function closeModal() {
    emit('close');
}

function openMarker(markerId) {
    openedMarkerId.value = markerId
}

function locateGeoLocation() {
    markers.value.push({
        position: geoLocation,
        id: 0,
        name: 'Dhan Kumar Lama'
    });
}

onMounted(async () => {
    locateGeoLocation();
    loadLeadsLocation();
});

</script>

<style scoped lang="scss">

</style>
