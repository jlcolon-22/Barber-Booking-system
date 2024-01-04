<template>
  <div class="min-h-[30rem]">
    <form @submit.prevent="fetch" class="border w-fit p-2 text-dark mt-2">
      <h1 class="text-lg font-bold">Generate Reports</h1>
      <div class="grid mt-2">
        <label for="">Type</label>
        <select
          v-model="type"
          class="bg-gray-600 px-2 max-w-[14rem] text-white rounded py-2"
        >
          <option value="day">Day</option>
          <option value="month">Month</option>
          <option value="years">Year</option>
        </select>
      </div>
      <div class="grid mt-2">
        <label for="">Date</label>
        <VueDatePicker
          v-if="type == 'years'"
          class="bg-gray-600 px-2 max-w-[14rem] text-white rounded"
          v-model="month"
          year-picker
          :enable-time-picker="false"
          placeholder="example"
          :teleport="true"
        >
        </VueDatePicker>
        <VueDatePicker
          v-else-if="type == 'month'"
          class="bg-gray-600 px-2 max-w-[14rem] text-white rounded"
          v-model="month"
          month-picker
          :enable-time-picker="false"
          placeholder="example"
          :teleport="true"
        >
        </VueDatePicker>
        <VueDatePicker
          v-else
          class="bg-gray-600 px-2 max-w-[14rem] text-white rounded"
          v-model="month"
          :enable-time-picker="false"
          placeholder="example"
          :teleport="true"
          :start-date="new Date()"
          focus-start-date
        ></VueDatePicker>
      </div>
      <div class="grid mt-2">
        <button class="w-full py-2 bg-blue-600 text-white rounded">Submit</button>
      </div>
    </form>

    <main class="overflow-x-auto max-h-[30rem]">
      <div id="printMe" v-if="toggle" class="mt-10">
        <h1 v-if="type == 'month'" class="text-3xl py-4 font-bold text-center text-dark">
          Sales Report for the Month of {{ moment(month).format("MMM Y") }}
        </h1>
        <h1 v-if="type == 'day'" class="text-3xl py-4 font-bold text-center text-dark">
          Sales Report for {{ moment(month).format("MMM d, Y") }}
        </h1>
        <h1 v-if="type == 'years'" class="text-3xl py-4 font-bold text-center text-dark">
          Annual Sales Report for the Year

          {{ moment(month).format("Y") }}
        </h1>
        <table class="w-full text-sm text-left text-gray-400 mt-2">
          <thead class="text-xs uppercase bg-gray-700 text-gray-400">
            <tr>
              <th scope="col" class="px-6 py-3">Name</th>
              <th scope="col" class="px-6 py-3">Photo</th>
              <th scope="col" class="px-6 py-3">Category</th>
              <th scope="col" class="px-6 py-3">Date</th>
              <th scope="col" class="px-6 py-3">Time</th>
              <th scope="col" class="px-6 py-3">Branch Name</th>
              <th scope="col" class="px-6 py-3">Branch Location</th>
              <th scope="col" class="px-6 py-3">Status</th>
            </tr>
          </thead>
          <tbody>
            <tr
              v-for="reservation in allDate"
              :key="reservation.id"
              class="border-b bg-gray-900 border-gray-700"
            >
              <th scope="row" class="px-6 py-4 font-medium whitespace-nowrap text-white">
                {{ reservation.firstname }}
              </th>
              <td class="px-6 py-4">
                <img
                  :src="reservation.post_info?.photo"
                  class="h-[4rem] w-[4rem]"
                  loading="lazy"
                  alt=""
                />
              </td>
              <td class="px-6 py-4">
                {{ reservation.post_info?.category }}
              </td>
              <td class="px-6 py-4 whitespace-nowrap">
                {{ moment(reservation.date).format("YYYY-MM-DD") }}
              </td>
              <td class="px-6 py-4">
                {{ reservation.time }}
              </td>
              <td class="px-6 py-4">
                {{ reservation.branch_info?.name }}
              </td>
              <td class="px-6 py-4">
                {{ reservation.branch_info?.location }}
              </td>
              <td class="px-6 py-4">
                <span
                  class="text-xs font-medium mr-2 px-2.5 py-0.5 rounded bg-violet-900 text-violet-300"
                  >Finish</span
                >
              </td>
            </tr>
            <tr v-if="Object.keys(allDate).length === 0">
              <h1 class="px-5 py-10">No Report found!</h1>
            </tr>
          </tbody>
        </table>
      </div>
    </main>

    <div v-if="Object.keys(allDate).length > 0" class="flex justify-end p-2">
      <button class="bg-gray-500 py-2 px-5 rounded" v-print="printObj">Print</button>
    </div>
  </div>
</template>
<script setup>
import { ref, reactive, watch } from "vue";
import axios from "axios";
import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import moment from "moment";
const month = ref("");
const date = ref("");
const type = ref("day");
const allDate = ref([]);
const toggle = ref(false);
watch(type, (n, o) => {
  if (n != o) {
    month.value = "";
    allDate.value = [];
    toggle.value = false;
  }
});
watch(month, (n, o) => {
  if (type.value == "day") {
    const formattedDate = moment(n).format("YYYY-MM-DD");
    date.value = formattedDate;
  }
  if (type.value == "month") {
    const formattedDate = moment(n).format("YYYY-MM");
    date.value = formattedDate;
  }
  if (type.value == "years") {
    date.value = n;
  }
});
const fetch = async () => {
  const { data } = await axios.post("/admin/reports", {
    date: date.value,
    type: type.value,
  });
  allDate.value = await data;
  toggle.value = true;
};
const printObj = reactive({
  id: "printMe",
  popTitle: "good print",
  extraCss: "https://cdn.tailwindcss.com",
  beforeOpenCallback(vue) {
    vue.printLoading = true;
  },
  openCallback(vue) {
    vue.printLoading = false;
    console.log("执行了打印");
  },
  closeCallback(vue) {
    console.log("关闭了打印工具");
  },
});
</script>
