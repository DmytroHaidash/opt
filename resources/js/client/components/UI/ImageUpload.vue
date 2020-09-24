<template>
    <fieldset>
        <input type="hidden" name="image-deletion" :value="markedToDelete" v-if="markedToDelete">
        <input
            :id="`upload-${_uid}`"
            class="invisible absolute"
            type="file"
            accept="image/*"
            :name="name"
            @change="handle"
        />

        <label :for="`upload-${_uid}`"
               class="rounded block relative bg-center bg-cover cursor-pointer pt-squire"
               :style="{backgroundImage: `url(${preview})`}">
            <button
                type="button"
                class="absolute top-0 right-0 mt-2 mr-2 text-red-600 hover:text-red-700 bg-white p-1 rounded-sm"
                @click.prevent="remove">
                <svg class="w-4 h-4 fill-current">
                    <use xlink:href="/images/icons/admin.svg#trash"/>
                </svg>
            </button>
        </label>
    </fieldset>
</template>

<script>
    export default {
        props: {
            name: {
                type: String,
                default: 'image'
            },
            image: Object|String,
            placeholder: {
                type: String,
                default: '/images/no-avatar.png'
            }
        },
        data() {
            return {
                markedToDelete: 0,
                resource: undefined
            }
        },
        computed: {
            preview() {
                return this.resource && !this.markedToDelete ? this.resource.src : this.placeholder;
            }
        },
        methods: {
            handle({target}) {
                const file = target.files[0];

                if (!file) return;

                const reader = new FileReader();
                reader.onload = ({target}) => {
                    this.resource = {
                        src: target.result
                    };
                };
                reader.readAsDataURL(file);
            },

            remove() {
                if (this.image) this.markedToDelete = this.resource.id;

                this.resource = undefined;
            }
        },
        created() {
            if (this.image) {
                if (typeof this.image === 'string') {
                    this.resource = JSON.parse(this.image)
                } else {
                    this.resource = this.image;
                }
            }
        }
    }
</script>
