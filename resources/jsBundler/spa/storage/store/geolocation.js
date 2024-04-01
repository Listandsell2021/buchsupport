import {defineStore} from "pinia";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import {ref} from "vue";

export const useGeoLocationStore = defineStore('geolocation',  () => {

    const location = ref({
        lng: 0,
        lat: 0,
    });
    let isNavigated = ref(false);

    function getLocation() {
        return location.value;
    }

    function hasNavigated() {
        return isNavigated.value;
    }

    async function getLocationByRefresh() {
        if (!hasNavigated()) {
            await refreshLocation();
        }
        return getLocation();
    }

    function setLocation(value) {
        location.value = value;
    }

    async function refreshLocation(callable) {

        if (!navigator.geolocation) {
            alert('Google map not supported');
            return;
        }

        if (hasNavigated()) {
            callable();
            return;
        }

        await navigator.geolocation.getCurrentPosition(res => {
            setLocation({
                lat: res.coords.latitude,
                lng: res.coords.longitude
            });
            isNavigated.value = true;
            callable();
        },error => {
            console.log(error.message);
        });
    }


    return { isNavigated, location, hasNavigated, getLocation, setLocation, refreshLocation, getLocationByRefresh };
});