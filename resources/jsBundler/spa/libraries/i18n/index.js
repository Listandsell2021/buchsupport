import {createI18n} from "vue-i18n";
import messages from '@/config/translations';
import appConfig from '@/config/app';

export default createI18n({
    legacy: false,
    locales: ['en', 'de'],
    locale: appConfig.appLocale,
    messages: messages
});