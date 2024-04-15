<template>
    <div class="modal fade show modal-show" id="add-customer-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" v-on-click-outside="onClickOutsideHandler">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ $t('Edit Order') }}</h5>
                    <a href="#" @click.prevent="closeModal" class="close close-modal" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <div class="modal-body">
                    <Form @submit="updateOrder" v-slot="{errors}">

                        <div class="form-group">
                            <label>{{ $t('Customer') }}</label>
                            <div class="row">
                                <div class="col-md-12">
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
                            </div>
                        </div>

                        <div class="form-group">
                            <label>{{ $t('Salesperson') }}</label>
                            <div class="row">
                                <div class="col-md-12">
                                    <BsSelect
                                        v-model="form.admin_id"
                                        :options="salespersons"
                                        :reduce="salesperson => salesperson.id"
                                        label="fullname"
                                        @update:model-value="updateSalesperson"
                                        :placeholder="$t('Select salesperson')"
                                    />
                                </div>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label>{{ $t('Service') }}</label>
                                    <BsSelect
                                        class=""
                                        v-model="form.service_id"
                                        :options="useServiceStore().services"
                                        label="name"
                                        :reduce="service => service.id"
                                        :clearable="false"
                                        @update:model-value="updateService"
                                        :placeholder="$t('Select Service')"
                                    ></BsSelect>
                                </div>
                                <div class="form-group">
                                    <label for="document" class="m-b-0">{{ $t('Contract Document') }}</label>
                                    <div class="m-b-10"><a href="#">{{ props.order.document }}</a></div>
                                    <div>
                                        <input type="file"
                                               value=""
                                               placeholder="Document"
                                               ref="documentFile"
                                               @change="updateDocument"
                                        />
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label>{{ $t('Quantity') }}</label>
                                    <Field class="form-control"
                                           v-model="form.quantity"
                                           type="number"
                                           name="quantity"
                                           rules="required"
                                           :placeholder="$t('Enter quantity')"
                                           :class="{'is-invalid': errors.quantity}"
                                    />
                                    <ErrorMessage class="text-danger d-block" name="quantity"/>
                                </div>
                                <div class="form-group">
                                    <label>{{ $t('Price') }}</label>
                                    <Field class="form-control"
                                           v-model="form.price"
                                           type="number"
                                           name="price"
                                           rules="required"
                                           :placeholder="$t('Enter price')"
                                           :class="{'is-invalid': errors.price}"
                                    />
                                    <ErrorMessage class="text-danger d-block" name="name"/>
                                </div>
                                <div class="form-group">
                                    <label>{{ $t('Note') }}</label>
                                    <textarea class="form-control"
                                              v-model="form.note"
                                              name="note"
                                              rows="4"
                                              :placeholder="$t('Enter note')"
                                    ></textarea>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary">{{ $t('Update') }}</button>
                    </Form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import {onMounted, ref} from "vue";
import { Form, Field, ErrorMessage } from 'vee-validate';
import { countryList as countries } from "@/storage/data/countrylist";
import axios from "@/libraries/utils/clientapi/axios";
import route from '@/libraries/utils/ZiggyRoute';
import Notifier from "@/libraries/utils/Notifier";
import Genders from "@/storage/data/genders";
import {useI18n} from "vue-i18n";
import {useRouter} from "vue-router";
import { vOnClickOutside } from '@vueuse/components';
import VisiblePasswordInput from "@/components/widgets/form/VisiblePasswordInput.vue";
import HelperUtils from "@/libraries/utils/helpers/HelperUtils";
import {useServiceStore} from "@/storage/store/services";
import __debounce from "lodash/debounce";
import {useSalespersonsStore} from "@/storage/store/salespersons";

const props = defineProps({
    order: {
        required: true,
    }
});
const emit = defineEmits(['close', 'refresh']);
const router = useRouter();
const { t: $t } = useI18n();

const customers = ref([
    {
        id: props.order.user.id,
        name: props.order.user.first_name+" "+props.order.user.last_name,
    }
]);
const salespersons = await useSalespersonsStore().getSalespersonsByRefresh();
const modalDialog = ref(null);

const form = ref({
    id: props.order.id,
    admin_id: props.order.admin_id,
    user_id: props.order.user_id,
    service_id: props.order.service_id,
    quantity: props.order.quantity,
    price: props.order.price,
    note: props.order.note,
    document: '',
});

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

function updateService(serviceId) {
    if (serviceId == null) {
        form.value.service_id = '';
    }
}

function updateSalesperson(salepersonId) {
    if (salepersonId == null) {
        form.value.admin_id = '';
    }
}

function updateDocument(event) {
    form.value.document = event.target.files[0];
}

function updateOrder() {
    let formData = new FormData();
    formData.append('order_id', form.value.id);
    formData.append('user_id', form.value.user_id);
    formData.append('admin_id', form.value.admin_id);
    formData.append('document', form.value.document);
    formData.append('service_id', form.value.service_id);
    formData.append('price', form.value.price);
    formData.append('quantity', form.value.quantity);
    formData.append('note', form.value.note);

    axios.post(route('admin.orders.update'), formData).then((response) => {
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
