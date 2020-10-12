<template>
    <div>
        <b-table
            class="mb-0"
            :items="getListIns"
            :fields="fields"
            ref="dt_items"
            small
            striped
            foot-clone
            foot-variant="light"
            head-variant="dark"
        >
            <template #foot(name)="row">
                {{ __("total", "Total") }} :
            </template>
            <template #foot(total_payable)="row">
                {{ colSum(items.data, "total_payable") | currency }}
            </template>
            <template #foot(total_paid)="row">
                {{ colSum(items.data, "total_paid") | currency }}
            </template>
            <template #foot(total_balance)="row">
                {{ colSum(items.data, "total_balance") | currency }}
            </template>
            <template #cell(action)="row">
                <b-button
                    size="sm"
                    variant="dark"
                    v-b-modal:customer-payment
                    @click="() => {
                        $set(form, 'payment_amount', row.item.total_balance);
                        $set(form, 'customer_id', row.item.id);
                        $set(form, 'payment_method', 'Cash');
                        $set( form,'sales', JSON.parse(JSON.stringify(row.item.sales)) );
                    }"
                    :title="__('add_payment', 'Add Payment')">
                    <i class="fa fa-plus"></i>
                </b-button>
            </template>
        </b-table>
        <dt-footer :datatable="items"/>
        <b-modal @shown="() => {
                  if (!form.date) {
                    $set(form, 'date', date);
                  }
                }
              "
                 @hidden="form = {}"
                 size="xl"
                 hide-footer
                 header-bg-variant="dark"
                 header-text-variant="light"
                 id="customer-payment"
                 :title="__('customer_payment', 'Customer Payment')"
        >
            <template #default="{ hide }">
                <b-form @submit.prevent="handleCustomerSalePayment(hide)" ref="customer_sale_payment">
                    <b-form-row>
                        <b-col md="4" sm="12">
                            <b-form-group :label="__('payment_amount', 'Payment Amount')">
                                <b-input-group>
                                    <b-input
                                        type="number"
                                        step="any"
                                        :required="true"
                                        v-model="form.payment_amount"
                                    />
                                    <template #append>
                                        <b-button variant="dark" @click="distributePayments(form.payment_amount)">
                                            {{ __("distribute", "Distribute") }}
                                        </b-button>
                                    </template>
                                </b-input-group>
                            </b-form-group>
                            <b-form-group :label="__('payment_method', 'Payment Method')">
                                <b-select
                                    :required="true"
                                    v-model="form.payment_method"
                                    :options="payment_options"
                                />
                            </b-form-group>
                            <b-form-group :label="__('date', 'Date')">
                                <b-input type="date" :required="true" v-model="form.date"/>
                            </b-form-group>
                        </b-col>
                        <b-col md="8" sm="12">
                            <h5>{{ __("due_sales", "Due Sales") }}</h5>
                            <b-table
                                :items="form.sales"
                                :fields="form_sales_fields"
                                small
                                head-variant="dark"
                                bordered
                                striped
                                hover
                                foot-variant="light"
                                foot-clone
                            >
                                <template #cell(id)="row">
                                    <b-link
                                        :href="
                      route('Backend.Sales.Invoice.PDF', {
                        sale: row.item.id,
                        type: 'pdf',
                      })
                    "
                                        target="_blank"
                                    >
                                        {{ row.item.id }}
                                    </b-link>
                                </template>
                                <template #cell(amount)="row">
                                    <b-input-group size="sm">
                                        <b-input
                                            type="number"
                                            step="any"
                                            :placeholder="__('amount', 'Amount')"
                                            @input="
                        form.payment_amount = colSum(form.sales, 'amount')
                      "
                                            v-model="row.item.amount"
                                        />
                                        <template #append>
                                            <b-button
                                                @click="
                          () => {
                            $set(row.item, 'amount', row.item.balance);
                          }
                        "
                                            >
                                                Full
                                            </b-button>
                                        </template>
                                    </b-input-group>
                                </template>
                                <template #foot(id)="row">
                                    {{ __("total", "Total") }}:
                                </template>
                                <template #foot(payable)="row">
                                    {{ colSum(form.sales, "payable") | currency }}
                                </template>
                                <template #foot(paid)="row">
                                    {{ colSum(form.sales, "paid") | currency }}
                                </template>
                                <template #foot(balance)="row">
                                    {{ colSum(form.sales, "balance") | currency }}
                                </template>
                                <template #foot(amount)="row">
                                    {{ (colSum(form.sales, "amount") || 0) | currency }}
                                </template>
                            </b-table>
                        </b-col>
                    </b-form-row>
                    <b-button block variant="dark" type="submit">
                        {{ __("submit", "SUBMIT") }}
                    </b-button>
                </b-form>
            </template>
        </b-modal>
    </div>
