<template>
    <div>
        {{saleId}}
    </div>
</template>
<script>

    export default {
        props: {
            saleId: {
                type: Number,
                default: () => null
            }
        }
    }
</script>
