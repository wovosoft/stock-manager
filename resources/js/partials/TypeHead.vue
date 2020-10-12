<template>
    <div v-model="selected_tags" class="p-0 typehead">
        <ul v-if="selected_tags.length > 0 && !disableTags" class="list-inline d-inline-block mb-1">
            <li v-for="(tag,i) in selected_tags"
                :key="i"
                class="list-inline-item mb-2">
                <b-button-group :size="size">
                    <b-button :variant="tagVariant">
                        <slot name="tag" v-bind:tag="tag">
                            {{ tag }}
                        </slot>
                    </b-button>
                    <b-button :variant="tagCloseVariant" @click="removeTag(i)">
                        x
                    </b-button>
                </b-button-group>
            </li>
        </ul>

        <b-dropdown :size="size"
                    :disabled="disabled"
                    @shown="$el.querySelector('input').focus()"
                    :variant="dropdownVariant"
                    block
                    ref="type_head_dropdown"
                    toggle-class="text-left m-0 border-radius-0 border-0"
                    :style="dropdownStyle"
                    menu-class="scrollable-dropdown w-100">
            <template v-slot:button-content>
                <span class="d-block">{{placeholder}}</span>
            </template>
            <div class="px-2">
                <b-form-input
                    @keypress.enter.prevent=""
                    autofocus
                    v-model="query"
                    @input="getItems"
                    type="search"
                    :size="size || 'sm'"
                    style="border: 1px solid lightgray !important"
                    :class="inputClass"
                    :placeholder="placeholder"
                    :autocomplete="autocomplete"
                ></b-form-input>
            </div>
            <b-dropdown-item
                v-for="(option,option_key) in getOptions"
                :key="option_key"
                @click="onOptionClick(option)"
            >
                <slot name="option" v-bind:item="option">
                    {{ option }}
                </slot>
            </b-dropdown-item>
            <b-dropdown-text v-if="options.length === 0">
                {{emptyOptionText}}
            </b-dropdown-text>
        </b-dropdown>
    </div>
</template>

<script>
    export default {
        props: {
            value: {
                type: Array,
                default: () => []
            },
            api_url: {
                type: String,
                default: null,
                required: true
            },
            placeholder: {
                type: String,
                default: 'Search Items'
            },
            size: {
                type: String,
                default: ''
            },
            autocomplete: {
                type: String,
                default: 'off'
            },
            dropdownVariant: {
                type: String,
                default: 'outline-secondary'
            },
            tagVariant: {
                type: String,
                default: 'dark'
            },
            tagCloseVariant: {
                type: String,
                default: 'secondary'
            },
            emptyOptionText: {
                type: String,
                default: 'No items available to select'
            },
            isDuplicate: {
                type: Function,
                default(items = [], item) {
                    return items.includes(item);
                }
            },
            clearOptionsOnDropdownHidden: {
                type: Boolean,
                default: false
            },
            clearSearchOnDropdownHidden: {
                type: Boolean,
                default: true
            },
            clearOptionsOnItemSelected: {
                type: Boolean,
                default: false
            },
            clearSearchOnItemSelected: {
                type: Boolean,
                default: true
            },
            closeDropdownOnSelect: {
                type: Boolean,
                default: false
            },
            showDuplicateOptions: {
                type: Boolean,
                default: false
            },
            disableTags: {
                type: Boolean,
                default: false
            },
            disabled: {
                type: Boolean,
                default: false
            },
            inputClass: {
                type: String | Array,
                default: () => []
            },
            preloadOptions: {
                type: Boolean,
                default: false
            },
            postParams: {
                type: Object,
                default: () => {
                    return {}
                }
            },
            dropdownStyle: {
                type: Object | String,
                default: () => {
                }
            }
        },
        data() {
            return {
                open_dropdown: false,
                options: [],
                query: '',
                selected_tags: []
            }
        },
        mounted() {
            setTimeout(() => {
                this.$set(this, 'selected_tags', this.value);
            }, 10);
            if (this.preloadOptions) {
                this.getItems();
            }
        },
        computed: {
            getOptions() {
                if (this.showDuplicateOptions) {
                    return this.options;
                }
                return this.options.filter(option => {
                    return !this.isDuplicate(this.selected_tags, option);
                });
            },
        },
        watch: {
            'selected_tags': {
                deep: true,
                handler(v) {
                    this.$emit('input', v)
                }
            }
        },
        methods: {
            onOptionClick(option) {
                if (!this.isDuplicate(this.selected_tags, option)) {
                    this.selected_tags.push(option);
                    if (this.clearOptionsOnItemSelected) {
                        this.options = [];
                    }
                    if (this.clearSearchOnItemSelected) {
                        this.query = '';
                    }
                    // this.$emit('input', this.selected_tags);
                }
            },
            clearOptions() {
                this.$set(this, 'options', []);
            },
            reset() {
                this.$set(this, 'selected_tags', []);
            },
            removeTag(index) {
                this.selected_tags.splice(index, 1);
                // this.$emit('input', this.selected_tags);
            },

            getItems(e) {
                let query = {query: this.query};
                if (this.postParams) {
                    query = {...query, ...this.postParams};
                }
                axios
                    .post(this.api_url, query)
                    .then(res => {
                        this.options = res.data || [];
                    })
                    .catch(err => {
                        this.options = [];
                        console.log(err.response);
                    });
            }
        }
    }
</script>
<style lang="scss">
    .scrollable-dropdown {
        max-height: 300px;
        overflow-y: auto;
    }

    .typehead {
        .dropdown-toggle::after {
            float: right;
            margin-top: 5px;
            display: none;
        }

        .border-radius-0 {
            border-radius: 0 !important;
        }
    }
</style>
