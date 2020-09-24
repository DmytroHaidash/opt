<template>
    <div>
        <nav class="flex justify-end mb-6 border-b-2">
            <button
                type="button"
                class="p-1 inline-flex uppercase text-sm"
                :class="{'text-red-600 font-semibold': locale === current}"
                v-for="locale in locales"
                :key="locale"
                @click.prevent="handleLocale(locale)"
            >
                {{ locale }}
            </button>
        </nav>

        <slot :current="current" />
    </div>
</template>

<script>
    import {locales, current} from '../../../common/helpers/locales';

    export default {
        data() {
            return {
                locales,
                current
            }
        },

        methods: {
            handleLocale(locale) {
                this.current = locale;
            }
        }
    }
</script>
