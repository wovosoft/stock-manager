<template>
    <div class="vue-select form-control p-0"
         :class="{'is-invalid':(state!==null) && state,'is-valid':((state!==null) && !state)}">
        <input v-if="required"
               v-bind:value="value?'initialized':''"
               style="height: 0;position: absolute;top: 0;border: 0;outline: 0;z-index: -1;"
               type="text"
               :required="true">
        <b-dropdown
            @hidden="()=>{
                $emit('hidden',true);
                if (this.clearSearchOnDropdownHidden){
                    this.query='';
                }
            }"
            block
            lazy
            :variant="dropdownVariant"
            :disabled="disabled"
            toggle-class="text-left m-0 border-0 border-radius-0"
            :class="{'hide-dd-icon':hideDdIcon,disabled:disabled}"
            :style="menuStyle"
            :menu-class="menuClass">
            <template v-slot:button-content>
                <slot name="tag" v-bind:tag="selected_item">
                    {{ (typeof tagText==="function")?tagText(selected_item):(selected_item?placeholder:placeholder) }}
                </slot>
            </template>
            <div class="px-2">
                <b-form-input
                    autofocus
                    @keypress.enter.prevent=""
                    @input="getItems($event)"
                    v-model="query"
                    type="search"
                    :size="size"
                    :class="inputClass"
                    :placeholder="placeholder"
                    :autocomplete="autocomplete"
                ></b-form-input>
            </div>
            <b-dropdown-divider></b-dropdown-divider>
            <b-dropdown-item
                v-for="(option,option_key) in getOptions"
                :key="option_key"
                @click="itemSelected(option)"
            >
                <slot name="option" v-bind:item="option" v-bind:query="query">
                    {{ (typeof optionText==='function')?optionText(option): option }}
                </slot>
            </b-dropdown-item>

            <template v-if="options.length === 0">
                <slot name="empty" v-bind:query="query">
                    <b-dropdown-text v-if="options.length === 0">
                        {{emptyOptionText}}
                    </b-dropdown-text>
                </slot>
            </template>
            <slot name="default_item" v-bind:query="query"></slot>
        </b-dropdown>
    </div>
</template>

<script>
    import {isBoolean} from "bootstrap-vue/esm/utils/inspect";

    export default {
        props: {
            value: {
                type: Object | null,
                default: () => null
            },
            api_url: {
                type: String,
                default: null,
                required: true
            },
            prepend: {
                type: String,
                default: ''
            },
            append: {
                type: String,
                default: ''
            },
            placeholder: {
                type: String,
                default: 'Search Items'
            },
            size: {
                type: String,
                default: 'sm'
            },
            autocomplete: {
                type: String,
                default: 'off'
            },
            dropdownVariant: {
                type: String,
                default: 'outline-secondary'
            },

            emptyOptionText: {
                type: String,
                default: 'No items available to select'
            },
            inputClass: {
                type: String | Array,
                default: () => []
            },
            menuStyle: {
                type: String | Array,
                default: () => []
            },
            clearSearchOnItemSelected: {
                type: Boolean,
                default: false
            },
            initOptions: {
                type: Boolean | String,
                default: false
            },
            required: {
                type: Boolean,
                default: false
            },
            state: {
                type: Boolean,
                default: null
            },
            hideDdIcon: {
                type: Boolean,
                default: false
            },
            disabled: {
                type: Boolean,
                default: false
            },
            menuClass: {
                type: String | Object,
                default: () => ""
            },
            getFiltered: {
                type: Function
            },
            clearSearchOnDropdownHidden: {
                type: Boolean,
                default: () => true
            },
            optionText: {
                type: Function,
            },
            tagText: {
                Type: Function
            }
        },
        data() {
            return {
                options: [],
                query: '',
                selected_item: null
            }
        },
        mounted() {
            if (this.initOptions) {
                if (isBoolean(this.initOptions) && this.initOptions) {
                    this.getItems('');
                } else {
                    this.query = this.initOptions;
                }
            }
            this.$set(this, 'selected_item', this.value);
        },
        computed: {
            getOptions() {
                if (typeof this.getFiltered === 'function' && this.getFiltered) {
                    return this.getFiltered(this.options);
                }
                return this.options;
            },
        },

        watch: {
            value: {
                deep: true,
                handler(v) {
                    this.$set(this, 'selected_item', v);
                }
            }
        },
        methods: {
            reset() {
                this.$emit('input', null);
                this.$set(this, 'selected_item', null);
                this.query = "";
            },
            itemSelected(option) {
                this.$emit('input', option);
                this.$set(this, 'selected_item', option);
                if (this.clearSearchOnItemSelected) {
                    this.query = null;
                }
            },
            getItems(e) {
                axios
                    .post(this.api_url, {query: this.query})
                    .then(res => {
                        this.$set(this, 'options', res.data || []);
                    })
                    .catch(err => {
                        this.$set(this, 'options', []);
                        console.error(err.response);
                    });
            },


        }
    }
</script>
<style lang="scss">
    .vue-select {
        .dropdown-menu {
            max-height: 300px;
            overflow-y: auto;
            width: 100%;
        }

        .dropdown-toggle::after {
            position: absolute;
            right: 10px;
            top: 49%;
        }

        .border-radius-0 {
            border-radius: 0 !important;
        }

        .top-reverse-100 {
            top: -100% !important;
        }

        .hide-dd-icon {
            .dropdown-toggle::after {
                display: none !important;
            }
        }
    }

    .vue-select.is-invalid, .vue-select.is-valid {
        background-position: right calc(1.4em + 0.1875rem) center !important;
    }

</style>
