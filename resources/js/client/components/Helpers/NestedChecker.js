export default {
  props: {
    active: Array
  },

  data() {
    return {
      checked: this.active || [],
    }
  },

  methods: {
    handleParent({target}, self, children) {
      if (!target.checked) {
        this.checked = this.checked.filter(i => {
          return !children.includes(i) || i === self;
        });

        this.checked.splice(this.checked.indexOf(self));
      } else if (this.checked.indexOf(self) === -1) {
        this.checked.push(self);
      }
    },

    handleChild({target}, self, parent) {
      if (target.checked) {
        if (!this.checked.includes(parent)) {
          this.checked.push(parent);
        }

        this.checked.push(self);
      } else {
        this.checked.splice(this.checked.indexOf(self), 1);
      }
    }
  }
}
