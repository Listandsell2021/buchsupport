<template>
    <div class="modal fade show modal-show" id="add-customer-modal" tabindex="-1" role="dialog">
        <div class="modal-dialog modal-lg" v-on-click-outside="onClickOutsideHandler">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">{{ $t('Add Customer') }}</h5>
                    <a href="#" @click.prevent="closeModal" class="close close-modal" data-dismiss="modal">
                        <span aria-hidden="true">&times;</span>
                    </a>
                </div>
                <div class="modal-body">
                    <Form @submit="createCustomerFromLead" v-slot="{errors}">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ $t('First name') }}</label>
                                    <Field class="form-control"
                                           v-model="form.first_name"
                                           type="text"
                                           name="first_name"
                                           rules="required"
                                           :placeholder="$t('Enter first name')"
                                           :class="{'is-invalid': errors.first_name}"
                                    />
                                    <ErrorMessage class="text-danger d-block" name="first_name"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ $t('Last name') }}</label>
                                    <Field class="form-control"
                                           v-model="form.last_name"
                                           type="text"
                                           name="last_name"
                                           :placeholder="$t('Enter last name')"
                                           rules="required"
                                           :class="{'is-invalid': errors.last_name}"
                                    />
                                    <ErrorMessage class="text-danger d-block" name="last_name"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ $t('Gender') }}</label>
                                    <Field class="form-select"
                                           name="gender"
                                           v-model="form.gender"
                                           as="select"
                                           rules="required"
                                           :class="{'is-invalid': errors.gender}"
                                    >
                                        <option value="">{{ $t('Select gender') }}</option>
                                        <option :value="key" v-for="(gender, key) in Genders">{{ $t(gender) }}</option>
                                    </Field>
                                    <ErrorMessage class="text-danger d-block" name="gender"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ $t('Phone no') }}</label>
                                    <Field class="form-control"
                                           v-model="form.phone_no"
                                           type="text"
                                           name="phone_no"
                                           :placeholder="$t('Enter phone no')"
                                           rules="required"
                                           :class="{'is-invalid': errors.phone_no}"
                                    />
                                    <ErrorMessage class="text-danger d-block" name="phone_no"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ $t('Street') }}</label>
                                    <Field class="form-control"
                                           v-model="form.street"
                                           type="text"
                                           name="street"
                                           :placeholder="$t('Enter street')"
                                           rules="required"
                                           :class="{'is-invalid': errors.street}"
                                    />
                                    <ErrorMessage class="text-danger d-block" name="street"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ $t('Postal Code') }}</label>
                                    <Field class="form-control"
                                           v-model="form.postal_code"
                                           type="number"
                                           name="postal_code"
                                           :placeholder="$t('Enter postal code')"
                                           rules="required"
                                           :class="{'is-invalid': errors.postal_code}"
                                    />
                                    <ErrorMessage class="text-danger d-block" name="postal_code"/>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ $t('City') }}</label>
                                    <Field class="form-control"
                                           v-model="form.city"
                                           type="text"
                                           name="city"
                                           :placeholder="$t('Enter city')"
                                           rules="required"
                                           :class="{'is-invalid': errors.city}"
                                    />
                                    <ErrorMessage class="text-danger d-block" name="city"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ $t('Country') }}</label>
                                    <BsSelect
                                        v-model="form.country"
                                        :options="countries"
                                        @update:model-value="updateCountry"
                                        :placeholder="$t('Select Country')"
                                    ></BsSelect>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ $t('Email') }}</label>
                                    <Field class="form-control"
                                           v-model="form.email"
                                           type="email"
                                           name="email"
                                           :placeholder="$t('Enter email')"
                                           rules="email"
                                           :class="{'is-invalid': errors.email}"
                                    />
                                    <ErrorMessage class="text-danger d-block" name="email"/>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>{{ $t('Date of birth') }}</label>
                                    <div>
                                        <BsDatePicker v-model:value="form.dob"
                                                      value-type="format"
                                                      format="DD.MM.YYYY"
                                                      placeholder="DD.MM.YYYY"
                                        ></BsDatePicker>
                                        <ErrorMessage class="text-danger d-block" name="dob"/>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary m-t-5">{{ $t('Create') }}</button>
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

const props = defineProps({
    lead: {
        required: true
    },
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
    lead_id: props.lead.id,
    first_name: props.lead.first_name,
    last_name: props.lead.last_name,
    gender: props.lead.gender,
    phone_no: props.lead.phone_no,
    street: props.lead.street,
    postal_code: props.lead.postal_code,
    city: props.lead.city,
    country: props.lead.country,
    email: props.lead.email,
    dob: props.lead.dob,
});


function createCustomerFromLead() {
    axios.post(route('admin.orders.create_customer'), form.value).then((response) => {
        if (response.status == 200) {
            Notifier.toastSuccess(response.data.message);
            closeModal();
            emit('refresh');
        }
    });
}

function updateCountry(country) {
    if (country == null) {
        form.value.country = '';
    }
}

function updatePassword(password) {
    form.value.password = password;
}

function changeActiveStatus(isActive) {
    form.value.is_active = isActive;
}

const onClickOutsideHandler = [
    (ev) => {
        if (HelperUtils.hasSomeParentTheClass(ev.target, 'mx-datepicker-main') ) return;

        closeModal();
    },
    { ignore: [] }
];

function closeModal() {
    emit('close');
}

onMounted(async () => {

})

</script>

<style scoped lang="scss">

</style>
