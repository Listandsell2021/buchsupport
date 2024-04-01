<template>
    <div class="modal fade show modal-show" id="add-customer-pipeline-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog" ref="modalDialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ $t('Add Customer') }}</h5>
                    <a href="#" @click.prevent="closeModal" class="close close-modal" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="">{{ $t('Customer') }}</label>
                        <BsSelect
                            :filterable="false"
                            v-model="form.user_id"
                            :options="customers"
                            :reduce="customer => customer.id"
                            label="name"
                            @search="searchCustomers"
                        >
                            <template #no-options="{ search, searching, loading }">
                                {{ (search.length > 0) && searching ? $t('No customers found') : $t('Search customers') }}
                            </template>
                        </BsSelect>
                    </div>
                    <div class="form-group">
                        <label for="">{{ $t('Pipeline') }}</label>
                        <BsSelect
                            v-model="form.pipeline_id"
                            :options="pipelines"
                            label="name"
                            :reduce="pipeline => pipeline.id"
                            :clearable="false"
                            :placeholder="$t('Select Pipeline')"
                        />
                    </div>
                    <div class="form-group">
                        <button class="btn btn-primary"
                                @click.prevent="addCustomerToPipeline"
                        >{{ $t('Add') }}</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {onMounted, ref} from "vue";
import { onClickOutside } from '@vueuse/core';
import axios from "@/libraries/utils/clientapi/axios";
import route from "@/libraries/utils/ZiggyRoute";
import Notifier from "@/libraries/utils/Notifier";
import __debounce from "lodash/debounce";

const props = defineProps({});

const emit = defineEmits(['close']);
const modalDialog = ref(null);
const customers = ref([]);
const pipelines =  ref([]);
const form = ref({
    user_id: '',
    pipeline_id: '',
});

function closeModal() {
    emit('close');
}

const searchCustomers = __debounce((search, loading) => {
    if(search.length) {
        loading(true);
        axios.post(route('admin.customers.search'), {
            name: search
        }).then((response) => {
            if (response.status === 200) {
                customers.value = response.data.data;
                form.value.user_id = '';
                loading(false);
            }
        });
    }
}, 500);


function getPipelines() {
    axios.post( route('admin.pipeline.all'))
        .then(response => {
            if (response.status === 200) {
                pipelines.value = response.data.data;
            }
        });
}

function addCustomerToPipeline() {
    axios.post( route('admin.pipeline.add_customer'), form.value )
        .then(response => {
            if (response.status === 200) {
                Notifier.toastSuccess(response.data.message);
                emit('refresh');
            }
        });
}

onClickOutside(modalDialog, () => {
    closeModal();
})

onMounted(() => {
    getPipelines();
})

</script>

<style scoped lang="scss">

</style>
