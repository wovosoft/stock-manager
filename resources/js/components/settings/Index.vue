<template>

    <form @submit.prevent="handleSubmit" ref="theForm">
        <b-card body-class="p-1" footer-class="text-center">
            <b-table :items="obj2Table(settings)"
                     :fields="[{key:'key',label:__('key','Key'),formatter:v=>startCase(__(v))},{key:'value',label:__('value','Value')}]"
                     bordered small hover striped head-variant="dark">
                <template v-slot:cell(value)="row">
                    <template v-if="row.item.key==='logo'">
                        <b-img-lazy v-if="row.item.value" :src="'storage/'+row.item.value" fluid
                                    style="max-height: 100px;"/>
                        <b-form-file
                            :placeholder="startCase(row.item.key)"
                            v-model="settings.logo_upload"/>
                    </template>
                    <template v-else-if="row.item.key==='currency'">
                        <b-form-select :options="currencies" v-model="settings[row.item.key]"/>
                    </template>
                    <template v-else-if="row.item.key==='timezone'">
                        <b-form-select :options="timezones" v-model="settings[row.item.key]"/>
                    </template>
                    <template v-else-if="row.item.key==='language'">
                        <b-form-select :options="list_languages" v-model="settings[row.item.key]"/>
                    </template>
                    <template v-else-if="row.item.key==='locale'">
                        <b-form-select :options="list_locales" v-model="settings[row.item.key]"/>
                    </template>
                    <template v-else-if="['send_sms_after_sale','send_sms_after_order'].includes(row.item.key)">
                        <b-form-checkbox switch v-model="settings[row.item.key]">
                            {{!!Number(row.item.value)?'YES':'NO'}}
                        </b-form-checkbox>
                    </template>
                    <template v-else-if="['invoice_header','invoice_footer'].includes(row.item.key)">
                        <b-textarea switch v-model="settings[row.item.key]"/>
                    </template>
                    <template v-else-if="['email'].includes(row.item.key)">
                        <b-form-input
                            type="email"
                            :placeholder="startCase(row.item.key)"
                            v-model="settings[row.item.key]"/>
                    </template>
                    <template v-else-if="['phone'].includes(row.item.key)">
                        <b-form-input
                            type="tel"
                            :placeholder="startCase(row.item.key)"
                            v-model="settings[row.item.key]"/>
                    </template>
                    <template v-else-if="['default_tax','default_discount'].includes(row.item.key)">
                        <b-form-input
                            type="number"
                            :placeholder="startCase(row.item.key)"
                            step="any"
                            v-model="settings[row.item.key]"/>
                    </template>
                    <template v-else>
                        <b-form-input
                            type="text"
                            :placeholder="startCase(row.item.key)"
                            v-model="settings[row.item.key]"/>
                    </template>
                </template>
            </b-table>
            <!--            <pre v-html="settings"></pre>-->
            <template v-slot:footer>
                <b-button type="submit" variant="primary" block>SUBMIT</b-button>
            </template>
        </b-card>
    </form>
</template>

<script>
    import {startCase, isArray, obj2Table, msgBox} from "@/partials/datatable";
    import timezones from "@/shared/timezones";
    import j2FD from "@/partials/jsonToFormData";
    import langmap from "@/partials/langmap";
    import currencies from "@/shared/currencies";

    export default {
        props: {
            submit_url: {
                type: String,
                default: () => route('Backend.Settings.Store')
            }
        },
        mounted() {
            this.getSettings();
            let langs = window.listLanguages();
            for (let x in langs) {
                this.list_languages.push({
                    text: x,
                    value: langs[x]
                })
            }
            let locales = [];
            for (let x in langmap) {
                locales.push({
                    text: langmap[x]["englishName"] + " - " + langmap[x]["nativeName"],
                    value: x
                })
            }
            this.$set(this, "list_locales", locales);
        },
        data() {
            return {
                currencies,
                settings: {},
                timezones,
                list_languages: [],
                list_locales: []
            }
        },
        methods: {
            obj2Table,
            startCase,
            msgBox,
            getSettings() {
                axios
                    .post(route('Backend.Settings.List'))
                    .then(res => {
                        let data = {};
                        if (isArray(res.data)) {
                            res.data.forEach(item => {
                                if (['default_tax', 'default_tax',].includes(item.key)) {
                                    data[item.key] = Number(item.value);
                                } else if (['send_sms_after_sale', 'send_sms_after_order'].includes(item.key)) {
                                    data[item.key] = !!Number(item.value);
                                } else {
                                    data[item.key] = item.value;
                                }
                            });
                            this.$set(this, 'settings', data);
                        } else {
                            this.$set(this, 'settings', {});
                        }
                    })
                    .catch(err => {
                        this.$set(this, 'settings', {});
                        console.log(err.response);
                    });
            },
            handleSubmit() {
                axios
                    .post(this.submit_url, j2FD(this.settings))
                    .then(res => {
                        this.msgBox(res.data);
                        // this.getSettings();
                        window.location.reload();
                    })
                    .catch(err => {
                        console.log(err.response);
                        this.msgBox(err.response.data);
                    });
            }
        }
    }
</script>

