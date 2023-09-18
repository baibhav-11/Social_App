<template>
  <div>
    <q-card class="my-card q-mt-lg" style="margin-right: 200">
      <q-card-section>
        <q-item class="q-pa-none">
          <q-item-section avatar>
            <q-avatar>
              <img
                v-if="post.author.profile_picture"
                :src="post.author.profile_picture"
              />
              <img
                v-else
                src="https://cdn.pixabay.com/photo/2013/07/13/12/07/avatar-159236_1280.png"
              />
            </q-avatar>
          </q-item-section>

          <q-item-section>
            <q-item-label
              >{{ post.author.first_name }}
              {{ post.author.last_name }}</q-item-label
            >
            <q-item-label caption>
              {{ posted_at }}
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-item v-if="post.detail" class="q-pa-none">
          <q-item-section>
            <q-item-label class="text-black"
             caption v-if="post.detail">
              <div v-if="post.detail.length > 200">
                <div
                  v-html="
                    isFullDescription
                      ? urlify(post.detail)
                      : urlify(post.detail).slice(0, 200)
                  "
                ></div>
              </div>
              <div v-if="post.detail.length < 200">
                <div v-html="urlify(post.detail)"></div>
              </div>
              <a
                class="cursor-pointer text-blue-5"
                v-if="post.detail.length > 200"
                @click="onClickFullDescription(isFullDescription)"
              >
                {{ isFullDescription ? "Read less" : "Read more" }}
              </a>
            </q-item-label>
          </q-item-section>
        </q-item>

        <q-item v-if="post.attachment" class="q-pa-none">
          <q-item-section>
            <img
              class="full-width"
              v-if="post.attachment && post.attachment.type == 'image'"
              :src="post.attachment.url"
            />
            <!-- <video
              v-if="post.attachment && post.attachment.type == 'video'"
              height="400px"
              width="100%"
              controls
            >
              <source :src="post.attachment.url" type="video/mp4" />
            </video> -->
            <q-video
              v-if="post.attachment && post.attachment.type == 'video'"
              :ratio="16/9"
              :src="post.attachment.url"
            />
          </q-item-section>
        </q-item>
      </q-card-section>
      <div class="q-px-md">
        <q-item-section>
          <div class="row">
            <div class="col-6 col-md-6 text-light-blue-3">
              Total likes: {{ post.likes.length }}
            </div>
            <div class="col-6 col-md-6 text-right text-light-blue-3">
              {{ totalComments }} Comments
            </div>
          </div>
        </q-item-section>
      </div>
      <q-card-section class="q-pt-none">
        <q-btn
          flat
          round
          unelevated
          size="12px"
          @click="onClickLike(post)"
          :color="isLikedPost == true ? 'blue-5' : 'grey-8'"
          :icon="isLikedPost == true ? 'thumb_up_alt' : 'thumb_up_off_alt'"
        />

        <q-btn
          flat
          round
          unelevated
          icon="comment"
          size="12px"
          @click="openComment()"
        />
      </q-card-section>

      <!-- comment ! -->
      <q-separator />
      <q-card-section v-if="opencomment == true">
        <form class="bg-white q-pa-none q-mb-md" @submit.prevent="sendComment">
          <div class="row q-col-gutter-md">
            <div class="col-10 flex items-center">
              <q-input
                dense
                class="full-width"
                v-model="comments"
                label="Write a comment..."
              />
            </div>
            <div class="col flex items-center">
              <q-btn
                :disable="!comments"
                type="submit"
                class="cursor-pointer"
                flat
                round
                outlined
                dense
                color="gray3"
                unelevated
                icon="send"
              >
                <span class="material-icons-round"> </span>
              </q-btn>
            </div>
          </div>
        </form>

        <q-list>
          <q-item
            v-for="comment in post.comments"
            :key="comment.id"
            class="q-pa-none q-mb-md"
          >
            <q-item-section top avatar>
              <q-avatar>
                <img
                  v-if="comment.user.profile_picture"
                  :src="comment.user.profile_picture"
                />
                <img
                  v-else
                  src="https://cdn.pixabay.com/photo/2013/07/13/12/07/avatar-159236_1280.png"
                />
              </q-avatar>
            </q-item-section>
            <q-item-section>
              <q-item-label
                >{{ comment.user.first_name }}
                {{ comment.user.last_name }}</q-item-label
              >
              <q-item-label caption>{{ comment.comment }}</q-item-label>
              <!-- Reply -->
              <ReplyComment v-bind:comment-data="comment" />
            </q-item-section>
          </q-item>
        </q-list>
      </q-card-section>
    </q-card>
  </div>
