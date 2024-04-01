<template>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4">
                            <BsDatePicker
                                v-model:value="datePicker"
                                @change="updateSalespersonGraphData"
                                type="date"
                                range
                                :placeholder="$t('Select date range')"
                            ></BsDatePicker>
                        </div>
                        <div class="col-md-4">
                            <BsSelect
                                class="v-select-sm"
                                v-model="salespersonIds"
                                :options="salespersons"
                                label="fullname"
                                multiple
                                :reduce="salesperson => salesperson.id"
                                :clearable="false"
                                @update:model-value="updateSalesperson"
                                :placeholder="$t('Select Salesperson')"
                            ></BsSelect>
                        </div>
                    </div>

                    <LineChart ref="chartRef"
                               :chart-data="useSalespersonCommissionStore().commissions"
                               :options="options"
                    />
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {ref} from "vue";
import {onMounted} from "vue";
import { LineChart } from "vue-chart-3";
import { useSalespersonCommissionStore } from "@/storage/store/commission-chart-data";
import { useSalespersonsStore } from '@/storage/store/salespersons';
import moment from "moment";
import Notifier from "@/libraries/utils/Notifier";

const datePicker = ref(null);
const chartRef = ref();
const salespersonIds = ref([]);
const salespersons = await useSalespersonsStore().getSalespersonsByRefresh();

const options = {
    responsive: true,
    maintainAspectRatio: false,
    scales: {
        y: {
            ticks: {
                callback: function(value, index, values) {
                    return Number(value).toLocaleString("es-ES", {minimumFractionDigits: 2});
                    //return new Intl.NumberFormat('de-DE').format(value);
                }
            },
            beginAtZero: true,
        }
    },
    plugins: {
        tooltip: {
            callbacks: {
                label: function(context, data) {
                    let label = context.dataset.label || '';

                    if (label) {
                        label += ': ';
                    }
                    if (context.parsed.y !== null) {
                        label += new Intl.NumberFormat('de-DE', { style: 'currency', currency: 'EUR' }).format(context.parsed.y);
                    }
                    return label;
                }
            }
        }
    }

};

async function updateSalespersonGraphData() {
    await useSalespersonCommissionStore().refreshCommissions({
        date_from: Array.isArray(datePicker.value) ? moment(datePicker.value[0]).format('YYYY-MM-DD') : '',
        date_to: Array.isArray(datePicker.value) ? moment(datePicker.value[1]).format('YYYY-MM-DD') : '',
        salesperson_ids: salespersonIds.value,
    })
}

async function updateSalesperson(id) {

    if (id === null) {
        salespersonIds.value = '';
    }

    await updateSalespersonGraphData();
}


onMounted(async () => {
    await useSalespersonCommissionStore().refreshCommissions();
});

</script>

<style>
</style>