<template>
  <div>
    <input
      class="input"
      type="text"
      v-model="message"
      @keyup.enter="sendMessage"
    />
    <button class="button" @click="sendMessage">send</button>
  </div>
</template>
<script>
import axios from "axios";
export default {
  props: ["room"],
  data: function () {
    return {
      message: "",
    };
  },
  methods: {
    sendMessage() {
      if (this.message == "") {
        return;
      }

      axios
        .post("/chat/room/" + this.room.id + "/talk", {
          message: this.message,
        })
        .then((response) => {
          if (response.status == 201) {
            this.message = "";
            this.$emit("messagesent");
          }
        });
    },
  },
};
</script>

<style scoped>
.input {
  width: 80%;
}
.button {
  margin-left: 1em;
  color: rgb(255, 255, 255);
  background-color: rgb(14, 125, 230);
  border-radius: 0.25em;
  padding: 0.375em;
}
</style>