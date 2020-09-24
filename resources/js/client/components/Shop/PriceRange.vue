<template>
    <range-slider
        v-model="range"
        :max="1000"
        :enable-cross="false"
    />
</template>

<script>
    import RangeSlider from 'vue-slider-component';

    export default {
        props: {
            min: String|Number,
            max: String|Number
        },
        components: {
            RangeSlider
        },
        data() {
            return {
                range: [this.min, this.max]
            }
        }
    }
</script>
