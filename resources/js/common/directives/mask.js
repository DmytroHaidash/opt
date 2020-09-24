import IMask from 'imask';

export default (el, binding) => {
  IMask(el, {
    mask: binding.value
  })
}
