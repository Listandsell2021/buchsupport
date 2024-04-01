<template>
    <div class="modal fade show ms-overlap">
        <div class="modal-dialog">
            <div class="modal-content" v-click-outside="closeModal">
                <div class="modal-header">
                    <h5 class="modal-title">Anfrageformular</h5>
                    <button @click.prevent="closeModal" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body inquiry-form">
                    <div class="alert alert-danger" v-if="showError">
                        Bitte alle Felder ausfüllen
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="first_name">Vorname *</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" id="first_name" v-model="form.first_name" class="form-control"
                                       placeholder=""/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="last_name">Nachname *</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" id="last_name" v-model="form.last_name" class="form-control"
                                       placeholder=""/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="email">E-Mail Adresse *</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" id="email" v-model="form.email" class="form-control"
                                       placeholder=""/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="telephone">Telefonnummer *</label>
                            </div>
                            <div class="col-md-8">
                                <input type="text" id="telephone" v-model="form.phone" class="form-control"
                                       placeholder=""/>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="telephone">Budget *</label>
                            </div>
                            <div class="col-md-8">
                                <input type="number" id="price" v-model="form.price" class="form-control"
                                       placeholder=""/>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-4">
                                <label for="terms">Nutzungsbedingungen*</label>
                            </div>
                            <div class="col-md-8">
                                <input type="checkbox" id="terms" v-model="form.terms">
                                <div>
                                    Ich habe die Nutzungsbedinungen und
                                    <a :href="config.dataProtectionUrl" target="_blank">Datenschutzerklärung</a> gelesen und
                                    bin damit einverstanden.
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="row">
                            <div class="col-md-8 offset-md-4">
                                <button class="btn btn-primary" @click.prevent="sendInquiry">Weiter →</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import Swal from 'sweetalert2';
import vClickOutside from 'click-outside-vue3';

export default {

    props: {
        productId: {
            required: true
        },
        customerId: {
            required: true,
        },
        config: {
            required: true,
        }
    },

    components: {},

    mixins: [],

    directives: {
        clickOutside: vClickOutside.directive
    },

    data() {
        return {
            form: {
                productId: '',
                userId: '',
                first_name: '',
                last_name: '',
                phone: '',
                price: '',
                email: '',
                terms: false,
            },
            showError: false,
        }
    },

    mounted() {

        this.form.userId = this.customerId;
        this.form.productId = this.productId;

    },

    methods: {

        closeModal() {
            this.$emit('close-modal');
        },

        sendInquiry() {
            if (
                !this.isEmptyField(this.form.first_name) &&
                !this.isEmptyField(this.form.last_name) &&
                !this.isEmptyField(this.form.email) &&
                !this.isEmptyField(this.form.phone) &&
                this.form.terms == 1
            ) {
                axios.post(this.config.guestInquiryUrl, this.form)
                    .then((response) => {
                        if (response.status == 200) {
                            Swal.fire('Erfolgreich', 'Wir melden uns so schnell wie möglich!', 'success');
                        }
                    }).catch((error) => {
                    if (error.response.status == 422) {
                        Swal.fire('Error', 'Etwas ist schief gelaufen. Bitte versuche es erneut', 'error');
                    }
                }).then((response) => {
                    this.closeModal();
                });
                return;
            }
            this.showError = true;
        },

        isEmptyField(input) {
            return input.length === 0;
        }

    }
}

</script>

<style></style>
