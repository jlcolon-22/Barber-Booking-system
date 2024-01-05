<template>
  <div class="fixed bottom-7 right-4">
    <main class="relative">
      <div class="">
        <button v-if="!!user_id" @click="showChat" class="bg-blue-500 p-3 rounded-full">
          Chat Us
        </button>
        <a href="/auth/login" v-else class="bg-blue-500 p-3 rounded-full"> Chat Us </a>
      </div>
      <div
        v-show="toggleChat"
        class="absolute -top-[31.5rem] left-auto right-4 bg-white text-gray-900 w-[20rem] rounded"
      >
        <h1 class="px-2 py-3 border-b whitespace-nowrap text-center">Chat with Admin</h1>

        <div class="p-3 min-h-[25rem] max-h-[25rem] overflow-y-auto">
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
        <form v-on:submit.prevent="store" class="flex justify-between border-t w-full">
          <textarea
            rows="1"
            v-model="body"
            placeholder="Send Message..."
            class="w-full outline-none p-2 bg-gray-200 resize-none text-black min-h-[3rem]"
          ></textarea>
          <button class="px-4 py-2 text-sm bg-blue-500 text-white">send</button>
        </form>
      </div>
    </main>
  </div>
</template>
<script setup>
import axios from "axios";
import { ref, onMounted, onBeforeMount } from "vue";
const props = defineProps(["user_id"]);
const bottom = ref(null);
const toggleChat = ref(false);
const body = ref("");
const messages = ref([]);
const channel = ref(null);
const showChat = async () => {
  toggleChat.value = await !toggleChat.value;
  setTimeout(() => {
    bottom.value.scrollIntoView();
  }, 500);
};

const x = () => {
  console.log("ss");
  Echo.listen("ChatMessage", (e) => {
    messages.value.push(e.data);
    console.log(e);
  });
};
const store = async () => {
  const { data } = await axios.post("/admins/message", { body: body.value });
  //   await x();

  await messages.value.push(data);
  bottom.value.scrollIntoView();
  body.value = "";
};
const fetch = async () => {
  const { data } = await axios.get("/admins/message");
  messages.value = await data;
};
onBeforeMount(() => {}),
  onMounted(() => {
    Echo.channel(`chat`);
    // channel.value = window.Echo.channel(`chat`);
    if (!!props.user_id) {
      fetch();
    }
  });
</script>
