<template>
  <div>
    <q-btn
      no-caps
      unelevated
      :label="title"
      align="left"
      class="full-width"
      @click="$refs.files.click()"
      text-color="blue-5"
      color="grey-3"
      :icon="icon"
    />
    <input
      :accept="type + '/*'"
      type="file"
      ref="files"
      style="display: none"
      @input="uploadAttachment"
    />
  </div>
</template>

<script>
export default {
  props: {
    value: String,
    icon: {
      type: String,
      default: "",
    },
    title: {
      type: String,
      default: "",
    },
    type: {
      type: String,
      default: "image",
    },
  },
  data() {
    return {};
  },
  methods: {
    uploadAttachment(event) {
      let file = event.target.files[0];
      this.$emit("input", file);
    },
  },
};
</script>
