<template>
    <b-input-group>
        <b-form-select v-model="duration.hours" :options="range(1,this.hours)"/>
        <b-form-select v-model="duration.minutes" :options="[0,...range(1,this.minutes)]"/>
    </b-input-group>
</template>
<script>
    import {range} from "@/partials/datatable"

    export default {
        props: {
            value: {
                type: String,
                default: '1:0'
            },
            hours: {
                type: Number,
                default: 24
            },
            minutes: {
                type: Number,
                default: 59,
            }
        },
        methods: {
            range
        },
        data() {
            return {
                duration: {
                    hours: 1,
                    minutes: 0,
                }
            }
        },
        mounted() {
            let times = this.value.split(':');
            this.duration.hours = times[0];
            this.duration.minutes = times.length > 1 ? times[1] : 0;
        },
        watch: {
            duration: {
                handler(v) {
                    this.$emit('input', [this.duration.hours, this.duration.minutes].join(':'))
                },
                deep: true
            }
        }
    }
</script>
