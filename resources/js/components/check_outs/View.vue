<template>
    <b-modal @hidden="$router.go(-1)" visible
             size="lg"
             header-bg-variant="dark"
             header-text-variant="light"
             no-body
             :title="__('view_check_out','View Check-out')"
             lazy>
        <b-row>
            <b-col>
                <table class="table table-striped table-borderless table-sm">
                    <tr>
                        <th class="w-25">{{__('reference','Reference')}}</th>
                        <td>: {{the_item.reference}}</td>
                    </tr>
                    <tr>
                        <th class="w-25">{{__('date','Date')}}</th>
                        <td>: {{the_item.datetime |dayjs}}</td>
                    </tr>
                    <tr v-if="the_item.supplier">
                        <th class="w-25">{{__('supplier','Supplier')}}</th>
                        <td>: {{the_item.supplier.name}}</td>
                    </tr>
                </table>
            </b-col>
        </b-row>
        <b-row>
            <b-col>
                <b-table
                    small
                    striped
                    bordered
                    head-variant="dark"
                    :items="the_item.items"
                    :fields="[
                        {key:'SL',label:__('SL','SL')},
                        {key:'name',label:__('name','Name')},
                        {key:'code',label: __('code','Code')},
                        {key:'quantity',label: __('quantity','Quantity')}
                     ]">
                    <template v-slot:cell(SL)="row">{{row.index+1}}</template>
                </b-table>
            </b-col>
        </b-row>
        <b-row>
            <b-col>
                <b-jumbotron class="p-3">
                    {{__('note','Note')}}:
                    <div v-html="the_item.note"></div>
                </b-jumbotron>
            </b-col>
            <b-col>
                <b-jumbotron class="p-3" v-if="the_item.creator">
                    {{__('created_by','Created By')}} : {{the_item.creator.name}}<br>
                    {{__('created_at','Created At')}} : {{the_item.created_at |dayjs}}<br>
                    {{__('updated_at','Updated At')}} : {{the_item.updated_at |dayjs}}
                </b-jumbotron>
            </b-col>
        </b-row>
    </b-modal>
</template>
<script>
    import view from "@/partials/view"

    export default {
        mixins: [view]
    }
</script>
