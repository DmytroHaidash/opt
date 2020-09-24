export default {
  props: {
    approved: Boolean|Number
  },

  data() {
    return {
      isApproved: this.approved
    }
  },

  methods: {
    toggle() {
      this.isApproved = !this.isApproved;
    }
  }
}
