<template>
  <div>
    <div>{{ currentRoom.name }} room</div>
    <select v-model="selected" @change="roomChanged(selected)">
      <option v-for="(room, index) in rooms" :key="index" :value="room">
        {{ room.name }}
      </option>
    </select>
  </div>
</template>
<script>
import axios from "axios";

export default {
  props: ["rooms", "currentRoom"],
  emits: ["enterRoom"],
  data: function () {
    return {
      selected: "",
    };
  },
  methods: {
    roomChanged(room) {
      let vm = this;
      axios
        .get("/chat/room/" + room.id + "/hasP")
        .then((response) => {
          if (response.data === true) {
            let password = prompt("enter the password:");
            axios
              .post("/chat/room/" + room.id + "/check", {
                password: password,
              })
              .then((response) => {
                if (response.data === true) {
                  vm.$emit("enterRoom", vm.selected);
                } else {
                  vm.selected = vm.rooms[0];
                  vm.$emit("enterRoom", vm.selected);
                }
              });
          } else {
            vm.$emit("enterRoom", this.selected);
          }
        })
        .catch((e) => {
          console.log(e);
        });
    },
  },
  created() {
    this.selected = this.currentRoom;
  },
};
</script>