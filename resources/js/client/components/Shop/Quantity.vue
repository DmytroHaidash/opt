<template>
    <form class="flex items-center -mx-1 mb-4" @submit.prevent="addToCart({route, quantity, value})" v-cloak>
        <div class="px-1 whitespace-no-wrap text-lg">
            <slot />
        </div>

        <div class="px-1 w-32 ml-auto">
            <amount
                class="mb-0 -mt-2"
                v-model="quantity"
                :min="min"
                :max="max"
                :step="step"
            />
        </div>

        <div class="px-1 w-6 text-center text-lg">{{ unit }}</div>

        <div class="px-1">
            <button class="button button--primary p-3" :disabled="loading">
                <loading class="w-5 h-5" color="#fff" v-if="loading" />

                <svg class="w-5 h-5 fill-current block" v-else>
                    <use :xlink:href="`/images/icons/client.svg#cart`"></use>
                </svg>
            </button>
        </div>
    </form>
</template>

<script>
    import {mapActions, mapState} from "vuex";
    import Amount from "./Amount"

    export default {
        components: {
            Amount
        },
        props: {
            step: Number|String,
            min: Number|String,
            max: Number|String|Boolean,
            value: Number|String,
            route: String,
            unit: String
        },
        computed: {
            ...mapState([
                'loading'
            ])
        },
        methods: {
            ...mapActions([
                'addToCart'
            ])
        },
        data() {
            return {
                quantity: +this.min,
            }
        }
    }
</script>
