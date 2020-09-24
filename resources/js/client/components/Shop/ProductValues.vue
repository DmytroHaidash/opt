<template>
    <fieldset>
        <div v-for="(val, index) in items" :key="index">
            <div class="form-group flex -mx-2 ">
                <div class="px-2">
                    <label for="units" class="form-label"><span>{{ trans.units }}</span></label>
                    <select name="values[unit_id][]" id="units" class="form-control mb-0" v-model="val.unit">
                        <option v-for="unit in units" :value="unit.id">{{ unit.name }}</option>
                    </select>
                </div>
                <div class="px-2 w-full">
                    <label for="price" class="form-label"><span>{{ trans.price }}</span></label>
                    <input name="values[price][]" id="price" type="number" class="form-control" step="0.01"
                           v-model="val.price" required>
                </div>
            </div>
            <div class="form-group flex -mx-2">
                <div class="px-2 w-full">
                    <label for="step" class="form-label"><span>{{ trans.step }}</span></label>
                    <input name="values[step][]" id="step" type="number" class="form-control" v-model="val.step"
                           required>
                </div>
                <div class="px-2 w-full">
                    <label for="min" class="form-label"><span>{{ trans.min }}</span></label>
                    <input name="values[min][]" id="min" type="number" class="form-control" step="0.1" v-model="val.min"
                           required>
                </div>
                <div class="px-2 w-full">
                    <label for="max" class="form-label"><span>{{ trans.max }}</span></label>
                    <input name="values[max][]" id="max" type="number" class="form-control" step="0.1"
                           v-model="val.max">
                </div>
                <div class="self-center pt-3" :class="{'-mr-4': index > 0}">
                    <input type="hidden" name="values[id][]" :value="val.id">

                    <!--  <button type="button" class="text-red-600" v-if="index > 0" @click.prevent="removeItem(index)">
                          <svg class="w-4 h-4 fill-current">
                              <use xlink:href="/images/icons/admin.svg#trash"/>
                          </svg>
                      </button>-->
                </div>
            </div>
        </div>

        <div class="mt-4 text-right">
            <input type="hidden" name="product-deletions" :value="deletions.join(',')">
            <!--
                        <button type="button" class="button button&#45;&#45;primary-outline" @click.prevent="addMore">
                            {{ trans.add }}
                        </button>-->
        </div>
    </fieldset>
</template>

<script>
    import ProductValue from "../../../common/models/ProductValue";

    export default {
        data() {
            return {
                items: this.values,
                deletions: []
            }
        },

        methods: {
            addMore() {
                this.items.push(new ProductValue(null, this.units[0].id, null));
            },

            removeItem(index) {
                if (this.items[index].id) this.deletions.push(this.items[index].id);

                this.items.splice(index, 1);
            }
        },

        props: {
            trans: Object,
            units: Array,
            values: {
                type: Array,
                default() {
                    return [new ProductValue(null, this.units[0].id, null)];
                }
            }
        }
    }
</script>
