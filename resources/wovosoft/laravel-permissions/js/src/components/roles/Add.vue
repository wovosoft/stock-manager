<template>
    <b-card no-body>
        <b-tabs card>
            <b-tab title="Basic Information" active>
                <b-row>
                    <b-col md="4">
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
                    </b-col>
                    <b-col md="8">
                        <h4>
                            {{__('permissions','Permissions')}}
                            <b-badge>{{rows}}</b-badge>
                        </h4>
                        <b-table :items="permissions" small bordered hover striped head-variant="dark"
                                 :current-page="currentPage"
                                 :per-page="perPage"
                                 :fields="[
                                     {key:'name',sortable:true,label:__('name','Name')},
                                     {key:'description',sortable: true,label:__('description','Description')},
                                     {key:'allowed',sortable:false,tdClass:'text-right',thClass:'text-right',label:__('allowed','Allowed')}
                                 ]">
                            <template v-slot:cell(allowed)="row">
                                <b-form-checkbox v-model="row.item.allowed" switch></b-form-checkbox>
                            </template>
                        </b-table>
                        <b-row>
                            <b-col>
                                <b-form-select v-model="perPage" :options="range(5)"></b-form-select>
                            </b-col>
                            <b-col>
                                <b-pagination
                                    align="right"
                                    v-model="currentPage"
                                    :total-rows="rows"
                                    :per-page="perPage"
                                    aria-controls="my-table"
                                ></b-pagination>
                            </b-col>
                        </b-row>
                    </b-col>
                </b-row>
            </b-tab>
            <b-tab :title="__('assigned_users','Assigned Users')">
                <b-form-group :label="__('users','Users')">
                    <type-head :search="search" :search-items="searchItems"
                               autocomplete="off"
                               :placeholder="__('search_users','Search Users')"
                               @selected="item=>selectUser(item)">
                        <template v-slot:option="item">
                            {{item.id}} # {{item.name}} | {{item.email}}
                        </template>
                    </type-head>
                    <br>
                    <h4>{{__('selected_users','Selected Users')}}</h4>
                    <b-table bordered small head-variant="dark" :items="users_insert"
                             :fields="[
                                 {key:'id',label:__('id','ID')},
                                 {key:'name',label:__('name','Name')},
                                 {key:'email',label:__('email','Email')},
                                 {key:'action',label: __('action','Action'),tdClass:'text-right',thClass:'text-right'}]">
                        <template v-slot:cell(action)="row">
                            <button type="button" @click="users_insert.splice(row.index,1)"
                                    class="btn btn-dark btn-sm">
                                <i class="fa fa-trash"></i>
                            </button>
                        </template>
                    </b-table>
                    <!--<pre v-html="users_insert"></pre>-->
                    <h4>{{__('assigned_users','Assigned Users')}}</h4>
                    <user-list v-if="form.id" :role_id="form.id"></user-list>
                </b-form-group>
            </b-tab>
        </b-tabs>
    </b-card>

</template>

<script>
    import {range} from "../partials/datatable";
    import UserList from "./Users"
    import TypeHead from "../partials/TypeHead";

    export default {
        props: {
            submit_url: {
                type: String,
                default: null
            },
            users_search_url: {
                type: String,
                default: "/backend/users/search"
            },
            data_url: {
                type: String,
                default: "/backend/users/data"
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
        components: {
            TypeHead,
            UserList
        },
        mounted() {
            this.form = JSON.parse(JSON.stringify(this.value));
            axios.post(this.data_url, {
                permissions: this.permissions.length <= 0 ? ["id", "name", "description"] : false,
            }).then(res => {
                if (res.data.permissions) {
                    let user_permissions = this.form.permissions.map(item => item.name);
                    this.permissions = (res.data.permissions || []).map(item => {
                        return {
                            id: item.id,
                            name: item.name,
                            description: item.description,
                            allowed: user_permissions.includes(item.name)
                        }
                    });
                }
            }).catch(err => {
                console.log(err.response);
            });
        },
        computed: {
            rows() {
                return (this.permissions) ? this.permissions.length : 0
            }
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
                show_dropdown: false,
                users: [],
                users_insert: [],
                search: '',
                perPage: 10,
                currentPage: 1,
                permissions: []
            }
        },
        methods: {
            range,
            onSubmit() {
                let data = JSON.parse(JSON.stringify(this.form));
                data.users_insert = this.users_insert.map(item => item.id);
                data.permissions_sync = this.permissions.filter(item => item.allowed).map(item => item.name);

                axios.post(this.submit_url, data)
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
            },
            searchItems(search) {
                if (!search) {
                    this.users = [];
                    return false;
                }
                return axios.post(this.users_search_url, {
                    search: search
                });
            },
            selectUser(user) {
                for (let x in this.users_insert) {
                    if (this.users_insert[x].id === user.id) {
                        return false;
                    }
                }
                this.users_insert.push(user);
                this.search = '';
            }
        }
    }
</script>

