<template>
  <form
    @submit.prevent="store"
    class="grid grid-cols-1 lg:w-3/5 px-10 mx-auto py-10 bg-black bg-opacity-90"
  >
    <h1 class="pb-10 font-bold">Book Information</h1>
    <!--    @if(session()->has('success'))
        <div class="p-4 mb-10 text-sm rounded-lg  bg-gray-800 text-green-400" role="alert">
          <span class="font-medium">Updated Successfully!</span>
      </div>
      @endif

      @csrf -->
    <!-- book information -->
    <div class="pb-10 flex flex-col md:flex-row w-fit gap-3">
      <img
        :src="information?.photo"
        class="max-h-[10rem] min-w-[15rem] object-top object-cover rounded"
        loading="lazy"
        alt=""
      />
      <div>
        Name: <span class="opacity-75"> {{ information?.name }}</span>
        <br />
        Price: <span class="opacity-75"> ₱{{ information?.price }}</span>
        <br />
        Category: <span class="opacity-75"> {{ information?.category }}</span>
        <br />
        Branch Name: <span class="opacity-75"> {{ information?.branch?.name }}</span>
        <br />
        Branch Location:
        <span class="opacity-75"> {{ information?.branch?.location }}</span>
      </div>
    </div>

    <div>
      <div class="grid md:grid-cols-2 md:gap-6">
        <div class="relative z-0 w-full mb-6 group">
          <input
            type="text"
            name="floating_first_name"
            id="floating_first_name"
            class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 ppearance-none text-white border-gray-600 focus:border-blue-500 focus:outline-none focus:ring-0 peer"
            placeholder=" "
            required
            v-model="data.firstname"
          />
          <label
            for="floating_first_name"
            class="peer-focus:font-medium absolute text-sm text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
            >First name</label
          >
        </div>
        <div class="relative z-0 w-full mb-6 group">
          <input
            type="text"
            name="lastname"
            id="lastname"
            class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 ppearance-none text-white border-gray-600 focus:border-blue-500 focus:outline-none focus:ring-0 peer"
            placeholder=" "
            required
            v-model="data.lastname"
          />
          <label
            for="lastname"
            class="peer-focus:font-medium absolute text-sm text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
            >Last name</label
          >
        </div>
      </div>
      <div class="grid md:grid-cols-2 md:gap-6">
        <div class="relative z-0 w-full mb-6 group">
          <input
            type="text"
            class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 ppearance-none text-white border-gray-600 focus:border-blue-500 focus:outline-none focus:ring-0 peer"
            placeholder=" "
            required
            v-model="data.email"
          />
          <label
            for="floating_first_name"
            class="peer-focus:font-medium absolute text-sm text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
            >Email</label
          >
        </div>
        <div class="relative z-0 w-full mb-6 group">
          <input
            type="tel"
            class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 ppearance-none text-white border-gray-600 focus:border-blue-500 focus:outline-none focus:ring-0 peer"
            placeholder=" "
            required
            v-model="data.number"
          />
          <label
            for="lastname"
            class="peer-focus:font-medium absolute text-sm text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
            >Number</label
          >
          <small class="text-red-500" v-if="error.number">{{ error?.number[0] }}</small>
        </div>
      </div>

      <div class="grid md:grid-cols-2 md:gap-6">
        <div class="relative z-40 w-full mb-6 group" id="datepicker">
          <VueDatePicker
            required
            placeholder="Select Date"
            :min-date="new Date()"
            :hide-navigation="['time', 'year']"
            auto-apply
            class="block px-0 w-full text-sm bg-transparent border-0 border-b-2 ppearance-none text-white border-gray-600 focus:border-blue-500 focus:outline-none focus:ring-0 peer"
            :disabled-week-days="[6, 0]"
            v-model="data.date"
          ></VueDatePicker>
          <label
            for="floating_first_name"
            class="peer-focus:font-medium absolute text-sm text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
            >Date</label
          >
        </div>

        <div class="relative z-40 w-full mb-6 group">
          <VueDatePicker
            required
            placeholder="Select Time"
            time-picker
            auto-apply
            :min-time="minTime"
            :max-time="maxTime"
            class="block px-0 w-full text-sm bg-transparent border-0 border-b-2 ppearance-none text-white border-gray-600 focus:border-blue-500 focus:outline-none focus:ring-0 peer"
            v-model="data.time"
          ></VueDatePicker>
          <label
            for="floating_first_name"
            class="peer-focus:font-medium absolute text-sm text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
            >Time</label
          >
        </div>
      </div>
    </div>
    <button
      data-modal-hide="default-modal"
      type="submit"
      class="text-white focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-green-600 hover:bg-green-700 focus:ring-green-800"
    >
      {{ loading ? "Loading..." : "Update" }}
    </button>
  </form>
