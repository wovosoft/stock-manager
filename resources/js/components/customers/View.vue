<template>
    <b-modal @hidden="$router.go(-1),$emit('reset',true)" visible
             size="xl"
             header-bg-variant="dark"
             header-text-variant="light"
             no-body
             :title="__('view_customer','View Customer')"
             lazy>
        <b-row>
            <b-col md="3" sm="12">
                <b-img-lazy v-if="the_item.photo" fluid thumbnail :src="'storage/'+the_item.photo"></b-img-lazy>
                <b-img-lazy v-else fluid thumbnail
                            src="https://plchldr.co/i/500x250?bg=111111&&text=No Image"></b-img-lazy>
                <h4 class="my-2 text-center">{{__('financial_report','Financial Report')}}</h4>
                <table class="table table-sm table-bordered table-striped table-hover">
                    <tr v-for="$money in ['payable','returned','paid','balance']">
                        <th>{{__('sales_'+$money,startCase('sales_'+$money))}}</th>
                        <td>{{the_item[$money] | currency}}</td>
                    </tr>
                </table>
            </b-col>
            <b-col>
                <b-table small bordered hover striped
                         head-variant="dark"
                         :items="obj2Table(the_item,['deleted_at','photo','payable','paid','returned','balance'])"
                         :fields="[
                            {
                                key: 'key', sortable: true,
                                formatter: (v) => __(v,startCase(v))
                            },
                            {
                                key: 'value',
                                sortable: true
                            }
                       ]">
                    <template v-slot:cell(value)="row">
                        <template v-if="['created_at','updated_at'].includes(row.item.key)">
                            {{row.item.value | dayjs}}
                        </template>
                        <template v-else-if="['description'].includes(row.item.key)">
                            <div v-html="row.item.value"></div>
                        </template>
                        <template v-else>{{row.item.value}}</template>
                    </template>
                </b-table>
            </b-col>
        </b-row>
        <b-row>
            <b-col>
                <h4 class="text-center">
                    {{__('financial_report','Financial Report')}}
                </h4>
                <b-input-group>
                    <template #prepend>
                        <b-input-group-text>
                            {{__('start','Start')}}
                        </b-input-group-text>
                    </template>
                    <b-input v-model="browse.start_date" type="date" class="rounded-0"></b-input>
                    <b-input-group-text class="rounded-0">
                        {{__('end','End')}}
                    </b-input-group-text>
                    <b-input v-model="browse.end_date" type="date"></b-input>
                    <template #append>
                        <b-button
                            variant="danger"
                            @click="browse.start_date=null,browse.end_date=null"
                            target="_blank">
                            {{__('reset','Reset')}}
                        </b-button>
                        <b-button
                            variant="primary"
                            v-if="the_item && the_item.id"
                            target="_blank"
                            :href="route('Backend.Customers.Payments.shortFinancialReport',{customer:the_item.id,type:'pdf',start_date:browse.start_date,end_date:browse.end_date})">
                            {{__('short_report','Short Report')}}
                        </b-button>
                        <b-button
                            variant="dark"
                            v-if="the_item && the_item.id"
                            target="_blank"
                            :href="route('Backend.Customers.Payments.fullFinancialReport',{customer:the_item.id,type:'pdf',start_date:browse.start_date,end_date:browse.end_date})">
                            {{__('full_report','Full Report')}}
                        </b-button>
                    </template>
                </b-input-group>
            </b-col>
        </b-row>
    </b-modal>
</template>
<script>
    import view from "@/partials/view"

    export default {
        mixins: [view],
        data() {
            return {
                the_item: {},
                browse: {
                    start_date: null,
                    end_date: null
                }
            }
        },
    }
</script>
