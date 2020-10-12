<template>
    <b-modal @hidden="$router.go(-1),$emit('reset',true)"
             v-model="visible"
             size="lg"
             header-bg-variant="dark"
             header-text-variant="light"
             no-body
             :title="(form.id?'Edit ':'Add ')+'Subcategory'"
             lazy>
        <form @submit.prevent="hitSubmit" ref="theForm">
            <b-form-group :label="__('name','Name')+' *'">
                <b-form-input v-model="form.name" :placeholder="__('name','Name')" :required="true"/>
            </b-form-group>
            <b-form-group :label="__('description','Description')">
                <b-form-textarea :placeholder="__('description','Description')" v-model="form.description"/>
            </b-form-group>
        </form>
        <template v-slot:modal-footer="{cancel}">
            <b-button variant="primary" ref="submitBtn" @click="onSubmit">
                {{__('submit','SUBMIT')}}
            </b-button>
            <b-button @click="cancel()">
                {{__('cancel','CANCEL')}}
            </b-button>
        </template>
        <!--        <pre v-html="form"/>-->
    </b-modal>

</template>

<script>
    import add_form from "@/partials/add_form";
    import {slugify, objPhotoUrl} from "@/partials/datatable";

    export default {
        mixins: [add_form],
        props: {
            submit_url: {
                type: String,
                default: () => route('Backend.Subcategories.Store').url()
            }
        },
        methods: {
            slugify,
            objPhotoUrl
        }
    }
</script>

