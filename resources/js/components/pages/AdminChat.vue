<template>
  <div class="fixed bottom-7 right-4">
    <main class="relative">
      <div class="">
        <button v-if="!!user_id" @click="showChat" class="bg-blue-500 p-3 text-lg rounded-full">
          Chat Us
        </button>
        <a href="/auth/login" v-else class="bg-blue-500 p-3 rounded-full text-lg "> Chat Us </a>
      </div>
      <div
        v-show="toggleChat"
        class="absolute -top-[32.2rem] left-auto right-4 bg-white text-gray-900 w-[20rem] rounded border border-black"
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
          <button class="px-4 py-2 text-base bg-blue-500 text-white">send</button>
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
const convoId = ref("");
const showChat = async () => {
  toggleChat.value = await !toggleChat.value;
  setTimeout(() => {
    bottom.value.scrollIntoView();
  }, 500);
};

const x = () => {
  //   console.log("ss");
  window.Echo.private(`chat`).listen("ChatMessage", (e) => {
    if (e.data.conversation_id == convoId.value) {
      messages.value.push(e.data);
      setTimeout(() => {
        bottom.value.scrollIntoView();
      }, 500);
      return;
    } else if (e.data.sender_id == props.user_id);
    {
      messages.value.push(e.data);
      setTimeout(() => {
        bottom.value.scrollIntoView();
      }, 500);
      return;
    }
  });
};
const store = async () => {
  const { data } = await axios.post("/admins/message", { body: body.value });
  convoId.value = data;
  //   await messages.value.push(data);

  body.value = "";
};
const fetch = async () => {
  const { data } = await axios.get("/admins/message");
  messages.value = await data;
};
onBeforeMount(() => {}),
  onMounted(() => {
    // private.value = window.Echo.private(`chat`);
    x();
    if (!!props.user_id) {
      fetch();
    }
  });
</script>
