<template>
    <div class="modal fade show modal-show" id="order-shipment-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" v-on-click-outside="onClickOutsideHandler">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ $t('Update Order Shipment') }}</h5>
                    <a href="#" @click.prevent="closeModal" class="close close-modal" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="shipment_no">{{ $t('Shipment no') }}</label>
                        <input type="text" class="form-control" v-model="form.shipment_no"/>
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary"
                                @click.prevent="updateOrderShipment"
                        >{{ $t('Update') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {onMounted, ref} from "vue";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import Notifier from "@/libraries/utils/Notifier";
import {useI18n} from "vue-i18n";
import {useRouter} from "vue-router";
import { vOnClickOutside } from '@vueuse/components';

const props = defineProps({
    orderId: {
        required: true,
    }
});
const emit = defineEmits(['close', 'refresh']);
const router = useRouter();
const { t: $t } = useI18n();

const modalDialog = ref(null);
const form = ref({
    order_id: props.orderId,
    shipment_no: '',
});


function updateOrderShipment() {
    axios.post(route('admin.orders.update_shipment_no'), form.value).then((response) => {
        if (response.status == 200) {
            Notifier.toastSuccess(response.data.message);
            closeModal();
            emit('refresh');
        }
    });
}

const onClickOutsideHandler = [(ev) => closeModal(), { ignore: [] }];

function closeModal() {
    emit('close');
}

onMounted(async () => {

})

</script>

<style scoped lang="scss">

</style>
