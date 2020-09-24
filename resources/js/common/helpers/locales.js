const locales = document.querySelector('meta[name="locales"]').content.split(',');
const current = document.documentElement.lang;

export {locales, current}
