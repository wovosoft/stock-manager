<template>
    <div class="row">
        <div class="col">
            <form @submit.prevent="onSubmit">
                <b-form-group :label="__('name','Name') +' *'">
                    <b-form-input v-model="form.name" :placeholder="__('name','Name')" :required="true"/>
                </b-form-group>
                <b-form-group :label="__('guard_name','Guard Name')">
                    <b-form-input v-model="form.guard_name" :placeholder="__('guard_name','Guard Name')"/>
                </b-form-group>
                <b-form-group :label="__('description','Description')">
                    <b-form-textarea
                        v-model="form.description"
                        :placeholder="__('description','Description')"/>
                </b-form-group>
                <b-button ref="submitBtn" variant="primary" :hidden="hide_submit" block type="submit">
                    {{__('submit','SUBMIT')}}
                </b-button>
            </form>
        </div>
        <div class="col-md-8" v-if="form.id">
            <roles title="Assigned Roles" :permission_id="form.id"></roles>
            <br>
            <users title="Assigned Users" :permission_id="form.id"></users>
        </div>

        <!--        <pre v-html="form"></pre>-->
    </div>
</template>

<script>
    import Roles from "./Roles";
    import Users from "./Users";

    export default {
        components: {Users, Roles},
        props: {
            submit_url: {
                type: String,
                default: null
            },
            value: {
                type: Object,
                default: function () {
                    return {
                        id: null
                    }
                }
            },
            hide_submit: {
                type: Boolean,
                default: false
            }
        },
        mounted() {
            this.form = JSON.parse(JSON.stringify(this.value));
        },
        watch: {
            form: {
                handler(value) {
                    this.$emit('input', value);
                },
                deep: true
            }
        },
        data() {
            return {
                url: null,
                form: {},
            }
        },
        methods: {
            onSubmit() {
                axios.post(this.submit_url, this.form)
                    .then(res => {
                        this.$emit('created', res.data);
                    })
                    .catch(err => {
                        this.$emit('error', err.response);
                        console.log(err.response.data);
                        // this.$emit('error',res)
                    });
            },
            hitSubmit() {
                this.$refs.submitBtn.click();
            }
        }
    }
</script>
