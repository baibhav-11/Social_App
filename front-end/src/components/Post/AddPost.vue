<template>
  <q-card>
    <q-card-section style="padding-bottom: 3px !important" class="row">
      <div class="text-h6">Create Post</div>
      <q-space />
      <q-btn flat dense label="Cancel" color="blue" v-close-popup />
    </q-card-section>
    <q-form @submit.prevent="submitForm">
      <q-card-section class="q-pt-none">
        <q-input @keypress="onTextChange($event);" type="textarea" class="fix-width" v-model="formData.detail">
        </q-input>
        <q-img
          v-if="uploaded_attachment_type == 'image'"
          :src="attachment_preview"
        />
        <q-video
        v-if="uploaded_attachment_type == 'video'"
        :ratio="16/9"
        :src="attachment_preview"
        />
        <Uplaoder
          v-model="formData.attachment"
          icon="panorama"
          title="Upload a photo"
          type="image"
        />

        <Uplaoder
          v-model="formData.attachment"
          icon="videocam"
          title="Upload a video"
          type="video"
        />
      </q-card-section>

      <q-card-actions align="right">
        <q-btn label="post" color="blue" v-close-popup type="submit" />
      </q-card-actions>
    </q-form>
  </q-card>
</template>

<script>
import { mapActions } from "vuex";
import Uplaoder from "components/Uploader.vue";

export default {
  data() {
    return {
      formData: {
        detail: "",
        attachment: "",
      },
      attachment_preview: "",
      uploaded_attachment_type: "",
    };
  },
  components: {
    Uplaoder,
  },
  methods: {
    ...mapActions("Post", ["Postcreate"]),
    GetImage(e) {
      let image = e.target.files[0];
      let reader = new FileReader();
    },
    GetVideo(e) {
      let video = e.target.files[0];
      let reader = new FileReader();
    },
    submitForm() {
      this.Postcreate(this.formData)
        .then((response) => {
          this.formData.detail = "";
          this.formData.attachment = "";
          (this.attachment_preview = ""), (this.uploaded_attachment_type = "");
        })
        .catch((e) => {
          if (this.formData.detail == "" && this.formData.attachment == "")
            alert("No item to post");
          console.log("Error", e);
        });
    },
    onTextChange(event) {
      var key = event.keyCode;
      if (key === 13) {
        this.formData.detail = this.formData.detail.replace(/(^|\r\n|\n)([^*]|$)/g, "$1$2");
        return false;
      }
      else {
          return true;
      }
    }
  },
  watch: {
    "formData.attachment"(file) {
      this.attachment_preview = URL.createObjectURL(file);
      let type = file.type.split("/");
      this.uploaded_attachment_type = type[0];
    }
  },
};
</script>

<style>
.fix-width {
  margin-top: -10px !important;
}
</style>
