<template>
    <form @submit.prevent="store" class="grid grid-cols-1 lg:w-3/5 px-10 mx-auto py-10 bg-black bg-opacity-90">
        <h1 class="pb-10 font-bold">Book Information</h1>
        <!--    @if(session()->has('success'))
            <div class="p-4 mb-10 text-base rounded-lg  bg-gray-800 text-green-400" role="alert">
              <span class="font-medium">Updated Successfully!</span>
          </div>
          @endif

          @csrf -->
        <!-- book information -->
        <div class="pb-10 flex flex-col md:flex-row w-fit gap-3">
            <img :src="information?.photo" class="max-h-[10rem] min-w-[15rem] object-top object-cover rounded"
                loading="lazy" alt="" />
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
                    <input type="text" name="floating_first_name" id="floating_first_name"
                        class="block py-2.5 px-0 w-full text-base bg-transparent border-0 border-b-2 ppearance-none text-white border-gray-600 focus:border-blue-500 focus:outline-none focus:ring-0 peer"
                        placeholder=" " required v-model="data.firstname" />
                    <label for="floating_first_name"
                        class="peer-focus:font-medium absolute text-base text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">First
                        name</label>
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <input type="text" name="lastname" id="lastname"
                        class="block py-2.5 px-0 w-full text-base bg-transparent border-0 border-b-2 ppearance-none text-white border-gray-600 focus:border-blue-500 focus:outline-none focus:ring-0 peer"
                        placeholder=" " required v-model="data.lastname" />
                    <label for="lastname"
                        class="peer-focus:font-medium absolute text-base text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Last
                        name</label>
                </div>
            </div>
            <div class="grid md:grid-cols-2 md:gap-6">
                <div class="relative z-0 w-full mb-6 group">
                    <input type="text"
                        class="block py-2.5 px-0 w-full text-base bg-transparent border-0 border-b-2 ppearance-none text-white border-gray-600 focus:border-blue-500 focus:outline-none focus:ring-0 peer"
                        placeholder=" " required v-model="data.email" :disabled="true" />
                    <label for="floating_first_name"
                        class="peer-focus:font-medium absolute text-base text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Email</label>
                </div>
                <div class="relative z-0 w-full mb-6 group">

                    <small v-if="verified == 'yes' && numberError == ''" title="Phone number is verified" class=" text-green-500 rounded px-2 py-1 absolute top-2 text-sm right-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-check"><polyline points="20 6 9 17 4 12"></polyline></svg>
                    </small>
                    <small v-if="verified == 'not' && numberError == ''" title="Phone number is not verified" class=" text-red-500 rounded px-2 py-1 absolute top-2 text-sm right-1">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg>
                    </small>
                    <input type="tel"
                        class="block py-2.5 px-0 w-full text-base bg-transparent border-0 border-b-2 ppearance-none text-white border-gray-600 focus:border-blue-500 focus:outline-none focus:ring-0 peer"
                        placeholder=" " required v-model="newNumber" />
                    <label for="lastname"
                        class="peer-focus:font-medium absolute text-base text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Number
                        (ex: 09101421431)</label>

                    <small class="text-red-500" v-if="error.number">{{ error?.number[0] }}</small>
                    <small class="text-red-500" v-if="!!numberError">{{ numberError }}</small>
                    <div v-if="verified == 'not' && numberError == ''" class="pt-2">
                        <button  @click="postVerify" type="button"
                        class="bg-emerald-600 text-white rounded px-4 py-1  text-sm ">Verify</button></div>
                    <!-- <small class="text-red-500" v-if="verified == 'not' && numberError == ''">Phone number is not verified </small> -->
                    <!-- <small class="text-green-500" v-if="verified == 'yes' && numberError == ''">Phone number is verified </small> -->
                    <small v-show="numberLoader">

                        <svg width="24px" class="text-gray-100 fill-white animate-spin" height="24px"
                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <g>
                                <path fill="none" d="M0 0h24v24H0z" />
                                <path d="M12 3a9 9 0 0 1 9 9h-2a7 7 0 0 0-7-7V3z" />
                            </g>
                        </svg>
                    </small>
                </div>
            </div>

            <div class="grid grid-cols-1 md:gap-6">
                <!-- <div class="relative z-40 w-full mb-6 group" id="datepicker">
          <VueDatePicker
            required
            placeholder="Select Date"
            :min-date="new Date()"
            :hide-navigation="['time', 'year']"
            auto-apply
            class="block px-0 w-full text-base bg-transparent border-0 border-b-2 ppearance-none text-white border-gray-600 focus:border-blue-500 focus:outline-none focus:ring-0 peer"
            :disabled-week-days="[6, 0]"
            :enable-time-picker="false"
            v-model="data.date"
          ></VueDatePicker>
          <label
            for="floating_first_name"
            class="peer-focus:font-medium absolute text-base text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
            >Date</label
          >
        </div> -->

                <div class="relative z-0 w-full mb-6 group">
                    <DatePicker v-model="date" expanded :disabled-dates="disabledDates" :min-date="new Date()"
                        :masks="masks" required>
                        <template #default="{ inputValue, inputEvents }">
                            <input placeholder=" " :value="inputValue" v-on="inputEvents" required
                                class="block py-2.5 px-0 w-full text-base bg-transparent border-0 border-b-2 appearance-none text-white border-gray-600 focus:border-blue-500 focus:outline-none focus:ring-0 peer" />
                        </template>
                    </DatePicker>
                    <label for="lastname"
                        class="peer-focus:font-medium absolute text-base text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Date</label>
                </div>
                <div class="relative z-0 w-full mb-6 group">
                    <select required v-model="data.time"
                        class="block py-2.5 px-0 w-full text-base bg-transparent border-0 border-b-2 appearance-none text-white border-gray-600 focus:border-blue-500 focus:outline-none focus:ring-0 peer">
                        <option value="" class="bg-gray-700" :selected="true">Choose time...</option>
                        <option v-for="time in alltimes" :key="time" :value="time.time"
                            :class="time.status ? 'bg-gray-700 text-red-400' : 'bg-gray-700'" :disabled="time.status">
                            {{ time.time }}
                        </option>
                    </select>
                    <label for="lastname"
                        class="peer-focus:font-medium absolute text-base text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6">Time</label>
                </div>

                <!-- <div class="relative z-40 w-full mb-6 group">
          <VueDatePicker
            required
            placeholder="Select Time"
            time-picker
            auto-apply
            :min-time="minTime"
            :max-time="maxTime"
            :start-time="startTime"
            :enable-minutes="false"
            class="block px-0 w-full text-base bg-transparent border-0 border-b-2 ppearance-none text-white border-gray-600 focus:border-blue-500 focus:outline-none focus:ring-0 peer"
            v-model="data.time"
            :is-24="true"
          ></VueDatePicker>
          <label
            for="floating_first_name"
            class="peer-focus:font-medium absolute text-base text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
            >Time</label
          >
        </div> -->
            </div>
        </div>
        <button data-modal-hide="default-modal" type="submit"
            class="text-white focus:ring-4 focus:outline-none font-medium rounded-lg text-base px-5 py-2.5 text-center bg-green-600 hover:bg-green-700 focus:ring-green-800">
            {{ loading ? "Loading..." : "Book Now" }}
        </button>



    </form>
    <div v-show="verifyModal"
        class="fixed top-0 w-full h-screen flex justify-center pt-10 left-0 bg-black/90 text-gray-800">
        <div class="relative bg-white px-6 pt-10 pb-9 shadow-xl mx-auto w-full max-w-lg rounded-2xl h-fit">
            <div class="mx-auto flex w-full max-w-md flex-col space-y-16">
                <div class="flex flex-col items-center justify-center text-center space-y-2">
                    <div class="font-semibold text-3xl">
                        <p>Number Verification</p>
                    </div>
                    <div class="flex flex-row text-sm font-medium text-gray-400">
                        <p>We have sent a code to your number {{ newNumber }}</p>
                    </div>
                    <div v-show="otpError" class="flex flex-row text-sm font-medium text-gray-100 bg-red-500 px-4 py-2 rounded">
                        <p>Wrong Otp</p>
                    </div>
                </div>

                <div>
                    <form v-on:submit.prevent="verifiedNumber" method="post">
                        <div class="flex flex-col space-y-16">
                            <div class="flex flex-row items-center justify-between mx-auto w-full max-w-xs">
                                <div class="w-16 h-16 ">
                                    <input
                                        class="w-full h-full flex flex-col items-center justify-center text-center px-5 outline-none rounded-xl border border-gray-200 text-lg bg-white focus:bg-gray-50 focus:ring-1 ring-blue-700"
                                        type="text" maxlength="1" pattern="[0-9]" inputmode="numeric"
                                        autocomplete="one-time-code" v-model="otps.first" required>
                                </div>
                                <div class="w-16 h-16 ">
                                    <input
                                        class="w-full h-full flex flex-col items-center justify-center text-center px-5 outline-none rounded-xl border border-gray-200 text-lg bg-white focus:bg-gray-50 focus:ring-1 ring-blue-700"
                                        type="text" maxlength="1" pattern="[0-9]" inputmode="numeric"
                                        autocomplete="one-time-code" v-model="otps.second" required>
                                </div>
                                <div class="w-16 h-16 ">

                                    <input
                                        class="w-full h-full flex flex-col items-center justify-center text-center px-5 outline-none rounded-xl border border-gray-200 text-lg bg-white focus:bg-gray-50 focus:ring-1 ring-blue-700"
                                        type="text" maxlength="1" pattern="[0-9]" inputmode="numeric"
                                        autocomplete="one-time-code" v-model="otps.third" required>
                                </div>
                                <div class="w-16 h-16 ">
                                    <input
                                        class="w-full h-full flex flex-col items-center justify-center text-center px-5 outline-none rounded-xl border border-gray-200 text-lg bg-white focus:bg-gray-50 focus:ring-1 ring-blue-700"
                                        type="text" maxlength="1" pattern="[0-9]" inputmode="numeric"
                                        autocomplete="one-time-code" v-model="otps.fourth" required>
                                </div>
                            </div>

                            <div class="flex flex-col space-y-2">
                                <div>
                                    <button type="submit"
                                        class="flex flex-row items-center justify-center text-center w-full border rounded-xl outline-none py-5 bg-blue-700 border-none text-white text-sm shadow-sm">
                                        Verify Phone Number
                                    </button>

                                </div>
                                <div>
                                    <button type="button" @click="verifyModal = false"
                                        class="flex flex-row items-center justify-center text-center w-full border rounded-xl outline-none py-5 bg-gray-700 border-none text-white text-sm shadow-sm">
                                        Close
                                    </button>

                                </div>

                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</template>

