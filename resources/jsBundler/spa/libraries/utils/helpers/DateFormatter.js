import moment from 'moment';

export default {

    inGerman(date) {

        let newDate = date;

        if (typeof date === 'string') {
            newDate = new Date(date);
        }

        return moment(newDate).format('DD.MM.YYYY');
    },

    padLeadingZeros(num, size) {
        let s = num+"";
        while (s.length < size) s = "0" + s;
        return s;
    }

}
