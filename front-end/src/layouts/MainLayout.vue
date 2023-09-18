<template>
  <q-layout view="lHh Lpr lFf">
    <q-page-container>
      <router-view />
    </q-page-container>
  </q-layout>
</template>

<script>
import PostCard from "components/Post/PostCard.vue";
// var Stomp = require('@stomp/stompjs');
// // var SockJS = require('@sockjs');
// import SockJS from '@sockjs';
var stompClient = null;
import SockJS from "sockjs-client";
// import Stomp from "webstomp-client";
import Stomp from "stomp-websocket";
import io from "socket.io-client";
import { mapMutations  } from "vuex";

export default {
  name: "MainLayout",
  data() {
    return {
      leftDrawerOpen: true,
      stompClient: null,
      notificationCount: 0,
    };
  },

  created() {

    this.connectSocket();
  },
  methods: {

    sendMessage() {
      console.log("sending message");

      stompClient.send(
        "/social_app/comment",
        {},
        JSON.stringify({
          comments: [
            {
              id: 1,
              post_id: 1,
              user_id: 1,
              parent_id: 0,
              comment: $("#message").val(),
              created_at: "2022-02-10T13:25:39.000000Z",
              updated_at: "2022-02-10T13:25:39.000000Z",
            },
          ],
        })
      );
    },
    sendLike() {
      console.log("sending likes");
      stompClient.send(
        "/social_app/like",
        function (message) {
          alert(1)
        },
        JSON.stringify({ like: 1, id: "12" }),
      );
    },

    connectSocket() {
      console.log("socketconnected");
      var socket = new SockJS("http://localhost:8080/Social_App-websocket");

      stompClient = Stomp.over(socket);
      stompClient.connect({}, function (frame) {
        stompClient.subscribe("ws://localhost:8080/topic/comment", function (message) {
          console.log("waiting for comment");
          console.log("subscribe comment", message);
        });
        stompClient.subscribe("ws://localhost:8080/topic/likes", function (message) {
          console.log("waiting for like");
          console.log("subscribe like",message);
          
        });
      });
    },
  },
};
</script>

<style></style>
