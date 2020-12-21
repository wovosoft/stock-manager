<template>
    <b-modal @hidden="$router.go(-1),$emit('reset',true)" visible
             v-bind="{...BasicModalOptions,size:'xl'}"
             :title="__('view_collection','View Collection')">
        <b-form-row>
            <b-col md="4" sm="12">
                <b-card
                    :header="__('customer_details','Customer Details')"
                    body-class="p-0"
                    header-text-variant="light"
                    header-bg-variant="dark">
                    <b-table
                        v-if="the_item.customer"
                        thead-class="d-none"
                        small
                        striped
                        bordered
                        hover
                        class="mb-0"
                        :fields="[{key:'key',formatter:v=>__(v)},'value']"
                        :items="obj2Table(the_item.customer)">
                    </b-table>
                </b-card>
                <b-card
                    :header="__('user_details','User Details')"
                    body-class="p-0"
                    class="mt-3"
                    header-text-variant="light"
                    header-bg-variant="dark">
                    <b-table
                        v-if="the_item.user"
                        thead-class="d-none"
                        small
                        striped
                        bordered
                        hover
                        class="mb-0"
                        :fields="[{key:'key',formatter:v=>__(v)},'value']"
                        :items="obj2Table(the_item.user)">

                    </b-table>
                </b-card>
            </b-col>
            <b-col md="8" sm="12">
                <b-table small bordered hover striped
                         head-variant="dark"
                         :items="obj2Table(the_item,['deleted_at','user','customer','user_id','customer_id'])"
                         :fields="[
                            {
                                key: 'key', sortable: true,
                                label:__('key','Key'),
                                formatter: (v) => __(v,startCase(v))
                            },
                            {
                                key: 'value',
                                label:__('value','Value'),
                                sortable: true
                            }
                       ]">
                    <template v-slot:cell(value)="row">
                        <template v-if="['created_at','updated_at'].includes(row.item.key)">
                            {{row.item.value | localDateTime}}
                        </template>
                        <template
                            v-else-if="['previous_balance','payment_amount','current_balance'].includes(row.item.key)">
                            {{row.item.value|currency}}
                        </template>
                        <template
                            v-else-if="['status'].includes(row.item.key)">
                            {{__(row.item.value,startCase(row.item.value))}}
                        </template>
                        <template v-else>{{row.item.value}}</template>
                    </template>
                </b-table>
            </b-col>
        </b-form-row>
        <b-row v-if="the_item && the_item.status">
            <b-col md="4" sm="12" offset-md="4">
                <b-form-group label-class="text-center" :label="__('status','Status')">
                    <b-select
                        v-model="the_item.status"
                        :options="statuses"
                        @input="changeStatus"></b-select>
                </b-form-group>
            </b-col>
        </b-row>
        <div v-if="!the_item.payment_id && !disabled" class="text-center" @click="makePayment">
            <b-button variant="dark" size="sm">{{__('make_payment','Make Payment')}}</b-button>
        </div>
        <b-alert variant="success" v-else show>
            {{__('payment_completed','Payment Completed')}}
        </b-alert>
    </b-modal>
</template>
<script>
    import view from "@/partials/view"
    import {BasicModalOptions} from "@/partials/datatable";
    import statuses from "@/shared/statuses";

    export default {
        mixins: [view],
        data() {
            return {
                BasicModalOptions,
                disabled: false,
                statuses
            }
        },
        methods: {
            changeStatus(value) {
                console.log(value)
                if (!value) {
                    alert("Status is required");
                    return false;
                }
                this.disabled = true;
                axios.post(route('Backend.Collections.ChangeStatus', {
                    customer: this.the_item.customer_id,
                    order_collection: this.the_item.id
                }), {
                    status: value
                }).then(res => {
                    this.$root.msgBox(res.data);
                    this.$emit('refreshDatatable', true);
                    this.getItem(this.the_item.id, route('Backend.Collections.List'))
                        .then(res => {
                            this.the_item = res.data
                        })
                        .catch(err => console.log(err.response));
                }).catch(err => {
                    console.log(err.response);
                    this.$root.msgBox(err.response.data);
                });
            },
            makePayment() {
                this.disabled = true;
                axios.post(route('Backend.Collections.MakePayment', {
                    customer: this.the_item.customer_id,
                    order_collection: this.the_item.id
                })).then(res => {
                    this.$root.msgBox(res.data);
                    this.$emit('refreshDatatable', true);
                    this.getItem(this.the_item.id, route('Backend.Collections.List'))
                        .then(res => {
                            this.the_item = res.data
                        })
                        .catch(err => console.log(err.response));
                }).catch(err => {
                    console.log(err.response);
                    this.$root.msgBox(err.response.data);
                });
            }
        }
    }
</script>