</template>

<script>
    import DtFooter from "@/partials/DtFooter";
    import {colSum, colCount, msgBox} from "@/partials/datatable";
    import payment_options from "@/shared/payment_options";

    export default {
        name: "DueSales",
        components: {
            DtFooter
        },
        props: {
            date: String,
            required: true
        },
        data() {
            return {
                form: {},
                payment_options,
                items: {
                    data: [],
                    current_page: 1,
                    per_page: 30
                },
                form_sales_fields: [
                    {key: "id", label: _t("id", "ID")},
                    {
                        key: "created_at",
                        label: _t("date", "Date"),
                        formatter: (v) => this.$options.filters.localDate(v),
                    },
                    {
                        key: "payable",
                        label: _t("payable", "Payable"),
                        formatter: (v) => this.$options.filters.currency(v),
                    },
                    {
                        key: "paid",
                        label: _t("paid", "Paid"),
                        formatter: (v) => this.$options.filters.currency(v),
                    },
                    {
                        key: "balance",
                        label: _t("balance", "Balance"),
                        formatter: (v) => this.$options.filters.currency(v),
                    },
                    {
                        key: "amount",
                        label: _t("amount", "Amount"),
                    },
                ],
                fields: [
                    {key: "id", label: _t("id", "ID")},
                    {
                        key: "name",
                        label: _t("customer", "Customer"),
                    },
                    {
                        key: "total_payable",
                        label: _t("payable", "Payable"),
                        formatter: (v) => this.$options.filters.currency(v),
                    },
                    {
                        key: "total_paid",
                        label: _t("paid", "Paid"),
                        formatter: (v) => this.$options.filters.currency(v),
                    },
                    {
                        key: "total_balance",
                        label: _t("balance", "Balance"),
                        formatter: (v) => this.$options.filters.currency(v),
                    },
                    {
                        key: "action",
                        label: _t("action", "Action"),
                        tdClass: "text-right",
                        thClass: "text-right",
                    },
                ],
            }
        },
        methods: {
            colSum, colCount, msgBox,
            handleCustomerSalePayment(hide) {
                if (this.$refs.customer_sale_payment.reportValidity()) {
                    axios
                        .post(route("Backend.Transactions.Set.By.Customers").url(), this.form)
                        .then((res) => {
                            this.msgBox(res.data);
                            this.$refs.dt_items.refresh();
                            hide();
                        })
                        .catch((err) => {
                            this.msgBox(err.response.data);
                            console.log(err.response);
                        });
                }
            },
            distributePayments(total) {
                if (Number(total) === Number(this.colSum(this.form.sales, "amount"))) {
                    return false;
                }
                let payable = 0;
                for (let x in this.form.sales) {
                    if (this.form.sales[x].balance <= total) {
                        payable = this.form.sales[x].balance;
                    } else {
                        payable = total;
                    }
                    this.$set(this.form.sales[x], "amount", payable);
                    total -= payable;
                }
            },
            getListIns() {
                return axios
                    .post(route("Backend.Transactions.By.Customers", {page: this.items.current_page,}).url(), {
                        date: this.date,
                    })
                    .then((res) => {
                        this.$set(this, "items", res.data);
                        return res.data.data;
                    })
                    .catch((err) => {
                        this.$set(this, "items", {data: [], current_page: 1});
                        console.log(err.response);
                        return [];
                    });
            },
        }
    }
</script>

<style scoped>

</style>
