<template>
  <div>
    <p>
      {{ formattedBody }}
      <button @click="showingFullText = !showingFullText">
        Read {{ showingFullText ? "Less" : "More" }}
      </button>
    </p>
  </div>
</template>

<script>
export default {
  data() {
    return {
      showingFullText: false,
      detail:""
    };
  },

  computed: {
    formattedBody() {
      if (this.showingFullText) {
        return this.detail;
      }

      return `${this.detail.slice(0, 100).trim()}...`;
    }
  }
};
</script>