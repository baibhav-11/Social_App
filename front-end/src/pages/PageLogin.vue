<template>
  <q-page padding class="row justify-center items-center login-bg">
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
          <div class="text-h4" style="margin-left: 90px">User Login</div>
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
                <q-btn
                  class="full-width"
                  color="blue"
                  label="login"
                  type="submit"
                />
              </div>
              <div class="col-12 col-md-12 col-lg-12 text-center">
                <router-link
                  to="/register"
                  style="text-decoration: none; color: blue; .shadow-3;"
                  >REGISTER</router-link
                >
              </div>
              <div class="col-12 col-md-12 col-lg-12 text-center">
                <router-link
                  to="/ForgotPassword"
                  style="text-decoration: none; color: blue"
                  >FORGOT PASSWORD</router-link
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
      },
      visibility: false,
    };
  },
  components: {
    // 'login'
    // :require('components/Auth/Login.vue').
    // default
  },
  methods: {
    ...mapActions("auth", ["login"]),
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
    submitForm() {
      console.log("formsubmitted");
      // this.$refs.email.validate()
      // this.$refs.password.validate()
      // if (!this.$refs.email.hasError && !this.$refs.password.hasError) {
      //    console.log('login the user')
      // }

      this.login({
        email: this.formData.email,
        password: this.formData.password,
      })
        .then((response) => {
          this.$router.push({ name: "post" });
        })
        .catch((e) => {
          if (this.formData.email == "" && this.formData.password == "")
            alert("Fill the empty fields");
          else {
            alert("Credentials does not match with our records");
          }
          // alert(e.response.data)

          console.log("Error", e);
        });
    },
  },
};
</script>

<style>
.login-bg {
  background-image: url("https://wallpapercave.com/wp/wp9475657.jpg");
  height: 500px; /* You must set a specified height */
  background-position: center; /* Center the image */
  background-repeat: no-repeat; /* Do not repeat the image */
  background-size: cover;
  background-color: #cccccc;
}
</style>
