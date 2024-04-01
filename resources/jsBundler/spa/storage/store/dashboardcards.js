import {defineStore} from "pinia";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import {ref} from "vue";

export const useDashboardSummaryStore = defineStore('dashboard_summary',  () => {

    const cards = ref([]);

    function getCards() {
        return cards.value;
    }

    async function getCardsByRefresh() {
        await refreshCards();
        /*if (getCards().length === 0) {
            await refreshCards();
        }
        return getCards();*/
    }

    function setCards(value) {
        cards.value = value;
    }

    async function refreshCards() {
        await axios.post(route('admin.dashboard.cards'), {}, {}, true).then((response) => {
            if (response.status == 200) {
                setCards(response.data.data);
            } else {
                setCards([]);
            }
        });
    }

    return { cards, getCards, setCards, refreshCards, getCardsByRefresh };
});