</template>

<script>
import moment from "moment-timezone";
import { mapActions, mapGetters } from "vuex";
import { LocalStorage as SessionStorage } from "quasar";
import ReplyComment from "components/Post/ReplyComment.vue";
var offset = new Date().getTimezoneOffset();
export default {
  props: {
    post: {},
  },
  data() {
    return {
      opencomment: false,
      isLiked: undefined,
      isLikedPost: false,
      isFullDescription: false,
      moment: moment,
      created_at: "",
      comments: "",
      detail: "",
      posted_at: "",
    };
  },

  components: {
    ReplyComment,
  },

  computed: {
    ...mapGetters("auth", ["authUser"]),
    totalComments() {
      var totalReplies = 0;
      this.post.comments.forEach((comment) => {
        totalReplies += comment.replies.length;
      });
      return this.post.comments.length + totalReplies;
    },
  },

  created() {
    const self = this;
    self.posted_at = moment(self.post.created_at).tz("Asia/Kolkata").fromNow();
    setInterval(() => {
      self.posted_at = moment(self.post.created_at)
        .tz("Asia/Kolkata")
        .fromNow();
    }, 1000);

    if (this.post && this.post.likes.length > 0) {
      this.post.likes.forEach((like) => {
        console.log("test");
        if (like.user_id == this.authUser.id) {
          this.isLikedPost = true;
        } else {
          this.isLikedPost = false;
        }
      });
    } else {
      this.isLikedPost = false;
    }
  },
  methods: {
    ...mapActions("Post", ["like", "comment", "dislike"]),
    urlify(text) {
      var pseudoUrlPattern =
        /(https?:\/\/)?[\w\-~]+(\.[\w\-~]+)+(\/[\w\-~@:%]*)*(#[\w\-]*)?(\?[^\s]*)?(\=[^\s]*)?/gi;
      text = text.replace(pseudoUrlPattern, function (url) {
        var valid = /^(ftp|http|https):\/\/[^ "]+$/.test(url);
        return `<a href="${
          valid ? "" : "//"
        }${url}" target="_blank">${url}</a>`;
      });
      text = text.replace(/\n/g, "<br />");
      return text;
    },
    onClickFullDescription(val) {
      if (val) {
        this.isFullDescription = false;
      } else {
        this.isFullDescription = true;
      }
    },
    openComment() {
      if (this.opencomment == true) {
        this.opencomment = false;
      } else {
        this.opencomment = true;
      }
    },

    onClickLike(post) {
      if (this.isLikedPost == true) {
        this.dislike({ post_id: this.post.id })
          .then((response) => {
            console.log("success", response);
          })
          .catch((err) => {
            console.log("err", err);
          });

        this.$store.commit("Post/disLike", {
          post: this.post,
          authUser: this.authUser,
        });
      } else {
        this.like({ post_id: this.post.id })
          .then((response) => {
            console.log("success", response);
          })
          .catch((err) => {
            console.log("err", err);
          });
        this.$store.commit("Post/setLike", {
          post: this.post,
          authUser: this.authUser,
        });
      }
    },
    

    // sendLike() {
    //   console.log("sending likes");
    //   stompClient.send(
    //     "/social_app/like",
    //     {},
    //     JSON.stringify({ like: 1, id: "12" })
    //   );
    // },
    // showLike(message) {
    //   $("#like").html(message);
    // },
    sendComment() {
      console.log("formsubmitted");

      this.comment({ post_id: this.post.id, comment: this.comments })
        .then((response) => {
          this.comments = "";
          this.$store.commit("Post/setComment", {
            post: this.post,
            authUser: this.authUser,
            comment: response.data.comment,
          });
        })
        .catch((e) => {
          if (this.comments == "")
            alert("Comment must have at least 1 character");
          else alert("Comment cannot exceed 500 characters");
          console.log("Error", e);
        });
    },
  },
  watch: {
    post: {
      handler(val) {
        if (this.post && this.post.likes.length > 0) {
          this.post.likes.forEach((like) => {
            if (like.user_id == this.authUser.id) {
              this.isLikedPost = true;
            } else {
              this.isLikedPost = false;
            }
          });
        } else {
          this.isLikedPost = false;
        }
      },
      deep: true,
    },
  },
};
</script>
