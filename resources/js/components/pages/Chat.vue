<template>
  <div class="bg-gray-600 p-3 min-h-[25rem] max-h-[25rem] overflow-y-auto">
    <div class="space-y-4">
      <div v-for="message in messages" :key="messages.id">
        <h1
          v-if="message?.sender_id == user_id"
          class="bg-blue-600 p-2 rounded text-gray-200 font-light"
        >
          {{ message.body }}
        </h1>
        <h1 v-else class="bg-gray-700 p-2 rounded text-gray-200 font-light">
          {{ message.body }}
        </h1>
      </div>
    </div>
    <div ref="bottom" id="scrollDrown"></div>
  </div>
  <form v-on:submit.prevent="store" class="flex justify-between w-full">
    <textarea
      v-model="body"
      placeholder="Send Message..."
      class="w-full outline-none p-2 resize-none text-black"
    ></textarea>
    <button class="px-4 py-2 text-base bg-blue-500">send</button>
  </form>
</template>
<script setup>
import { onMounted, ref, toRef } from "vue";
import axios from "axios";
import { xor } from "lodash";

const props = defineProps(["convo_id", "user_id"]);
const convoId = ref(null);
const body = ref("");
const messages = ref([]);
const bottom = ref(null);
const x = () => {
  window.Echo.private(`chat`).listen("ChatMessage", (e) => {
    if (e.data.conversation_id == convoId.value) {
      messages.value.push(e.data);
      setTimeout(() => {
        bottom.value.scrollIntoView();
      }, 500);
    }
  });
};
const store = async () => {
  const { data } = await axios.post("/message/convo/" + convoId.value, {
    body: body.value,
  });
  //   await messages.value.push(data);
  body.value = "";
  //   bottom.value.scrollIntoView();
};
const fetch = async () => {
  const { data } = await axios.get("/all/message/" + convoId.value);
  messages.value = data;
};
onMounted(async () => {
  convoId.value = await props.convo_id;
  x();
  await fetch();

  bottom.value.scrollIntoView();
});
</script>
