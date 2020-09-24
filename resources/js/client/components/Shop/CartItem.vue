<template>
    <tr>
        <td class="p-3 w-1/6">
            <img :src=item.product.src class="rounded block inline-block w-20 h-12 mx-3" alt="">
        </td>
        <td class="p-3 w-full">

            <h2 class="font-bold font-slab text-xl">{{ item.product.title }}</h2>
            <p v-if="item.product.delivery" v-html="item.product.delivery"/>
        </td>
        <td class="p-3 font-bold font-slab whitespace-no-wrap">
            {{ `${item.quantity} ${item.value.unit}` }} *
            {{ item.value.price }}
        </td>
        <td class="p-3 min-w-xs">
            <amount
                :min="1"
                :max="item.value.max"
                :step="item.value.step"
                :value="item.quantity"
                @input="handleItemQuantity"
            />
        </td>
        <td class="p-3 font-bold font-slab whitespace-no-wrap min-w-xs text-right text-xl">
            {{ item.amount }}
        </td>
        <td class="p-3">
            <button
                class="text-red-600 hover:text-red-700"
                @click.prevent="removeFromCart(`/cart/${item.product.id}/${item.id}`)"
                :disabled="loading"
            >
                <loading class="w-5 h-5" color="#e53e3e" v-if="loading"/>

                <svg class="w-5 h-5 fill-current" v-else>
                    <use xlink:href="/images/icons/client.svg#trash"></use>
                </svg>
            </button>
        </td>
    </tr>
</template>

<script>
    import {mapActions, mapState} from 'vuex';
    import Amount from "./Amount";

    export default {
        components: {
            Amount
        },
        props: {
            item: Object
        },
        computed: {
            ...mapState(['loading'])
        },
        methods: {
            ...mapActions(['updateCartItem', 'removeFromCart']),

            handleItemQuantity(quantity) {
                this.updateCartItem({
                    route: `/cart/${this.item.product.id}/${this.item.id}`,
                    quantity
                })
            }
        }
    }
</script>
