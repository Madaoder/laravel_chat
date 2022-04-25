<template>
  <Head title="Chat" />

  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        <ChatroomSelector
          v-if="currentRoom.id"
          :rooms="chatRooms"
          :currentRoom="currentRoom"
          @enterRoom="setRoom($event)"
        />
      </h2>
    </template>

    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <MessageContainer :messages="messages" />
            <MessageInput :room="currentRoom" v-on:messagesent="getMessages" />
          </div>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>

<script>
import BreezeAuthenticatedLayout from "@/Layouts/Authenticated.vue";
import { Head } from "@inertiajs/inertia-vue3";
import MessageContainer from "./MessageContainer.vue";
import MessageInput from "./MessageInput.vue";
import axios from "axios";
import ChatroomSelector from "./ChatroomSelector.vue";

export default {
  components: {
    BreezeAuthenticatedLayout,
    Head,
    MessageContainer,
    MessageInput,
    ChatroomSelector,
  },
  data: function () {
    return {
      chatRooms: [],
      currentRoom: [],
      messages: [],
    };
  },
  watch: {
    currentRoom(val, oldval) {
      if (oldval.id) {
        this.disconnect(oldval);
      }
      this.connect();
    },
  },
  methods: {
    connect() {
      if (this.currentRoom.id) {
        let vm = this;
        this.getMessages();
        window.Echo.private("chat." + this.currentRoom.id).listen(
          ".message.new",
          (e) => {
            vm.getMessages();
          }
        );
      }
    },
    disconnect(room) {
      window.Echo.leave("chat." + room.id);
    },
    getRooms() {
      axios
        .get("/chat/rooms")
        .then((response) => {
          this.chatRooms = response.data;
          this.setRoom(response.data[0]);
        })
        .catch((error) => {
          console.log(error);
        });
    },
    setRoom(room) {
      this.currentRoom = room;
    },
    getMessages() {
      axios
        .get("/chat/room/" + this.currentRoom.id + "/messages")
        .then((response) => {
          this.messages = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
  },
  created() {
    this.getRooms();
  },
};
</script>
