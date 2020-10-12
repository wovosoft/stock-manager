import {getItem, obj2Table} from "@/partials/datatable";
import startCase from "bootstrap-vue/esm/utils/startcase";

export default {
    props: {
        item: {
            type: Object,
            default: () => {
                return {}
            }
        }
    },
    methods: {
        obj2Table,
        startCase,
        getItem
    },
    data() {
        return {
            the_item: {}
        }
    },
    mounted() {
        this.the_item = this.item;
        if (!Object.keys(this.item).length) {
            this.getItem(this.$route.params.id, this.$parent.$props.api_url)
                .then(res => {
                    this.the_item = res.data
                })
                .catch(err => console.log(err.response));
        }
    }
}
