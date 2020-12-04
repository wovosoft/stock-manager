import j2FD from "@/partials/jsonToFormData";

import startCase from "bootstrap-vue/esm/utils/startcase";
import {isObject} from "bootstrap-vue/esm/utils/object";

import {toInteger, toFixed, toFloat} from "bootstrap-vue/esm/utils/number";

/**
 * Remove null , undefined and empty elements from Array.
 * @param items Array
 * @returns {*}
 */


export function compact(items) {
    return items.filter(item => (item !== null && item !== undefined && "" !== (isString(item) ? item.trim() : item)));
}

/**
 * @example obj2Table(object, ['column1','column2'])
 * @param items Object of the Data
 * @param skip Array Columns to be skipped / rejected
 * @param as
 * @returns {Array}
 */
export function obj2Table(items, skip = [], as = {key: 'key', value: 'value'}) {
    let output = [];
    for (let x in items) {
        if (!skip.includes(x)) {
            let ret = {};
            ret[as['key']] = x;
            ret[as['value']] = items[x];
            output.push(ret);
        }
    }
    return output;
}

export function isValidURL(str) {
    let pattern = new RegExp('^((ft|htt)ps?:\\/\\/)?' + // protocol
        '((([a-z\\d]([a-z\\d-]*[a-z\\d])*)\\.)+[a-z]{2,}|' + // domain name and extension
        '((\\d{1,3}\\.){3}\\d{1,3}))' + // OR ip (v4) address
        '(\\:\\d+)?' + // port
        '(\\/[-a-z\\d%@_.~+&:]*)*' + // path
        '(\\?[;&a-z\\d%@_.,~+&:=-]*)?' + // query string
        '(\\#[-a-z\\d_]*)?$', 'i'); // fragment locator
    return pattern.test(str);
}

export function onSubmit(successCallback = null, failedCallback = null) {
    if (this.$refs.theForm.reportValidity()) {
        this.form.getCreatedItem = !!this.getCreatedItem;
        axios.post(this.submit_url, j2FD(this.form))
            .then(res => {
                this.$root.msgBox(res.data);
                this.visible = false;
                this.$emit('refreshDatatable', true);
                this.$emit('created', res.data);
                this.errors = null;
                if (typeof successCallback === "function") {
                    successCallback(res);
                }
            })
            .catch(err => {
                this.$emit('error', err.response);
                console.log(err.response);
                this.$root.msgBox(err.response.data);
                this.errors = err.response.data.errors;
                if (typeof failedCallback === "function") {
                    failedCallback(err.response);
                }
            });
    }
}

export function initAddForm(context, callback = null) {
    if (!Object.keys(context.item).length && context.$route.params.id) {
        context.getItem(context.$route.params.id, context.$parent.$props.api_url).then(res => {
            context.form = res.data;
            if (typeof callback === "function") {
                callback();
            }
        }).catch(err => console.log(err.response));
    }
}

export function setPerPage(value = 10) {
    let s = Object.assign({}, JSON.parse(window.localStorage.getItem('per_page') || '{}'));
    if (this && this.$route) {
        s[this.$route.name] = value;
    }
    window.localStorage.setItem('per_page', JSON.stringify(s));
}

export function getPerPage() {
    if (!window.localStorage.getItem('per_page')) {
        setPerPage(10);
    }
    let s = JSON.parse(window.localStorage.getItem('per_page'));
    return (s && s[this.$route.name]) ? s[this.$route.name] : 10;
}

/**
 * Object to Array of Objects Conversion
 * @param items
 * @param skip Array , Objects fields that needs to be skipped from output object
 * @param callback (key,value)=>{return {key:key, value: value}}
 * @returns {[]}
 */
export function objToArrObj(items, skip = [], callback) {
    let output = [];
    for (let x in items) {
        if (!skip.includes(x)) {
            output.push(callback(x, items[x]));
        }
    }
    return output;
}


export function msgBox(data, duration, append) {
    this.$bvToast.toast(data.msg || data.message, {
        title: data.title || data.exception,
        variant: data.type || 'primary',
        autoHideDelay: duration || 3000,
        appendToast: append || false
    });
}

export function range(step = 10, quantity = 50) {
    return [...Array(quantity).keys()].map(i => i * step + step);
}

export function rangeIndexed(start = 1, end = 50, step = 1) {
    let x = [];
    for (let i = start; i <= end; i = i + step) {
        x.push(i);
    }
    return x;
}


export function isBoolean(value) {
    return value === true || value === false;
}

export function isString(value) {
    return typeof value === "string";
}

export function uid(length = 36) {
    return (Date.now().toString(length) + Math.random().toString(length).substr(2, 5));
}

//https://eddmann.com/posts/cartesian-product-in-javascript/
export const cartesianProduct = (...sets) => sets.reduce((acc, set) => ((arr) => [].concat.apply([], arr))(acc.map(x => set.map(y => [...x, y]))), [[]]);

