<template>
    <div class="dropdown" ref="menu" v-cloak>
        <slot name="button" :toggle="toggle"/>

        <div class="dropdown-arrow" :style="{left: `${arrowPosition}px`}" v-if="isOpen"/>
        <div class="dropdown-menu" :class="position" v-if="isOpen" v-away="close">
            <slot name="menu"/>
        </div>
    </div>
</template>

<script>
    export default {
        props: {
            position: {
                type: String,
                default: 'center'
            }
        },
        data() {
            return {
                isOpen: false,
                arrowPosition: 0
            }
        },
        methods: {
            close() {
                this.isOpen = false;
            },
            toggle() {
                this.isOpen = !this.isOpen;
            },
            calcArrowPosition() {
                const containerPosition = this.$refs.menu.getBoundingClientRect();

                this.arrowPosition = (containerPosition.width / 2) - 5;
            }
        },
        mounted() {
            this.calcArrowPosition();
        }
    }
</script>
