<template>
    <div>
        <q-btn
        class="q-mb-md"
        @click="openReply()"
        flat
        no-caps
        align="left"
        dense
        color="gray3">
        Reply
        </q-btn>
        <q-card-section
        class="q-pa-none"
         v-if="openreply==true">
         <form
                class="bg-white q-pa-none q-mb-md"
                @submit.prevent="sendReply">
                    <div class="row q-col-gutter-md">
                        <div class="col-10 flex items-center">
                            <q-input
                            outlined
                            dense
                            class="full-width" 
                            v-model="replies" 
                            label="Write a reply..." />
                        </div>
                        <div class="col flex items-center">
                            <q-btn
                            :disable="!replies"
                            type="submit"
                            class="cursor-pointer"
                            flat
                            round
                            outlined
                            dense
                            color="gray3"
                            unelevated
                            icon="send"  >
                            <span class="material-icons-round">
                            </span>
                            </q-btn>
                        </div>
                    </div>
                </form>
         </q-card-section>
         <q-list>
            <q-item v-for="reply in commentData.replies" :key="reply.id" class="q-pa-none q-mb-md">
                <q-item-section top avatar>
                <q-avatar>
                    <img
                   v-if="reply.user.profile_picture" :src="reply.user.profile_picture"
                />
                <img
                   v-else src="https://cdn.pixabay.com/photo/2013/07/13/12/07/avatar-159236_1280.png"
                />
                </q-avatar>
                </q-item-section>
                
                <q-item-section>
                <q-item-label>{{ reply.user.first_name }} {{ reply.user.last_name }}</q-item-label>
                <q-item-label caption>{{ reply.comment }}</q-item-label>
                </q-item-section>
            </q-item>
        </q-list>
    </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";
export default {
    props:{
        commentData: {}
    },
    data() {
        return{
             openreply: false,
             replies:""
        }
    },
    computed:{
        ...mapGetters("auth", ["authUser"]),
    },
    methods:{
        ...mapActions("Post", ["comment"]),
        openReply() {
            if(this.openreply==true){
                this.openreply=false
            }
            else{
                this.openreply=true
            }
        },
         sendReply() {
            this.comment({ 
                comment: this.replies,
                parent_id: this.commentData.id,
                post_id: this.commentData.post_id
            })
            .then(response => {
                this.replies = ""
                this.$store.commit('Post/sendReply', {comment: response.data.comment, authUser: this.authUser, commentData: this.commentData})
            })
            .catch(e => {
                console.log("Error", e)
            })
        },
    }
}
</script>