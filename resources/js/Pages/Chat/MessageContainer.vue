<template>
  <div class="item">
    <div v-for="(message, index) in messages" :key="index">
      <MessageItem :message="message" />
    </div>
  </div>
</template>

<script>
import MessageItem from "./MessageItem.vue";
export default {
  components: { MessageItem },
  props: ["messages"],
};
</script>

<style scoped>
.item {
  display: flex;
  flex-direction: column-reverse;
}
</style>