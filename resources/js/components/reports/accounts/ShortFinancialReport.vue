<template>
    <div>
        <b-card body-class="p-1">
            <template #header>
                <b-row>
                    <b-col>
                        <h5>{{__('short_financial_report','Short Financial Report')}}</h5>
                    </b-col>
                    <b-col class="text-right">
                        <b-button size="sm" target="_blank" variant="dark"
                                  :href="route('Backend.Reports.ShortFinancialReport',{pdf:'pdf'}).url()">
                            Export
                        </b-button>
                    </b-col>
                </b-row>
            </template>
            <table class="table table-sm table-striped table-bordered table-hover">
                <tbody>
                <tr v-for="x in Object.keys(report)" :key="x">
                    <td>{{__(x,startCase(x))}}</td>
                    <td>{{report[x] | currency}}</td>
                </tr>
                </tbody>
            </table>
        </b-card>
    </div>
</template>

<script>
    import {startCase} from "@/partials/datatable";

    export default {
        name: "ShortFinancialReport",
        data() {
            return {
                report: {}
            }
        },
        mounted() {
            this.getItems();
        },
        methods: {
            startCase,
            getItems() {
                axios.post(route('Backend.Reports.ShortFinancialReport').url())
                    .then(res => {
                        this.$set(this, 'report', res.data);
                    })
                    .catch(err => {
                        this.$set(this, 'report', {});
                        console.log(err.response.data);
                    });
            }
        }
    }
</script>

<style scoped>

</style>
