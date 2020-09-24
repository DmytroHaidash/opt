<template>
    <button class="w-8 h-8" @click.prevent="toggle">
        <svg class="fill-current w-full h-full">
            <use :xlink:href="icon"></use>
        </svg>
    </button>
</template>

<script>
    export default {
        props: {
            type: String,
            model: String | Number,
            checked: Boolean
        },

        data() {
            return {
                isChecked: this.checked
            }
        },

        computed: {
            icon() {
                return '/images/icons/client.svg#bookmark-' + (this.isChecked ? 'filled' : 'empty');
            }
        },

        methods: {
            toggle() {
                axios.post('/favorites', {
                    type: this.type,
                    model: this.model
                }).then(({data}) => this.isChecked = data.status === 'added')
            }
        }
    }
</script>
