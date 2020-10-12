import dayjs from "dayjs";
import {truncate} from "@/partials/datatable";

export function date_format(date, format = "DD-MM-YYYY [at] hh:mm:ss A") {
    if (!date) {
        return "";
    }
    return dayjs(date).format(format);
}


export const getCurrencySymbol = (locale = "en-US", currency = "USD") => (0).toLocaleString(locale, {
    style: 'currency',
    currency,
    minimumFractionDigits: 0,
    maximumFractionDigits: 0
}).replace(/\d/g, '').trim();
export const localNumber = (value = 0, locale = _s('locale')) => Number(value).toLocaleString(locale)
export default {
    install(Vue) {
        Vue.prototype.dayjs = date_format;
        Vue.filter('localDateTime', (value = null, locale = _s('locale', 'en-US'), date_options = null, time_options = {
            hour: '2-digit',
            minute: '2-digit'
        }) => {
            if (!value) return "";
            let date = (typeof value === 'string') ? (new Date(value)) : (value);
            return date.toLocaleDateString(locale) + ' ' + date.toLocaleTimeString(locale, time_options);
        });
        Vue.filter('localDate', (value = null, locale = _s('locale', 'en-US'),  time_options = {
            hour: '2-digit',
            minute: '2-digit'
        }) => {
            if (!value) return "";
            let date = (typeof value === 'string') ? (new Date(value)) : (value);
            return date.toLocaleDateString(locale);
        });
        Vue.filter('localTime', (value = null, locale = _s('locale', 'en-US'), time_options = {
            hour: '2-digit',
            minute: '2-digit'
        }) => {
            if (!value) return "";
            let date = (typeof value === 'string') ? (new Date(value)) : (value);
            return date.toLocaleTimeString(locale, time_options);
        });
        Vue.filter('dayjs', date_format);
        Vue.filter('currency', (value = 0, currency = _s('currency', 'BDT'), locale = _s('locale', 'en-US')) => new Intl.NumberFormat(locale, {
            style: 'currency',
            currency: currency
        }).format(value));
        Vue.filter('truncate', (value = '', length = 30) => truncate(value || '', length));
        Vue.filter('currencySymbol', (locale = window._s('locale'), currency = window._s('currency')) => getCurrencySymbol(locale, currency));
        Vue.filter('localNumber', localNumber);
    }
};
