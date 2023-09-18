<template>
  <q-page padding class="row justify-center items-center reset-bg">
    <div class="col-12 col-md-5 col-lg-5">
      <q-card class="tabs">
        <q-card
          class="absolute bg-blue"
          style="top: 0; left: 12px; transform: translateY(-50%)"
        >
          <q-card-section>
            <q-icon color="white" size="50px" name="contacts" />
          </q-card-section>
        </q-card>

        <q-card-section class="q-pt-xs">
          <div class="text-h4" style="margin-left: 90px">Reset Password</div>
        </q-card-section>

        <q-card-section>
          <form class="bg-white" @submit.prevent="submitForm">
            <div class="row q-col-gutter-md">
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
                  label="reset"
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
import { mapActions } from "vuex";

export default {
  data() {
    return {
      formData: {
        email: "",
        password: "",
        confirmpassword: "",
      },
      visibility: false,
      c_visibility: false,
    };
  },
  components: {
    // 'login'
    // :require('components/Auth/Login.vue').
    // default
  },
  methods: {
    ...mapActions("auth", ["resetpassword"]),
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
      console.log("formsubmitted");

      this.resetpassword({
        email: this.formData.email,
        password: this.formData.password,
        password_confirmation: this.formData.confirmpassword,
        token: this.$route.query.token,
      })
        .then((response) => {
          this.$q.notify({
            progress: true,
            message: "Password reset sucessfully",
            position: "top-right",
            color: "positive",
          });
          //alert("Password reset sucessfully");
          this.$router.push("/login");
        })
        .catch((e) => {
          this.$q.notify({
            progress: true,
            message: "Check  if the email is correct and both the passwords is matching",
            position: "top-right",
            color: "negative",
          });
          //alert(e.response.data);

          console.log("Error", e);
        });
    },
  },
};
</script>

<style>
.reset-bg {
  background-image: url("https://wallpapercave.com/wp/wp9475657.jpg");
  height: 500px; /* You must set a specified height */
  background-position: center; /* Center the image */
  background-repeat: no-repeat; /* Do not repeat the image */
  background-size: cover;
  background-color: #cccccc;
}
</style>
