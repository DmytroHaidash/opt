require('../bootstrap');

import Vue from 'vue';
import Mask from '../common/directives/mask';
import Trans from "../common/plugins/trans";
import vSelect from 'vue-select';

import Locales from "./components/UI/Locales";
import ProductValues from "./components/Helpers/ProductValues";
import MediaUpload from "./components/UI/MediaUpload";
import Conditional from "./components/Helpers/Conditional";
import NestedChecker from "./components/Helpers/NestedChecker";
import RegionsCitiesSelect from "./components/UI/RegionsCitiesSelect";
import CategoriesSelect from "./components/UI/CategoriesSelect";

Vue.use(Trans);
Vue.directive('mask', Mask);
Vue.component('v-select', vSelect);

new Vue({
  el: "#root",
  components: {
    Locales,
    Conditional,
    NestedChecker,
    ProductValues,
    MediaUpload,
    RegionsCitiesSelect,
    CategoriesSelect
  }
});