<script setup>
import VueDatePicker from "@vuepic/vue-datepicker";
import "@vuepic/vue-datepicker/dist/main.css";
import { ref, onMounted, reactive, watch, inject } from "vue";
import axios from "axios";
import { times } from "lodash";
import debounce from "lodash.debounce";
const Swal = inject('$swal');
const date = ref("");
const time = ref("");
const loading = ref(false);
const props = defineProps(["data", "user", "date"]);
const information = ref([]);
const startTime = ref({ hours: 0, minutes: 0 });
const numberError = ref('');
const otpError = ref(false);
const numberLoader = ref(false)
const verified = ref('')
const verifyModal = ref(false)
const newNumber = ref('');
const otps = reactive({
    first: "",
    second: '',
    third: '',
    fourth: '',
    number: ''
})
const postVerify = async () => {

    verifyModal.value = true;
    await axios.post('/verify/phone_number', { number: newNumber.value });

    otps.number = newNumber.value;
}
const verifiedNumber = async () => {

    const res = await axios.post('/verify/otp', otps);
    if(res.data == false)
    {
        otpError.value = true
        setTimeout(() =>{
            otpError.value = false
        },2000)
    }else{
        Swal.fire('The verification process was successful.')
        verifyModal.value = false;
        verified.value = 'yes'
    }
}
const updateNumber = debounce(async () => {

    const regex = /^\d{11}$/;

    // Test if the input matches the regex
    data.number = newNumber.value;
    if (regex.test(newNumber.value) == false) {
        numberLoader.value = false
        numberError.value = 'Please enter exactly 11 digits'
    } else {

       const {data} = await axios.post('/check/number',{number: newNumber.value});
       if(data == true)
       {
            verified.value = 'yes'
       }else if(data == false)
       {
        verified.value = 'not'
       }
       numberLoader.value = false
        numberError.value = ''
    }
}, 1000)

