const lang = document.documentElement.lang;

const trans = Object.create(null);

/**
 * @param key
 * @param replace
 * @returns {T}
 */
trans.get = (key, replace = {}) => {
  let translation = key.split('.').reduce((t, i) => t[i] || null, window.i18n[lang]);

  for (let placeholder in replace) {
    translation = translation.replace(`:${placeholder}`, replace[placeholder]);
  }

  return translation;
};

export default {
  install: function (Vue) {
    Object.defineProperty(Vue.prototype, '$trans', {value: trans})
  }
}