/**
 * Initializing Datatable Columns Visibility Toggle Feature
 * @param scope
 */
export function iniDatatableVisibility(scope) {
    if ((window.localStorage && !(window.localStorage[scope.$route.name]))) {
        let cols = {};
        scope.fields.forEach(i => cols[i.key] = isBoolean(i.visible) ? i.visible : true);
        window.localStorage.setItem(scope.$route.name, JSON.stringify(cols));
    }
    let cls = JSON.parse(window.localStorage[scope.$route.name]);

    scope.fields.forEach(item => {
        // if (!isBoolean(item.visible)) scope.$set(item, 'visible', true);
        scope.$set(item, 'visible', !!(Number(cls[item.key])));
        if (isBoolean(item.visible) && !item.visible) {
            scope.$set(item, 'thClass', 'd-none');
            scope.$set(item, 'tdClass', 'd-none');
        }
    });
}


export function changeVisibility(field, index) {
    let cls = JSON.parse(window.localStorage[this.$route.name]);
    cls[field.key] = !(!!Number(field.visible));

    window.localStorage.setItem(this.$route.name, JSON.stringify(cls));

    if (typeof (this.fields[index].thClass) !== "string") {
        this.$set(this.fields[index], 'thClass', '');
    }
    if (typeof (this.fields[index].tdClass) !== "string") {
        this.$set(this.fields[index], 'tdClass', '');
    }
    if (field.visible) {
        this.$set(this.fields[index], 'thClass', this.fields[index].thClass + ' d-none');
        this.$set(this.fields[index], 'tdClass', this.fields[index].tdClass + ' d-none');

    } else {
        this.$set(this.fields[index], 'thClass', this.fields[index].thClass.replace('d-none', '').trim());
        this.$set(this.fields[index], 'tdClass', this.fields[index].tdClass.replace('d-none', '').trim());
    }
}

/**
 * What happens when dropdown hides
 * @param scope
 * @param callprev
 * @param prev_params
 * @param callback
 * @param params
 */
export function initDatatableModalEvents(scope, callprev, prev_params = [], callback, params = []) {
    if (typeof callprev === "function") {
        callprev(...prev_params);
    } else {
        scope.$root.$on('bv::modal::hidden', (bvEvent, modalId) => {
            if (modalId === 'addModal') {
                scope.form = {};
            } else if (modalId === 'viewModal') {
                scope.currentItem = {};
            }
            if (typeof callback === "function") {
                callback(...params);
            }
        })
    }
}

export function setColumns(scope) {
    return compact(scope.fields.map(item => {
        if (isBoolean(item.visible) && item.visible) {
            if (!isBoolean(item.searchable) || item.searchable) {
                return (item.name || item.key);
            }
        }
    }));
}

export function isTrue(value) {
    return isBoolean(value) && value;
}

export function isArray(value) {
    return Array.isArray(value);
}


export function truncate(str = "", length = 30, ending = '...') {
    return (str.length > length) ? str.substring(0, length - ending.length) + ending : str;
}

export function getItem(id, api_url) {
    // console.log(ctx)
    return axios.post(api_url, {id});
}

export function slugify(string = '') {
    if (!string.toString().trim()) {
        return '';
    }
    const a = 'àáâäæãåāăąçćčđďèéêëēėęěğǵḧîïíīįìłḿñńǹňôöòóœøōõőṕŕřßśšşșťțûüùúūǘůűųẃẍÿýžźż·/_,:;'
    const b = 'aaaaaaaaaacccddeeeeeeeegghiiiiiilmnnnnoooooooooprrsssssttuuuuuuuuuwxyyzzz------'
    const p = new RegExp(a.split('').join('|'), 'g')

    return string.toString().toLowerCase()
        .replace(/\s+/g, '-') // Replace spaces with -
        .replace(p, c => b.charAt(a.indexOf(c))) // Replace special characters
        .replace(/&/g, '-and-') // Replace & with 'and'
        .replace(/[^\w\-]+/g, '') // Remove all non-word characters
        .replace(/\-\-+/g, '-') // Replace multiple - with single -
        .replace(/^-+/, '') // Trim - from start of text
        .replace(/-+$/, '') // Trim - from end of text
}

export function stripTags(str = "") {
    return str.replace(/(<([^>]+)>)/ig, "");
}

export function objPhotoUrl(photo) {
    if (!photo) {
        return null;
    }
    return URL.createObjectURL(photo);
}

/**
 *
 * @param obj Object
 * @param params array
 */
export function pluck(obj, params = []) {
    let x = {};
    params.forEach(i => {
        x[i] = obj[i];
    });
    return x;
}

export function colSum(rows, col) {
    if (!rows) {
        return 0;
    }
    if (!isArray(rows)) {
        return 0;
    }
    if (rows.length <= 0) {
        return 0;
    }
    let total = 0;
    rows.forEach(r => total += Number(r[col]) || 0);
    return total;
}

