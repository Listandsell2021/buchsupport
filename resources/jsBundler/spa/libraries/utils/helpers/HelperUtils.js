import ProductConditions from "@/storage/data/ProductConditions";
import __Has from 'lodash/has';
import moment from "moment/moment";
import Notifier from "@/libraries/utils/Notifier";

export default {

    truncate(text, stop = 30, clamp = '...') {
        return text.slice(0, stop) + (stop < text.length ? clamp : '')
    },

    copyText(text) {
        if (navigator.clipboard) {
            navigator.clipboard.writeText(text)
        } else {
            const textArea = document.createElement('textarea');
            textArea.value = text

            textArea.style.top = '0'
            textArea.style.left = '0'
            textArea.style.position = 'fixed'

            document.body.appendChild(textArea)
            textArea.focus()
            textArea.select()

            document.execCommand('copy')

            document.body.removeChild(textArea)
        }
    },

    isEmptyArray(array) {

        //If it's not an array, return FALSE.
        if (!Array.isArray(array)) {
            return false;
        }

        //If it is an array, check its length property
        if (array.length === 0) {
            return true;
        }

        //Otherwise, return FALSE.
        return false;
    },

    isNotNullOrEmpty(value) {
        if (value === null || value == '' || value == 0 ) {
            return false;
        }

        return true;
    },

    getSpacedIdent(id) {
        return String(id).replace(/\W/gi, '').replace(/(.{4})/g, '$1 ');
    },

    trimSpace(id) {
        return String(id).replace(/\s/g, '')
    },

    formatUserId(id) {
        return String(id).replace(/(.{4})/g, '$1 ').trim();
    },

    blobFileDownload(response, fileName) {
        const url = window.URL.createObjectURL(new Blob([response.data], { type: response.data.type }))
        const link = document.createElement('a')
        const contentDisposition = response.headers['Content-Disposition']

        if (contentDisposition) {
            let fileNameMatch = contentDisposition.match(/filename="(.+)"/)
            if (!fileNameMatch) {
                fileNameMatch = contentDisposition.match(/filename=(.+)/)
                if (fileNameMatch.length === 2) { fileName = fileNameMatch[1] }
            } else if (fileNameMatch.length === 2) { fileName = fileNameMatch[1] }
        }

        link.href = url
        link.setAttribute('download', fileName)
        document.body.appendChild(link)

        link.click()
        link.remove()
        window.URL.revokeObjectURL(url)
    },

    getCurrency(price, atFirst = 1) {
        return (atFirst ? '&euro; ' : ' ')+price + (!atFirst ? ' &euro;' : '');
    },

    getInvoiceCurrency(price) {
        return price+'&euro;';
    },

    getProductCondition(condition) {
        return __Has(ProductConditions, condition) ? ProductConditions[condition] : '';
    },

    ucfirst(string) {
        if (typeof string === 'string' || string instanceof String) {
            return string.charAt(0).toUpperCase() + string.slice(1);
        }
        return '';
    },

    setCookie(name, value, hours = 5) {
        let expires = "";
        if (hours) {
            let date = new Date();
            date.setTime(date.getTime() + (hours*60*60*1000));
            expires = "; expires=" + date.toUTCString();
        }
        document.cookie = name + "=" + (value || "")  + expires + "; path=/";
    },

    getCookie(name) {
        let nameEQ = name + "=";
        let ca = document.cookie.split(';');
        for(let i=0;i < ca.length;i++) {
            let c = ca[i];
            while (c.charAt(0)==' ') c = c.substring(1,c.length);
            if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
        }
        console.log('outside');
        return null;
    },

    removeCookie(name) {
        document.cookie = name +'=; Path=/; Expires=Thu, 01 Jan 1970 00:00:01 GMT;';
    },

    getInvoiceTemplate(template, templateStrings) {
        return template.replace(
            /{(\w*)}/g,
            function( m, key ){
                return templateStrings.hasOwnProperty(key) ? templateStrings[key] : "";
            }
        );
    },

    getDateTimeInGerman(date) {
        return moment(date).format('DD.MM.YYYY HH:mm');
    },

    getReadableDate(date) {
        let now = moment();
        let createdDate = moment(date);
        return moment.duration(createdDate.diff(now)).humanize(true);
    },

    getServerValidationErrors(error) {
        const errors = error.response?.data?.errors;
        let message = "";
        if (errors) {
            message += "<ul>";
            for (let error of Object.values(errors)){
                message += "<li>"+((error[0] !== undefined) ? error[0] : '')+"</li>";
            }
            message += "</ul>";
        }
        return message;
    }

}
