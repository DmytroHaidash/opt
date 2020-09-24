<template>
    <tbody>
    <tr v-if="loading">
        <td colspan="8" class="p-3">
            <loading/>
        </td>
    </tr>

    <template v-else-if="!loading && contents.length">
        <div is="cart-item" v-for="item in contents" :item="item" :key="item.id"/>

        <tr>
            <td colspan="8" class="p-3">
                <div class="flex flex-wrap justify-end">
                    <h2 class="text-3xl font-bold font-slab">{{ total }} грн</h2>
                    <div class="ml-6">
                        <a href="/checkout" class="button button--primary">
                            {{ $trans.get('shop.checkout.start') }}
                        </a>
                    </div>
                </div>
            </td>
        </tr>
    </template>

    <tr v-else>
        <td colspan="8" class="p-3 text-center">
            <h2 class="font-bold font-slab text-xl mb-4">
                {{ $trans.get('shop.empty') }}
            </h2>
            <a href="/shop" class="button button--primary-outline">
                {{ $trans.get('shop.back_to_shop') }}
            </a>
        </td>
    </tr>
    </tbody>
</template>

<script>
    import {mapState} from 'vuex';
    import CartItem from "./CartItem";

    export default {
        components: {
            CartItem
        },
        computed: {
            ...mapState({
                contents: state => state.cart.contents,
                total: state => state.cart.total,
                loading: state => state.loading
            })
        },
    }
</script>