watch(newNumber, () => {
    numberLoader.value = true
    numberError.value = ''
    updateNumber()
})
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
const alltimes = ref([]);
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
    //   fetchTime(
    //     newData?.branch?.id,
    //     `${props.date.split("-")[0]}/${props.date.split("-")[1]}/${props.date.split("-")[2]}`
    //   );
    data.post_id = newData?.id;
    data.branch_id = newData?.branch?.id;
    data.firstname = newUser?.firstname;
    data.lastname = newUser?.lastname == " " ? "" : newUser?.lastname;
    data.email = newUser?.email;
    //   data.date = `${props.date.split("-")[0]}/${props.date.split("-")[1]}/${
    //     props.date.split("-")[2]
    //   }`;
    minTime.hours = newData.branch?.start_time.split(":")[0];
    minTime.minutes = newData.branch?.start_time.split(":")[1];
    maxTime.hours = newData.branch?.end_time.split(":")[0];
    maxTime.minutes = newData.branch?.end_time.split(":")[1];

    getBranchDate(newData?.branch?.id);
});

const store = async () => {
   if(verified.value == 'yes')
   {
    try {
        loading.value = true;
        const res = await axios.post("/reservation", data);
        if (res.status == 204) {
            alert("All slots are already taken for the day you selected");
        }
        loading.value = false;
        date.value = '';
        data.time = '';
        alltimes.value = [];

        // window.location.href = "/booked";
        Swal.fire('The reservation has been booked!')
    } catch (err) {
        loading.value = false;
        console.log(err.response);
        error.value = err.response.data.errors;
    }
   }else{
            Swal.fire('Please verify your phone number.')
   }
};

// date picker
import { DatePicker } from "v-calendar";
import "v-calendar/style.css";

const disabledDates = ref([
    { start: new Date(2024, 0, 7), end: new Date(2024, 0, 7) },
    { start: new Date(2024, 0, 19), end: new Date(2024, 0, 19) },
]);
watch(date, (n, o) => {
    //   calendar.value = false;
    if (!!n) {
        var inputDate = new Date(n);

        const fulldate = `${inputDate.getMonth() + 1
            }/${inputDate.getDate()}/${inputDate.getFullYear()}`;
        data.date = fulldate;
        fetchTime(data.branch_id, fulldate);
    }
});
const getBranchDate = async (branch_id) => {
    const { data } = await axios.post("/services/branch/" + branch_id);

    disabledDates.value = data.map((value, index) => {
        return { start: value, end: value };
    });
    //   console.log(data);
};
// const openCalendar = (urls, id) => {
//   calendar.value = !calendar.value;
//   getBranchDate(id);
//   url.value = urls;
// };
// const closeCalendar = () => {
//   calendar.value = !calendar.value;
// };
const fetchTime = async (branchId, newDate) => {
    const { data } = await axios.post("/branch/time/" + branchId, { date: newDate });
    alltimes.value = data;
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
</style>
