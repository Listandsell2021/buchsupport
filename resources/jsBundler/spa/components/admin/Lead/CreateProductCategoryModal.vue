<template>

    <div class="modal fade show modal-show" id="create-product-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-body">
                    <a href="#" @click.prevent="closeModal" class="close close-modal" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </a>

                    <h5 class="m-b-30">{{ $t('Create Product Category') }}</h5>

                    <div class="row">
                        <div class="col-md-12">
                            <div class="form-group">
                                <label>{{ $t('Name') }}</label>
                                <input class="form-control"
                                       v-model="form.name"
                                       type="text"
                                       name="name"
                                       :placeholder="$t('Enter name')"
                                />
                            </div>
                            <div class="form-group">
                                <label>{{ $t('Status') }}</label>
                                <StatusSwitcher :is_active="form.is_active"
                                                @toggle="changeActiveStatus"
                                ></StatusSwitcher>
                            </div>
                        </div>
                    </div>

                    <button @click.prevent="createCategory()"
                            class="btn btn-primary"
                    >{{ $t('Create') }}</button>
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
import StatusSwitcher from "@/components/widgets/form/StatusSwitcher";
import {useI18n} from "vue-i18n";
import {useRouter} from "vue-router";


const emit = defineEmits(['close', 'reload-products']);
const props = defineProps({
    leadId: {
        required: true
    }
});

const { t: $t } = useI18n()
const router = useRouter();

const form = ref({
    name: '',
    is_active: 0,
    lead_id: props.leadId
});

function createCategory() {
    axios.post(route('admin.leads.create_product_category'), form.value).then((response) => {
        if (response.status == 201) {
            Notifier.toastSuccess(response.data.message);
            closeModalAndReload();
        }
    });
}

function changeActiveStatus(isActive) {
    form.value.is_active = isActive;
}


function closeModal() {
    emit('close');
}

function closeModalAndReload() {
    emit('close');
    emit('reload-products');
}

onMounted(async () => {

})

</script>

<style scoped lang="scss">

</style>
