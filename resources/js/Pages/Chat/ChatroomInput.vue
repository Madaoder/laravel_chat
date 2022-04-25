<template>
  <div>
    <input type="text" v-model="name" />
    <input type="text" v-model="password" />
    <button @click="createRoom">create</button>
  </div>
</template>
<script>
import axios from "axios";
export default {
  data: function () {
    return {
      name: "",
      password: "",
    };
  },
  methods: {
    createRoom() {
      axios
        .post("/chat/room/new", { name: this.name, password: this.password })
        .then((response) => {
          if (response.status == 201) {
            alert(this.name + " room has create!");
            this.name = "";
          }
        });
    },
  },
};
</script>