<template>
    <fieldset class="border-2 rounded p-3">
        <input type="hidden" name="media-deletions" :value="filesToDelete.join(',')">
        <input type="hidden" name="media-order" :value="mediaOrder">

        <draggable v-model="images" class="flex flex-wrap -m-2" v-if="images.length">
            <div class="w-1/2 sm:w-1/3 lg:w-1/5 p-2" v-for="(image, index) in images" :key="index">
                <div class="rounded relative border-2 bg-center bg-cover cursor-move pt-squire"
                     :style="{backgroundImage: `url(${image.src})`}">
                    <button
                        type="button"
                        class="absolute top-0 right-0 mt-2 mr-2 text-red-600 hover:text-red-700 bg-white p-1 rounded-sm"
                        @click.prevent="remove(index)">
                        <svg class="w-4 h-4 fill-current">
                            <use xlink:href="/images/icons/admin.svg#trash"/>
                        </svg>
                    </button>
                </div>
            </div>
        </draggable>

        <label
            class="text-center block cursor-pointer font-semibold text-gray-600 hover:text-gray-800 transition duration-300"
            :class="{'mt-3 pt-3 border-t-2': images.length}">
            <input
                class="invisible absolute"
                type="file"
                accept="image/*"
                name="uploads[]"
                multiple
                @change="handle"
                ref="input"
            />

            {{ label }}
        </label>
    </fieldset>
</template>

<script>
    import Draggable from 'vuedraggable';

    export default {
        components: {
            Draggable
        },
        props: {
            items: Array,
            label: String
        },
        data() {
            return {
                images: this.items || [],
                files: [],
                filesToDelete: []
            }
        },
        computed: {
            mediaOrder() {
                return this.images.filter(({id}) => id).map(({id}) => id).join(',');
            }
        },
        methods: {
            handle({target}) {
                const fileList = Array.from(target.files);
                const dt = new DataTransfer();

                if (!fileList.length) return;

                this.files = [...this.files, ...fileList];
                this.files.forEach(file => dt.items.add(file));
                this.$refs.input.files = dt.files;

                fileList.forEach((item, index) => {
                    const reader = new FileReader();
                    reader.onload = ({target}) => {
                        this.images.push({
                            id: null,
                            src: target.result
                        });
                    };
                    reader.readAsDataURL(item);
                });
            },

            remove(index) {
                const itemToDelete = this.images[index];

                if (!itemToDelete) return;

                if (!!itemToDelete.id) {
                    this.filesToDelete.push(itemToDelete.id);
                } else {
                    const dt = new DataTransfer();

                    this.files.splice(itemToDelete.upload, 1);
                    this.files.forEach(file => dt.items.add(file));
                    this.$refs.input.files = dt.files;
                }

                this.images.splice(index, 1);
            }
        }
    }
</script>
