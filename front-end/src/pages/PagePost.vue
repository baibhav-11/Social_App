<template v-slot:before>
  <q-page padding class="row justify-center">
    <q-header class="bg-white" reveal elevated>
      <q-toolbar>
        <q-icon color="positive" flat name="question_answer" size="20px" />
        <q-toolbar-title class="text-green">
          {{ authUser.first_name }} {{ authUser.last_name }}
        </q-toolbar-title>

        <q-toolbar-title class="absolute-center text-blue">
          Social App</q-toolbar-title
        >

        <q-btn
          class="absolute-right"
          color="blue"
          flat
          dense
          @click="onClickLogout()"
          label="Logout"
          icon="logout"
        />
      </q-toolbar>
    </q-header>

    <div class="col-12 col-md-5 col-lg-5">
      <q-card>
        <q-card-section>
          <div class="row q-col-gutter-md">
            <div>
              <q-avatar>
                <img
                  v-if="authUser.profile_picture"
                  :src="authUser.profile_picture"
                  :key="authUser.profile_picture"
                />
                <img
                  v-else
                  src="https://cdn.pixabay.com/photo/2013/07/13/12/07/avatar-159236_1280.png"
                />
              </q-avatar>
            </div>
            <div class="col-9 flex items-center">
              <q-btn
                class="full-width"
                @click="showAddPost = true"
                color="grey-3"
                unelevated
                no-caps
                align="left"
                text-color="grey-8"
                label="What's on your mind?"
              />
            </div>
          </div>
          <div class="row q-col-gutter-md">
            <div class="col-9 flex items-center">
              <q-btn
                flat
                class="round q-ml-xl"
                @click="showAddPost = true"
                color="grey-6"
                unelevated
                no-caps
                icon="panorama"
                size="17px"
              />
              <q-btn
                flat
                class="round"
                @click="showAddPost = true"
                align="left"
                color="grey-6"
                unelevated
                no-caps
                icon="videocam"
                size="20px"
              />
            </div>
          </div>
        </q-card-section>
      </q-card>

      <PostCard
        v-for="(post, index) in posts"
        :key="index"
        v-bind:post="post"
      />
    </div>

    <q-dialog v-model="showAddPost">
      <AddPost style="width: 700px; max-width: 80vw" />
    </q-dialog>
  </q-page>
</template>

<script>
import AddPost from "components/Post/AddPost.vue";
import PostCard from "components/Post/PostCard.vue";
import { mapActions, mapGetters } from "vuex";
import { LocalStorage as SessionStorage, Loading } from "quasar";


export default {
  data() {
    return {
      showAddPost: false,
    };
  },
  components: {
    AddPost,
    PostCard,
  },

  computed: {
    ...mapGetters("Post", ["posts"]),
    ...mapGetters("auth", ["authUser"]),
  },
  
  created() {
    this.getpost();
  },

  methods: {
    ...mapActions("Post", ["Postget"]),
    ...mapActions("auth", ["logout"]),
    getpost() {
      this.Postget()
        .then((response) => {})
        .catch((e) => {
          alert(JSON.stringify(e.response.data));
          console.log("Error", e);
        });
    },

    onClickLogout() {
      this.logout()
        .then((response) => {
          this.$router.push("/login");
        })
        .catch((e) => {
          alert(JSON.stringify(e.response.data));
          console.log("Error", e);
        });
    },
  },
};
</script>

<style></style>
