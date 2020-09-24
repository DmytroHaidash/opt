<template>
    <a :href="route" class="relative flex items-center" :class="{'opacity-50': loading}" v-cloak>
        <span class="w-5 h-5 rounded-full bg-orange-600 text-white
        border-2 border-white absolute left-0 inset-y-0 my-auto -ml-2 z-10
        text-xs font-bold inline-flex items-center justify-center">
            {{ contents.length }}
        </span>

        <svg class="fill-current w-8 h-8">
            <use xlink:href="/images/icons/client.svg#shopping-bag"></use>
        </svg>

        <span class="font-bold text-sm ml-1 whitespace-no-wrap">
            {{ total }} грн
        </span>
    </a>
</template>

<script>
    import {mapState} from 'vuex';

    export default {
        computed: {
            ...mapState({
                contents: state => state.cart.contents,
                total: state => state.cart.total,
                loading: state => state.loading
            })
        },
        props: {
            route: {
                type: String,
                required: true
            }
        }
    }
</script>
