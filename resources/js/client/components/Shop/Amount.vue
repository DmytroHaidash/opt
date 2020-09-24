<template>
    <div class="form-group">
        <label :for="`quantity-${_uid}`" class="form-label">
            <span>{{ $trans.get('shop.quantity') }}</span>
        </label>

        <div class="flex">
            <input
                type="text"
                :id="`quantity-${_uid}`"
                :readonly="readonly"
                v-model.number="quantity"
                class="form-control border-r-0 rounded-r-none"
                @change="inputs"
            >

            <div class="border-2 border-l-0 rounded-r flex flex-col self-stretch border-current">
                <button
                    type="button"
                    class="px-1 leading-none flex-1 hover:bg-gray-300"
                    @click.prevent="increment">
                    +
                </button>
                <button
                    type="button"
                    class="px-1 leading-none flex-1 hover:bg-gray-300"
                    @click.prevent="decrement">
                    -
                </button>
            </div>
        </div>
    </div>
</template>

<script>
    import {debounce} from 'debounce';

    export default {
        props: {
            min: Number,
            max: Number,
            step: Number,
            value: Number,
            readonly: Boolean
        },
        methods: {
            increment() {
                this.oldValue = this.quantity;

                if (+this.quantity < +this.max) {
                    this.quantity += +this.step;
                    this.$emit('input', this.quantity);
                }
            },
            decrement() {
                this.oldValue = this.quantity;

                if (+this.quantity > +this.min) {
                    this.quantity -= +this.step;
                    this.$emit('input', this.quantity);
                }
            },
            inputs() {
                if (event.target.value) {
                    if (event.target.value < +this.min) {
                        this.quantity = this.min;
                        this.$emit('input', this.quantity);
                    } else if (event.target.value > +this.max) {
                        this.quantity = this.max;
                        this.$emit('input', this.quantity);
                    }
                }
            }
        },
        data() {
            return {
                quantity: +this.value,
                oldValue: +this.value
            }
        },
        watch: {
            quantity: debounce(function (value, oldValue) {
                this.oldValue = oldValue;
                this.$emit('input', value);
            }, 300)
        }
    }
</script>
