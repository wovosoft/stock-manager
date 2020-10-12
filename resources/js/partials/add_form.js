import {getItem, initAddForm, onSubmit} from "@/partials/datatable";

export default {
    props: {
        getCreatedItem: {
            type: Boolean,
            default: false
        },
        item: {
            type: Object,
            default: () => {
                return {}
            }
        },
    },
    mounted() {
        this.form = this.item;
        initAddForm(this, () => {

        });
    },
    data() {
        return {
            form: {},
            errors: null,
            visible: true
        }
    },
    methods: {
        getItem,
        onSubmit,
        hitSubmit() {
            this.$refs.submitBtn.click();
        },
        hasError(field) {
            return !!(this.errors && this.errors[field] && this.errors[field].length);
        },
        getErrorMsg(field, join = ",") {
            return this.hasError(field) ? this.errors[field].join(join) : "";
        }
    }
}
