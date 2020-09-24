import Vue from 'vue';
import Vuex from 'vuex';

Vue.use(Vuex);

export default new Vuex.Store({
  state: {
    loading: false,

    cart: {
      contents: [],
      total: 0
    }
  },
  mutations: {
    setCartContents(state, {contents, total}) {
      state.cart.contents = contents;
      state.cart.total = total;
    }
  },
  actions: {
    async getCartContents({state, commit}) {
      state.loading = true;

      await axios.get('/cart/contents')
        .then(({data}) => commit('setCartContents', data))
        .finally(() => state.loading = false);
    },

    async addToCart({state, commit}, {route, quantity, value}) {
      await axios.post(route, {quantity, value_id: value})
        .then(({data}) => commit('setCartContents', data))
        .finally(() => state.loading = false);
    },

    async removeFromCart({state, commit}, route) {
      await axios.delete(route)
        .then(({data}) => commit('setCartContents', data))
        .finally(() => state.loading = false);
    },

    async updateCartItem({state, commit}, {route, quantity}) {
      await axios.patch(route, {quantity})
        .then(({data}) => commit('setCartContents', data))
        .finally(() => state.loading = false);
    }
  }
});
