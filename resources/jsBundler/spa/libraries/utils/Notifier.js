import Swal from 'sweetalert2';
import {useI18n} from "vue-i18n";

export default {

    toastOptions: {
        toast: true,
        timerProgressBar: true,
        showCloseButton: true,
        showConfirmButton: false,
        position: 'top-end',
        customClass: {
            popup: 'colored-toast'
        },
    },

    toastSuccess(message, title= '', duration= 4000) {
        Swal.fire({
            title: title,
            html: message,
            //type: 'success',
            icon: 'success',
            timer: duration,
            ...this.toastOptions
        })
    },

    toastError(message, title= '', duration= 4000) {
        Swal.fire({
            title: title,
            html: message,
            timer: duration,
            //type: 'error',
            icon: 'error',
            ...this.toastOptions
        })
    },

    toastConfirm(title, message = '', callback = () => {}, confirmText = 'Yes', denyText = 'No') {
        Swal.fire({
            title: title,
            html: message,
            focusConfirm: false,
            showCloseButton: true,
            showCancelButton: false,
            showDenyButton: true,
            confirmButtonText: '<i class="fa fa-check"></i> '+confirmText,
            denyButtonText: '<i class="fa fa-close"></i> '+denyText,
        }).then(async (result) => {
            if (result.isConfirmed) {
                await callback();
                Swal.close();
            }
        })
    }

}