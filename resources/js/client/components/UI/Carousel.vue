<template>
    <section v-cloak>
        <swiper class="swiper gallery-top mb-2" :options="swiperOptionTop" ref="swiperTop">
            <swiper-slide
                v-for="slide in slides"
                class="bg-center bg-cover rounded pt-squire"
                :style="{backgroundImage: `url('${slide.src}')`}"
                :key="slide.id"
            />

            <div class="swiper-button-next swiper-button-white" slot="button-next"></div>
            <div class="swiper-button-prev swiper-button-white" slot="button-prev"></div>
        </swiper>

        <swiper class="swiper gallery-thumbs" :options="swiperOptionThumbs" ref="swiperThumbs">
            <swiper-slide
                class="bg-center bg-cover rounded"
                :style="{backgroundImage: `url('${slide.src}')`}"
                v-for="slide in slides"
                :key="slide.id"
            />
        </swiper>
    </section>
</template>

<script>
    import {Swiper, SwiperSlide} from 'vue-awesome-swiper';

    export default {
        props: {
            slides: Array
        },
        components: {
            Swiper,
            SwiperSlide
        },
        data() {
            return {
                swiperOptionTop: {
                    loop: true,
                    loopedSlides: this.slides.length,
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev'
                    }
                },
                swiperOptionThumbs: {
                    loop: true,
                    loopedSlides: this.slides.length,
                    centeredSlides: true,
                    slidesPerView: 'auto',
                    touchRatio: 0.2,
                    slideToClickedSlide: true,
                    spaceBetween: 10
                }
            }
        },
        mounted() {
            this.$nextTick(() => {
                const swiperTop = this.$refs.swiperTop.$swiper
                const swiperThumbs = this.$refs.swiperThumbs.$swiper
                swiperTop.controller.control = swiperThumbs
                swiperThumbs.controller.control = swiperTop
            })
        }
    }
</script>

<style lang="scss">
    .gallery {
        &-thumbs {
            height: theme('spacing.16');

            .swiper-slide {
                width: theme('spacing.16');
                height: 100%;
                opacity: 0.4;
            }

            .swiper-slide-active {
                opacity: 1;
            }
        }
    }
</style>
