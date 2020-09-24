<template>
    <fieldset>
        <div class="form-group">
            <label for="category_id" class="form-label">
                <span>{{ trans.categories }}</span>
            </label>
            <v-select
                name="category"
                id="category_id"
                :options="categories"
                label="name"
                @input="getSubcategory"
                v-model="selected.category"
            >
                <template #search="{attributes, events}" v-if="required">
                    <input
                        class="vs__search"
                        :required="!selected.category"
                        v-bind="attributes"
                        v-on="events"
                    />
                </template>
            </v-select>
        </div>

        <div class="form-group" v-if="subcategories.length">
            <label for="subcategory_id" class="form-label">
                <span>{{ trans.subcategory }}</span>
            </label>
            <v-select
                name="subcategory"
                id="subcategory_id"
                :options="subcategories"
                label="name"
                v-model="selected.subcategory"
            >
                <template #search="{attributes, events}" v-if="required">
                    <input
                        class="vs__search"
                        :required="!selected.subcategory"
                        v-bind="attributes"
                        v-on="events"
                    />
                </template>
            </v-select>

        </div>
        <input type="hidden" name="category" :value="selected.category.id" v-if="selected.category">
        <input type="hidden" name="subcategory" :value="selected.subcategory.id" v-if="selected.subcategory">
    </fieldset>
</template>

<script>
    export default {
        props: {
            category: Number | String,
            subcategory: Number | String,
            trans: Object,
            required: Boolean
        },

        data() {
            return {
                categories: [],
                subcategories: [],
                selected: {
                    category: null,
                    subcategory: null,
                }
            }
        },

        methods: {
            async getCategories() {
                await axios.get('/category')
                    .then(({data}) => {
                        this.categories = data;

                        if (this.category) {
                            this.selected.category = this.categories.find(r => r.id === +this.category);
                            this.getSubcategory(this.selected.category);
                        }
                    });
            },

            async getSubcategory({id}) {
                await axios.get('/category/'.concat(id))
                    .then(({data}) => {
                        this.subcategories = data;

                        if (this.subcategory) {
                            this.selected.subcategory = this.subcategories.find(c => c.id === +this.subcategory);
                        }
                    });
            }
        },

        mounted() {
            this.getCategories();
        }
    }
</script>
