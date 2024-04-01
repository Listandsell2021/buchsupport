<template>
    <div class="input-password-group">
        <input type="password"
               id="password"
               class="form-control"
               :placeholder="$t('Enter password')"
               v-model="password"
               @input="passwordChanged"
               ref="passwordInput"
        />
        <div class="password-action-btn-list">
            <span @click="generateRandomPassword()" class="password-random-generator" v-if="props.generator">
                <i class="fa fa-refresh"></i>
            </span>
            <span @click="switchVisibility()" class="password-hider-icon">
                <i class="fa fa-eye"></i>
            </span>
        </div>
    </div>
</template>
<script setup>
import {onMounted, ref} from "vue";
import PasswordGenerator from "@/libraries/utils/helpers/PasswordGenerator";
import debounce from "lodash/debounce";

let emit = defineEmits(['change'])
let props = defineProps({
    initial: {
        default: '',
    },
    generator: {
        default: true,
    }
})

let password = ref("");
let passwordInput = ref(null);

function generateRandomPassword(length = 10) {
    password.value = PasswordGenerator.generate(length);
    emit('change', password.value);
}

function switchVisibility() {
    if (passwordInput.value.getAttribute('type') === 'password') {
        passwordInput.value.setAttribute('type', 'text')
    } else {
        passwordInput.value.setAttribute('type', 'password')
    }
}

const passwordChanged = debounce(() => {
    emit('change', password.value);
}, 500);

onMounted(() => {
    password.value = props.initial;
})

</script>
<style scoped>
.input-password-group {
    position: relative;
}
.input-password-group .form-control {
    padding-right: 35px;
}
.password-action-btn-list {
    background-color: #eee;
    border: 1px solid #eee;
    border-bottom-right-radius: 4px;
    border-top-right-radius: 4px;
    bottom: 0;
    color: #666;
    cursor: pointer;
    display: flex;
    font-size: 16px;
    line-height: 36px;
    position: absolute;
    right: 0;
    top: 0;
}
.password-hider-icon, .password-random-generator {
    padding-left: 8px;
    padding-right: 8px;
}
</style>