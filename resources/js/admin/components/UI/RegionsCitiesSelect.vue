<template>
    <fieldset>
        <div class="form-group">
            <label for="region" class="form-label">
                <span>{{ $trans.get('shop.region') }}</span>
            </label>
            <v-select
                name="region_id"
                id="region"
                :options="regions"
                label="name"
                @input="getSettlements"
                v-model="selected.region"
            />
        </div>

        <div class="form-group" v-if="selected.region">
            <label for="city" class="form-label">
                <span>{{ $trans.get('shop.settlement') }}</span>
            </label>
            <v-select
                name="city_id"
                id="city"
                :options="settlements"
                label="name"
                v-model="selected.city"
            />
            <input type="hidden" name="region_id" :value="selected.region.id">
            <input type="hidden" name="city_id" :value="selected.city.id" v-if="selected.city">
        </div>
    </fieldset>
</template>

<script>
    export default {
        props: {
            region: Number | String,
            city: Number | String
        },

        data() {
            return {
                regions: [],
                settlements: [],
                selected: {
                    region: null,
                    city: null,
                }
            }
        },

        methods: {
            async getRegions() {
                await axios.get('/locations')
                    .then(({data}) => {
                        this.regions = data;

                        if (this.region) {
                            this.selected.region = this.regions.find(r => r.id === +this.region);
                            this.getSettlements(this.selected.region);
                        }
                    });
            },

            async getSettlements({id}) {
                await axios.get('/locations/'.concat(id))
                    .then(({data}) => {
                        this.settlements = data;

                        if (this.city) {
                            this.selected.city = this.settlements.find(c => c.id === +this.city);
                        }
                    });
            }
        },

        mounted() {
            this.getRegions();
        }
    }
</script>
