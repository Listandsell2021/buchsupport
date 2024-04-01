<template>
    <div class="ls-edit-section">
        <div class="clearfix">
            <h6 class="m-b-20 pull-left">{{ $t('Edit Lead Status') }}</h6>
            <a class="pull-right" href="#" @click.prevent="closeEditSection"><i class="fa fa-remove"></i></a>
        </div>
        <div class="form-group">
            <label for="name">{{ $t('Name') }}</label>
            <input type="text" class="form-control form-control-sm" v-model="form.name" id="name"/>
        </div>
        <div class="form-group">
            <label for="code">{{ $t('Code') }}</label>
            <input type="text" class="form-control form-control-sm" v-model="form.code" id="code"/>
        </div>
        <div class="form-group">
            <label for="default">{{ $t('Default') }}</label>
            <StatusSwitcher :is_active="form.default"
                            @toggle="setDefaultStatus"
                            :key="generateRandomString()"
            ></StatusSwitcher>
        </div>
        <div class="clearfix ls-edit-btn">
            <button class="btn btn-danger btn-sm pull-left"
                    @click.prevent="resetForm"
            ><i class="fa fa-refresh m-r-5"></i> {{ $t('Reset') }}</button>
            <button class="btn btn-primary btn-sm pull-right" @click.prevent="updateLeadStatus">
                <i class="fa fa-save m-r-5"></i> {{ $t('Update') }}
            </button>
        </div>


    </div>
</template>

<script setup>
import {onMounted, ref} from "vue";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import Notifier from "@/libraries/utils/Notifier";
import StatusSwitcher from "@/components/widgets/form/StatusSwitcher";
import PasswordGenerator from "@/libraries/utils/helpers/PasswordGenerator";
import { useLeadStatusStore } from "@/storage/store/lead_status";

const props = defineProps({
    leadStatus: {
        required: true
    }
});

const emit = defineEmits(['refresh', 'close']);


let form = ref({
    id: props.leadStatus.id,
    name: props.leadStatus.name,
    code: props.leadStatus.code,
    default: props.leadStatus.default,
});

function updateLeadStatus() {
    axios.post(route('admin.lead_status.update'), form.value)
        .then((response) => {
            if (response.status === 200) {
                Notifier.toastSuccess(response.data.message);
                emit('refresh');
                emit('close');
                useLeadStatusStore().refreshLeadStatus();
            }
    });
}


function setDefaultStatus(status) {
    form.value.default = status;
}

function generateRandomString() {
    return PasswordGenerator.generate(6);
}

function resetForm() {
    form.value = {
        id: props.leadStatus.id,
        name: props.leadStatus.name,
        code: props.leadStatus.code,
        default: props.leadStatus.default,
    };
}


function closeEditSection() {
    emit('close');
}

onMounted(async () => {

})

</script>

<style scoped lang="scss">

</style>
