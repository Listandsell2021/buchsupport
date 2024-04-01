<template>
    <div class="p-t-45">
        <div class="row">
            <div class="col-12 col-md-7">

                <div class="custom__card">
                    <div class="custom__card--body profile__Updater">
                        <h5 class="font-20 thin">ID: {{ HelperUtils.getSpacedIdent(form.uid) }}</h5>
                        <hr>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="firstName" class="thin">Vorname</label>
                                    <input type="text"
                                           id="firstName"
                                           placeholder="Vorname"
                                           class="form-control mb-2"
                                           v-model="form.first_name"
                                    />
                                </div>

                                <div class="form-group">
                                    <label for="lastName" class="thin">Nachname</label>
                                    <input type="text"
                                           id="lastName"
                                           placeholder="Nachname"
                                           class="form-control mb-2"
                                           v-model="form.last_name"
                                    />
                                </div>

                                <div class="form-group">
                                    <label class="thin">Neues Passwort</label>
                                    <a href="#" class="button-reset" @click.prevent="openPasswordEditor">
                                        <span class="thin m-r-10">Passwort ändern:</span>
                                        <span class="">
                                            <i class="fa fa-edit"></i>
                                            <span></span>
                                        </span>
                                    </a>

                                    <PasswordEditor @close="closePasswordEditor"
                                                    v-if="passwordEditor"
                                                    :user_id="user.id"
                                    ></PasswordEditor>
                                </div>

                                <div class="form-group">
                                    <label class="thin">Geburtstag *</label>
                                    <div>
                                        <BsDatePicker v-model:value="form.dob"
                                                      value-type="format"
                                                      format="DD.MM.YYYY"
                                                      placeholder="DD.MM.YYYY"
                                        ></BsDatePicker>
                                    </div>
                                </div>
                            </div>


                            <div class="col-md-6">

                                <div class="form-group">
                                    <label for="street" class="thin">Adresse</label>
                                    <input type="text"
                                           id="street"
                                           placeholder="Straße Hausnummer"
                                           class="form-control mb-2"
                                           v-model="form.street"
                                    />
                                </div>

                                <div class="form-group">
                                    <label for="city" class="thin">Stadt</label>
                                    <input type="text"
                                           id="city"
                                           class="form-control mb-2"
                                           v-model="form.city"
                                    />
                                </div>

                                <div class="form-group">
                                    <label for="postal_code" class="thin">Zip</label>
                                    <input type="text"
                                           id="postal_code"
                                           class="form-control mb-2"
                                           v-model="form.postal_code"
                                    />
                                </div>

                                <div class="form-group">
                                    <label class="thin">Anrede</label>
                                    <div>
                                        <input type="radio"
                                               name="gender"
                                               id="female"
                                               :value="Genders.female"
                                               class="m-r-5"
                                               v-model="form.gender"
                                        />
                                        <label for="female" class="m-r-25">Frau</label>

                                        <input type="radio"
                                               name="gender"
                                               id="male"
                                               :value="Genders.male"
                                               class="m-r-5"
                                               v-model="form.gender"
                                        />
                                        <label for="male">Herr</label>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <StatusSwitcher :is_active="showSecondaryName"
                                        class=""
                                        @toggle="toggleSecondaryNameField($event)"
                        ></StatusSwitcher>


                        <div class="row" v-if="showSecondaryName">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="secondary_first_name">{{ $t('Secondary First Name') }}</label>
                                    <input type="text"
                                           v-model="form.secondary_first_name"
                                           class="form-control"
                                           id="secondary_first_name"
                                    />
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="secondary_last_name">{{ $t('Secondary Last Name') }}</label>
                                    <input type="text"
                                           v-model="form.secondary_last_name"
                                           class="form-control"
                                           id="secondary_last_name"
                                    />
                                </div>
                            </div>
                        </div>


                    </div>
                    <div class="custom__card--action action-bottom-right">
                        <button class="btn btn-primary"
                                @click.prevent="updateUserProfile"
                        ><i class="fa fa-save m-r-10"></i> {{ $t('Update') }}
                        </button>
                    </div>
                </div>

            </div>

            <div class="col-md-5">
                <div class="user__update-dz-row m-b-45">
                    Profilbild hier ablegen

                    <BsDropzone ref="dropzoneUploader"
                                id="dropzone"
                                class="editable-dropzone"
                                :destroy-dropzone="false"
                                v-on:vdropzone-file-added="uploadUserImage"
                                :options="{
                                    url: 'https://httpbin.org/post',
                                    autoProcessQueue: false,
                                    maxFiles: 1,
                                    addRemoveLinks: true,
                                    headers: {},
                                    dictRemoveFile: 'Entferne Bild',
                                    dictDefaultMessage: 'Bilder zum Hochladen hier ablegen',
                                }"
                    />

                </div>
                <div class="user__Image__Show" v-if="form.image_path">
                    <figure>
                        <img :src="AppUtils.getApiUserProfileStorageUrl(form.id+'/'+form.image_path)"
                             :alt="form.image_path">
                    </figure>
                </div>

            </div>

        </div>

    </div>
</template>
<script setup>
import {onMounted, ref} from "vue";
import route from '@/libraries/utils/ZiggyRoute';
import axios from '@/libraries/utils/clientapi/axios';
import StatusSwitcher from "@/components/widgets/form/StatusSwitcher";
import Genders from "@/storage/data/genders";
import PasswordEditor from "@/components/customer/profile/PasswordEditor";
import Notifier from "@/libraries/utils/Notifier";
import BtModalHelper from "@/libraries/utils/BtModalHelper";
import AppUtils from "@/libraries/utils/helpers/AppUtils";
import HelperUtils from "@/libraries/utils/helpers/HelperUtils";
import {useAuth} from "@/composables/useAuth";
import {useMeta} from "vue-meta";
import {useI18n} from "vue-i18n";
import PasswordGenerator from "@/libraries/utils/helpers/PasswordGenerator";

const {t: $t} = useI18n();
useMeta({ title: $t('Customer Profile') });
const props = defineProps({
    data: {
        type: Object,
        required: true
    }
});

const {user, isLoggedIn, setUser} = useAuth('customer');
const dropzoneUploader = ref(null);

const form = ref(props.data);

let showSecondaryName = ref(false);
let passwordEditor = ref(false);

function getUserDetail() {
    axios.get(route('customer.profile.get_detail'), {user_id: user.id}, {}, true)
        .then(response => {
            if (response.status === 200) {
                form.value = response.data;
            }
        });
}


function updateUserProfile() {
    axios.post(route('customer.profile.update'), form.value).then(response => {
        if (response.status === 200) {
            setUser(response.data.data);
            Notifier.toastSuccess(response.data.message);
        }
    });
}


function toggleSecondaryNameField(data) {
    showSecondaryName.value = data;
}

function openPasswordEditor() {
    BtModalHelper.open();
    passwordEditor.value = true;
}

function closePasswordEditor() {
    passwordEditor.value = false;
    BtModalHelper.close();
}

function uploadUserImage(image) {
    let formData = new FormData();

    formData.append('user_id', user.id);
    formData.append('image', image);

    axios.post(route('customer.profile.upload_image'), formData)
        .then(async (response) => {
        if (response.status === 200) {
            Notifier.toastSuccess(response.data.message);
            await getUserDetail();
            removeFileFromDropzone();

        }
    });
}

function removeFileFromDropzone() {
    dropzoneUploader.value.removeAllFiles()
}

onMounted(async () => {

})

</script>