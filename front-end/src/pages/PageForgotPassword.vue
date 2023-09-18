<template>
  <q-page padding class="row justify-center items-center forgotpassword-bg">
      <div class="col-12 col-md-5 col-lg-5">
    <q-card class="tabs">
        <q-card class="absolute bg-blue"
          style="top: 0; left: 12px; transform: translateY(-50%);">
          <q-card-section>
            <q-icon
            color="white"
            size="50px"
            name="contacts" 
            />
          </q-card-section>
        </q-card>

        <q-card-section class="q-pt-xs">
          <div class="text-h4" style="margin-left: 90px;">Forgot Password</div>
        </q-card-section>

        <q-card-section>
          <form 
          class="bg-white"
          @submit.prevent="submitForm">
            <div class="row q-col-gutter-md">
              <div class="col-12 col-md-12 col-lg-12">
                <q-input 
                v-model="formData.email"
                :rules="[ val => isValidEmailAddress(val) || 'Please enter a valid email address']"
                ref="email"
                lazy-rules
                class="col"
                label="Email *" 
                stack-label  />
              </div>
              
              <div class="col-12 col-md-12 col-lg-12">
                  <q-btn
                  class="full-width"
                  color="blue"
                  label="Submit" 
                  type="submit"/>
              </div>
              <div class="col-12 col-md-12 col-lg-12 text-center">
                <router-link to="/login" style="text-decoration: none; color: blue; .shadow-3;">BACK TO LOGIN</router-link>
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
                email:'',
                password: ''
            }
        }
  },
  components:{

  },
  methods: {
    ...mapActions("auth", ["forgotpassword"]),

    isValidEmailAddress(email) {
      var re = /^(([^<>()[\]\\.,;:\s@"]+(\.[^<>()[\]\\.,;:\s@"]+)*)|(".+"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA-Z\-0-9]+\.)+[a-zA-Z]{2,}))$/
      return re.test(String(email).toLowerCase())
    },
    submitForm() {
      this.$refs.email.validate()
      if (!this.$refs.email.hasError) {
         console.log('user forgot the password')

         this.forgotpassword(
           {
              email: this.formData.email,
           })
        .then(response => {
          this.$q.notify({
            progress: true,
            message: "Link to reset password sent to your Mail",
            position: 'top-right',
            color:'positive'
    })
            
            //this.$router.push("/post");
            // alert("Login Success")

            // redirect to home page
            // this.$router.push(process.env.LOGIN_REDIRECT_URL);

        })
        .catch(e => {
          //alert("Error")
            this.$q.notify({
            progress: true,
            message: "This Email is not registered",
            position: 'top-right',
            color:'negative'
    })

          console.log("Error", e)
        })
      }
    }
  }
}
</script>

<style>
  .forgotpassword-bg {
 background-image: url("https://wallpapercave.com/wp/wp9475657.jpg");
  height: 500px; /* You must set a specified height */
  background-position: center; /* Center the image */
  background-repeat: no-repeat; /* Do not repeat the image */
  background-size: cover;
 background-color: #cccccc;
}
</style>
