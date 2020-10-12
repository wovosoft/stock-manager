<template>
    <div>
        {{items}}
    </div>
</template>

<script>
    export default {
        props: {
            sale_id: {
                type: Number,
                required: true
            },
            date: {
                type: String,
                required: true
            }
        },
        data() {
            return {
                items: []
            }
        },
        mounted() {
            axios
                .post(route('Backend.Payments.Single.Sales.Payments', {sale: this.sale_id}).url(), {
                    date: this.date
                })
                .then(res => console.log(res.data))
                .catch(err => {
                    console.log(err.response);
                });
        }
    }
</script>

<style scoped>

</style>
