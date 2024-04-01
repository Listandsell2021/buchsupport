<template>
    <div>
        <div class="modal fade show" style="display: block;">
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
                                    <label for="first_name">Vorname</label>
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
                                    <label for="last_name">Nachname</label>
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
                                    <label for="email">E-Mail Adresse</label>
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
                                    <label for="telephone">Telefonnummer</label>
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
                                    <label for="price">Budget</label>
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
                                    <label for="terms">Nutzungsbedingungen</label>
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
        <div class="modal-backdrop fade show"></div>
    </div>
</template>

<script>
import BoostrapMixin from "../../../mixins/BoostrapMixin";
import vClickOutside from 'click-outside-vue3';

export default {

    props: {
        productId: {
            required: true
        },
        config: {
            required: true,
        }
    },

    components: {},

    mixins: [ BoostrapMixin ],

    data() {
        return {
            form: {
                productId: '',
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
        this.form.productId = this.productId;
    },

    directives: {
        clickOutside: vClickOutside.directive
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
                axios.post(this.config.bookInquiryUrl, this.form)
                    .then((response) => {
                        if (response.status == 200) {
                            this.$swal('Erfolgreich', 'Wir melden uns so schnell wie möglich!', 'success');
                        }
                    }).catch((error) => {
                    if (error.response.status == 422) {
                        this.$swal('Error', 'Etwas ist schief gelaufen. Bitte versuche es erneut', 'error');
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
