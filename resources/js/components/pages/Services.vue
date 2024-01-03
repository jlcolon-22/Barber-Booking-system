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
          @click="openCalendar(`/view?branch=${branch.name}&q=${branch.id}`, branch.id)"
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
          :masks="masks"
        />

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
import { onMounted, ref, watch } from "vue";
import { DatePicker } from "v-calendar";
import axios from "axios";
import "v-calendar/style.css";
const date = ref("");
const masks = ref({
  input: "YYYY-MM-DD",
});
const url = ref("");
const props = defineProps(["locations"]);
const branches = ref([]);
const calendar = ref(false);

const disabledDates = ref([
  { start: new Date(2024, 0, 7), end: new Date(2024, 0, 7) },
  { start: new Date(2024, 0, 19), end: new Date(2024, 0, 19) },
]);
watch(date, (n, o) => {
  //   calendar.value = false;
  var inputDate = new Date(n);

  const fulldate = `${
    inputDate.getMonth() + 1
  }-${inputDate.getDate()}-${inputDate.getFullYear()}`;
  date.value = fulldate;
  window.location.href = url.value + `&date=${fulldate}`;
});
const getBranchDate = async (branch_id) => {
  const { data } = await axios.post("/services/branch/" + branch_id);
  disabledDates.value = data.map((value) => {
    return { start: value.date, end: value.date };
  });
  console.log(data);
};
const openCalendar = (urls, id) => {
  calendar.value = !calendar.value;
  getBranchDate(id);
  url.value = urls;
};
const closeCalendar = () => {
  calendar.value = !calendar.value;
};
onMounted(() => {
  branches.value = JSON.parse(props.locations);
});
</script>
