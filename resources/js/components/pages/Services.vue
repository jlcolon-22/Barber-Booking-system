<template>
  <div class="grid grid-cols-1 gap-4 md:grid-cols-2 xl:grid-cols-3 md:gap-10">
    <div v-for="branch in branches" :key="branch.id" class="bg-white">
      <img
        :src="branch?.photo"
        class="object-cover min-h-[20rem] max-h-[20rem] w-full"
        alt=""
      />
      <div class="p-2 grid">
        <div class="text-2xl text-black font-semibold">{{ branch.name }}</div>
        <!-- <a
          :href="`/view?branch=${branch.name}&q=${branch.id}`"
          class="bg-blue-500 text-center py-2"
          >view</a
        > -->
        <input
          @click="openCalendar"
          type="button"
          value="view"
          class="bg-blue-500 text-center py-2"
        />
      </div>
    </div>
  </div>
  <div
    v-show="calendar"
    class="fixed w-full h-[100svh] bg-black/70 top-0 left-0 flex justify-center items-center z-[100] p-2"
  >
    <div class="bg-white text-gray-900 w-[40rem]">
      <h1 class="text-center text-2xl py-5 font-bold">Available Date</h1>
      <div class="px-3">
        <DatePicker
          v-model="date"
          expanded
          :disabled-dates="disabledDates"
          :min-date="new Date()"
        />
        <div>
          <h1 class="text-center text-2xl py-5 font-bold">
            The available time for the selected date
          </h1>
        </div>
        <div class="px-3"></div>
        <div class="py-3 flex justify-end">
          <button @click="closeCalendar" class="bg-red-500 py-2 px-4 rounded text-white">
            Cancel
          </button>
        </div>
      </div>
    </div>
  </div>
</template>
<script setup>
import { onMounted, ref } from "vue";
import { DatePicker } from "v-calendar";
import "v-calendar/style.css";
const date = ref("");
const props = defineProps(["locations"]);
const branches = ref([]);
const calendar = ref(true);
const timeContainer = ref(false);
const timeAvailable = ref([]);
const disabledDates = ref([
  { start: new Date(2024, 0, 7), end: new Date(2024, 0, 7) },
  { start: new Date(2024, 0, 19), end: new Date(2024, 0, 19) },
]);

const openCalendar = () => {
  calendar.value = !calendar.value;
};
const closeCalendar = () => {
  calendar.value = !calendar.value;
};
onMounted(() => {
  branches.value = JSON.parse(props.locations);
});
</script>