</template>

<script setup>
import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import { ref, onMounted, reactive } from "vue";
import axios from "axios";
const date = ref("");
const time = ref("");
const loading = ref(false);
const props = defineProps(["data", "user"]);
const information = ref([]);
const data = reactive({
  number: "",
  firstname: "",
  lastname: "",
  email: "",
  time: "",
  date: "",
  post_id: "",
  branch_id: "",
});
const minTime = reactive({
  hours: 0,
  minutes: 0,
  seconds: 0,
});
const maxTime = reactive({
  hours: 0,
  minutes: 0,
  seconds: 0,
});
const error = ref([]);
onMounted(() => {
  const newData = JSON.parse(props.data);
  const newUser = JSON.parse(props.user);
  information.value = newData;

  data.post_id = newData?.id;
  data.branch_id = newData?.branch?.id;
  data.firstname = newUser?.firstname;
  data.lastname = newUser?.lastname;
  data.email = newUser?.email;

  minTime.hours = newData.branch?.start_time.split(":")[0];
  minTime.minutes = newData.branch?.start_time.split(":")[1];
  maxTime.hours = newData.branch?.end_time.split(":")[0];
  maxTime.minutes = newData.branch?.end_time.split(":")[1];
});

const store = async () => {
  try {
    loading.value = true;
    const res = await axios.post("/reservation", data);
    if (res.status == 204) {
      alert("All slots are already taken for the day you selected");
    }
    loading.value = false;
    window.location.href = "/booked";
  } catch (err) {
    loading.value = false;
    console.log(err.response);
    error.value = err.response.data.errors;
  }
};
</script>

<style>
.dp__theme_light {
  --dp-background-color: #fff;
  --dp-text-color: #212121;
  --dp-hover-color: #f3f3f3;
  --dp-hover-text-color: #212121;
  --dp-hover-icon-color: #959595;
  --dp-primary-color: #1976d2;
  --dp-primary-disabled-color: #6bacea;
  --dp-primary-text-color: #f8f5f5;
  --dp-secondary-color: #c0c4cc;
  --dp-border-color: #ddd;
  --dp-menu-border-color: #ddd;
  --dp-border-color-hover: #aaaeb7;
  --dp-disabled-color: #f6f6f6;
  --dp-scroll-bar-background: #f3f3f3;
  --dp-scroll-bar-color: #959595;
  --dp-success-color: #76d275;
  --dp-success-color-disabled: #a3d9b1;
  --dp-icon-color: backre;
  --dp-danger-color: #ff6f60;
  --dp-marker-color: #ff6f60;
  --dp-tooltip-color: #fafafa;
  --dp-disabled-color-text: #8e8e8e;
  --dp-highlight-color: rgb(25 118 210 / 10%);
  --dp-range-between-dates-background-color: var(--dp-hover-color, #f3f3f3);
  --dp-range-between-dates-text-color: var(--dp-hover-text-color, #212121);
  --dp-range-between-border-color: var(--dp-hover-color, #f3f3f3);
  z-index: 100;
}
.dp__input_reg {
  background: transparent;
  border: none;
  /*  border-bottom: 1px solid blue;*/
  border-radius: 0px !important;
  z-index: 100;
  color: white;
}
.dp__instance_calendar {
}
</style>
