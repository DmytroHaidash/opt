require('../bootstrap');

import Vue from 'vue';
import store from "./store";
import Trans from "../common/plugins/trans";
import Mask from '../common/directives/mask';
import {directive as onClickAway} from 'vue-clickaway';
import vSelect from 'vue-select';

import Dropdown from "./components/UI/Dropdown";
import Carousel from "./components/UI/Carousel";
import Loading from "./components/UI/Loading";
import Locales from "./components/UI/Locales";
import ImageUpload from "./components/UI/ImageUpload";
import MediaUpload from "./components/UI/MediaUpload";
import RegionsCitiesSelect from "./components/UI/RegionsCitiesSelect";
import Favourites from "./components/UI/Favourites";
import CategoriesSelect from "./components/UI/CategoriesSelect";

import Conditional from "./components/Helpers/Conditional";
import NestedChecker from "./components/Helpers/NestedChecker";

import ProductValues from "./components/Shop/ProductValues";
import CartContents from "./components/Shop/CartContents";
import CartButton from "./components/Shop/CartButton";
import Quantity from "./components/Shop/Quantity";

Vue.component('loading', Loading);
Vue.component('v-select', vSelect);

Vue.use(Trans);
Vue.directive('away', onClickAway);
Vue.directive('mask', Mask);

window.VBUS = new Vue();

new Vue({
  el: "#root",
  components: {
    Dropdown,
    CartButton,
    CartContents,
    Carousel,
    Quantity,
    Conditional,
    NestedChecker,
    Locales,
    ProductValues,
    ImageUpload,
    MediaUpload,
    Favourites,
    RegionsCitiesSelect,
    CategoriesSelect
  },
  mounted() {
    this.$store.dispatch('getCartContents');
  },
  store,
  methods: {
    toggle() {
      this.filters = !this.filters;
    }
  },
  data: {
    filters: false
  }
});
