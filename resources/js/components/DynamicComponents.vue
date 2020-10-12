<template>
    <div class="container">
        <template  v-for="(c,k) in comps" >
            <b-form-group>
                <component :is="c"></component>
            </b-form-group>
        </template>
    </div>
</template>

<script>
    export default {
        name: "DynamicComponents",
        data() {
            return {
                comps: [
                    "b-form-input",
                    "b-form-textarea"
                ]
            }
        }
    }
</script>

<style scoped>

</style>