export function colPercentage(rows, percentage_of, percentage) {
    let total = 0;
    rows.forEach(r => total = Number(r[percentage_of] || 0) * Number(r[percentage] || 0) / 100);
    return total;
}

export function colCount(rows, col) {
    let items = [];
    rows.forEach(r => {
        if (!items.includes(r[col])) {
            items.push(r[col]);
        }
    });
    return items.length;
}

export {toInteger, toFixed, toFloat, startCase, isObject};
export const cleanWhere = (obj, filters = [null, undefined, '']) => Object.entries(obj)
    .map(([k, v]) => [k, v && typeof v === "object" ? cleanWhere(v) : v])
    .reduce((a, [k, v]) => (filters.includes(v) ? a : (a[k] = v, a)), {});

export const commonDtOptions = (ctx) => {
    if (!ctx) {
        ctx = this;
    }
    return {
        items: ctx.getItems,
        fields: ctx.fields,
        filter: ctx.search,
        perPage: ctx.datatable.per_page,
        currentPage: ctx.datatable.current_page,
        // 'sortBy.sync': ctx.datatable.sortBy,
        sortBy: ctx.datatable.sortBy,
        // 'sortDesc.sync': ctx.datatable.sortDesc,
        sortDesc: ctx.datatable.sortDesc,
        footVariant: 'light',
        footClone: true,
        showEmpty: true,
        class: 'mb-0',
        hover: true,
        bordered: true,
        small: true,
        striped: true,
        headVariant: 'dark',
        variant: 'primary',
        responsive: 'md',
    }
}
export const BasicModalOptions = {
    size: 'xl',
    footerClass: 'text-right p-2',
    bodyClass: 'p-2',
    headerBgVariant: 'dark',
    headerTextVariant: 'light',
    okTitle: _t('ok', 'Ok'),
    cancelTitle: _t('cancel', 'Cancel'),
    // footerBgVariant: 'dark',
    // footerTextVariant: 'light',
    lazy: true
}

export default {
    data() {
        return {
            search: '',
            currentItem: {},
            overview: {},
            headers: {},
            datatable: {
                sortBy: 'id',
                sortDesc: true,
                per_page: 10,
                current_page: 1,
                total: 0,
                from: 0,
                to: 0,
                items: [],
                search_columns: {}
            },
            fields: [],
        };
    },
    mounted() {
        iniDatatableVisibility(this);
        initDatatableModalEvents(this);
    },
    methods: {
        commonDtOptions: function () {
            return commonDtOptions(this);
        },
        getItems(ctx) {
            // console.log(ctx)
            return axios.post((this.api_url || ctx.apiUrl) + "?page=" + (ctx.currentPage ? ctx.currentPage : 1), {
                per_page: this.datatable.per_page,
                orderBy: ctx.sortBy || 'id',
                order: isTrue(ctx.sortDesc) ? 'desc' : 'asc',
                // order: isTrue(ctx.sortDesc) && ctx.sortBy ? 'desc' : 'asc',
                filter: ctx.filter,
                columns: setColumns(this),
                search_columns: cleanWhere(this.datatable.search_columns)
            }).then(res => {
                this.headers = res.headers;
                this.datatable.total = res.data.total;
                this.datatable.from = res.data.from;
                this.datatable.to = res.data.to;
                this.datatable.current_page = res.data.current_page;
                this.datatable.items = res.data.data;
                return res.data.data;
            }).catch(err => {
                this.headers = err.response.headers;
                console.log(err.response);
                this.datatable.items = [];
                return [];
            });
        },
        onSubmit(callback = null, callback_params = []) {
            axios.post(this.submit_url, this.form, {
                headers: {
                    'Content-Type': 'multipart/form-data'
                }
            }).then(res => {
                // console.log(res)
                this.$bvModal.hide('addModal');
                this.msgBox(res.data);
                this.$refs.datatable.refresh();
                if (callback) {
                    callback(...callback_params);
                }
            }).catch(err => {
                this.msgBox(err.response);
                console.log(err.response)
            });
        },
        trash(id, datatable = 'datatable', url = null) {
            this.$bvModal
                .msgBoxConfirm(this.__('are_you_sure', 'Are you sure?'), {
                    okTitle: this.__('ok', 'Ok'),
                    cancelTitle: this.__('cancel', 'Cancel')
                })
                .then(value => {
                    if (value) {
                        axios.post(url || this.trash_url, {
                            id: id,
                        }).then(res => {
                            this.msgBox(res.data);
                            if (this.$refs[datatable]) {
                                this.$refs[datatable].refresh();
                            }
                        }).catch(err => {
                            this.msgBox(err.response.data);
                            console.log(err.response)
                        });
                    }
                })
                .catch(err => {
                    console.log(err)
                });
        },
        msgBox,
        obj2Table,
        startCase,
        truncate
    }
}
