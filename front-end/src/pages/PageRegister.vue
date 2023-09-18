<template>
  <q-page padding class="row justify-center items-center register-bg">
    <div class="col-auto col-12 col-md-5 col-lg-5">
      <q-card class="tabs mg-mt-30px">
        <q-card
          class="col-auto absolute bg-blue .shadow-5"
          style="top: 19px; left: 12px; transform: translateY(-50%)"
        >
          <q-card-section>
            <q-icon
              class="col-auto"
              color="white"
              size="50px"
              name="contacts"
            />
          </q-card-section>
        </q-card>

        <q-card-section class="q-pt-xs">
          <div class="text-h4" style="margin-left: 90px">User Registration</div>
        </q-card-section>

        <q-card-section>
          <form class="bg-white" @submit.prevent="submitForm">
            <div class="row q-col-gutter-md">
              <div class="col-12 col-md-12 col-lg-12">
                
                <q-avatar size="130">
                  <q-img
                  v-if="uploaded_attachment_type == 'image'"
                  :src="attachment_preview"
                  />
                </q-avatar>

                <Uplaoder
                  v-model="formData.attachment"
                  icon="panorama"
                  title="Upload profile picture"
                  type="image"
                />
              </div>
              <div class="col-12 col-md-12 col-lg-12">
               <q-input
                  v-model="formData.firstname"
                  :rules="[
                    (val) => val.length >= 0 || 'Please enter your First Name',
                  ]"
                  ref="firstname"
                  lazy-rules
                  class="col"
                  label="First Name *"
                />
              </div>
              <div class="col-12 col-md-12 col-lg-12">
                <q-input
                  v-model="formData.lastname"
                  :rules="[
                    (val) => val.length >= 0 || 'Please enter your First Name',
                  ]"
                  ref="lastname"
                  lazy-rules
                  class="col"
                  label="Last Name *"
                />
              </div>
              <div class="col-12 col-md-12 col-lg-12">
                <q-input
                  v-model="formData.email"
                  :rules="[
                    (val) =>
                      isValidEmailAddress(val) ||
                      'Please enter a valid email address',
                  ]"
                  ref="email"
                  lazy-rules
                  class="col"
                  label="Email *"
                />
              </div>
              <div class="col-12 col-md-12 col-lg-12">
                <q-input
                  v-model="formData.password"
                  :rules="[
                    (val) =>
                      val.length >= 8 || 'Please enter at least 8 characters',
                  ]"
                  lazy-rules
                  ref="password"
                  :type="visibility ? 'text' : 'password'"
                  class="col bg-white"
                  label="Password "
                >
                  <template v-slot:append>
                    <q-btn
                      @click="viewPassword()"
                      round
                      dense
                      flat
                      :icon="visibility ? 'visibility_off' : 'visibility'"
                    />
                  </template>
                </q-input>
              </div>

              <div class="col-12 col-md-12 col-lg-12">
                <q-input
                  v-model="formData.confirmpassword"
                  :rules="[
                    (val) =>
                      val.length >= 8 || 'Please enter at least 8 characters',
                  ]"
                  lazy-rules
                  ref="confirmpassword"
                  :type="c_visibility ? 'text' : 'password'"
                  class="col bg-white"
                  label="Confirm Password "
                >
                  <template v-slot:append>
                    <q-btn
                      @click="viewConfirmPassword()"
                      round
                      dense
                      flat
                      :icon="c_visibility ? 'visibility_off' : 'visibility'"
                    />
                  </template>
                </q-input>
              </div>

              <div class="col-12 col-md-12 col-lg-12">
                <q-btn
                  class="full-width"
                  color="blue"
                  label="Register"
                  type="submit"
                />
              </div>
              <div class="col-12 col-md-12 col-lg-12 text-center">
                <router-link
                  to="/login"
                  style="text-decoration: none; color: blue"
                  >BACK TO LOGIN</router-link
                >
              </div>
            </div>
          </form>
        </q-card-section>
      </q-card>
    </div>
  </q-page>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
import Uplaoder from "components/Uploader.vue";

export default {
  data() {
    return {
      formData: {
        attachment: "",
        firstname: "",
        lastname: "",
        email: "",
        password: "",
        confirmpassword: "",
      },
      attachment_preview: "",
      uploaded_attachment_type: "",
      visibility: false,
      c_visibility: false,
    };
  },
  components: {
    Uplaoder,
  },
  computed: {},
  methods: {
    ...mapActions("auth", ["register"]),
    GetImage(e) {
      let image = e.target.files[0];
      let reader = new FileReader();
    },

    isValidEmailAddress(email) {
      var re =
        /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
      return re.test(String(email).toLowerCase());
    },
    viewPassword() {
      if (this.visibility) {
        this.visibility = false;
      } else {
        this.visibility = true;
      }
    },
    viewConfirmPassword() {
      if (this.c_visibility) {
        this.c_visibility = false;
      } else {
        this.c_visibility = true;
      }
    },
    submitForm() {
      this.$refs.email.validate();
      this.$refs.password.validate();
      if (
        !this.$refs.email.hasError &&
        !this.$refs.password.hasError &&
        !this.$refs.firstname.hasError &&
        !this.$refs.lastname.hasError &&
        !this.$refs.confirmpassword.hasError
      ) {
        console.log("register the user");

        this.register({
          attachment: this.formData.attachment,
          attachment_preview: this.attachment_preview,
          type: this.uploaded_attachment_type,
          first_name: this.formData.firstname,
          last_name: this.formData.lastname,
          email: this.formData.email,
          password: this.formData.password,
          c_password: this.formData.confirmpassword,
        })
          .then((response) => {
            this.$router.push("/login");
            this.$q.notify({
              progress: true,
              message: "Registered Successfully",
              position: "top-right",
              color: "positive",
            });
            // alert("Registered Successfully");
          })
          .catch((e) => {
            let pattern = /Duplicate entry/i;
            let test = e.response.data.message;
            if (this.formData.firstname == "" && this.formData.lastname == "")
              alert("Fill the empty fields");
            else {
              if (this.formData.firstname == "")
                alert("First Name is required");
              if (this.formData.lastname == "") alert("Last Name is required");
            }
            if (this.formData.password != this.formData.confirmpassword) {
              if (this.formData.lastname != "" || this.formData.lastname != "")
                alert("Password do not match");
            } else {
              if (test.match(pattern)) {
                alert(test.match(pattern));
              }
            }
            console.log("Error", e);
          });
      }
    },
  },
  watch: {
    "formData.attachment"(file) {
      this.attachment_preview = URL.createObjectURL(file);
      let type = file.type.split("/");
      this.uploaded_attachment_type = type[0];
    },
  },
};
</script>

<style>
.register-bg {
  background-image: url("https://wallpapercave.com/wp/wp9475657.jpg");
  height: 500px; /* You must set a specified height */
  background-position: center; /* Center the image */
  background-repeat: no-repeat; /* Do not repeat the image */
  background-size: cover;
  background-color: #cccccc;
}
</style>
