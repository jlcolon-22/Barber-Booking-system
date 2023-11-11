<template>
  <div>
    <button @click="show" class="font-medium text-green-500 hover:underline">Edit</button>

    <!-- Main modal -->
    <div
      v-show="modal"
      id="default-modal"
      tabindex="-1"
      aria-hidden="true"
      class="fixed top-0 left-0 right-0 z-50 w-full p-4 overflow-x-hidden flex justify-center overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full"
    >
      <div class="relative w-full max-w-2xl max-h-full">
        <!-- Modal content -->
        <form @submit.prevent="update" class="relative rounded-lg shadow bg-gray-700">
          <!-- Modal header -->
          <div
            class="flex items-start justify-between p-4 border-b rounded-t border-gray-600"
          >
            <h3 class="text-xl font-semibold text-white">Update Branch</h3>
            <button
              @click="modal = !modal"
              type="button"
              class="text-gray-400 bg-transparentrounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center hover:bg-gray-600 hover:text-white"
              data-modal-hide="default-modal"
            >
              <svg
                class="w-3 h-3"
                aria-hidden="true"
                xmlns="http://www.w3.org/2000/svg"
                fill="none"
                viewBox="0 0 14 14"
              >
                <path
                  stroke="currentColor"
                  stroke-linecap="round"
                  stroke-linejoin="round"
                  stroke-width="2"
                  d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
                />
              </svg>
              <span class="sr-only">Close modal</span>
            </button>
          </div>
          <!-- Modal body -->
          <div class="p-6 space-y-6">
             <div>
    <div class="grid md:grid-cols-2 md:gap-6">
      <div class="relative z-0 w-full mb-6 group">
        <input
        type="text"
        class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 ppearance-none text-white border-gray-600 focus:border-blue-500 focus:outline-none focus:ring-0 peer"
        placeholder=" "
        required
        v-model="data.name"
        />
        <label
        for="floating_first_name"
        class="peer-focus:font-medium absolute text-sm text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
        >Branch Name</label
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
      </div>
    </div>
    <div class="relative z-0 w-full mb-6 group">
      <select
      v-model="data.status"
      class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none text-white border-gray-600 focus:border-blue-500 focus:outline-none focus:ring-0 peer"
      >
      <option value="" class="bg-gray-700">Status</option>
      <option value="1" class="bg-gray-700">Active</option>
      <option value="0" class="bg-gray-700">Inactive</option>
    </select>
    <label
    for="lastname"
    class="peer-focus:font-medium absolute text-sm text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
    >Status</label
    >
  </div>
  <div class="relative z-0 w-full mb-6 group">
   <input
   type="email"
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
 <div class="grid md:grid-cols-2 md:gap-6">
   <div class="relative z-0 w-full mb-6 group">
    <input
    type="time"
    class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 ppearance-none text-white border-gray-600 focus:border-blue-500 focus:outline-none focus:ring-0 peer"
    placeholder=" "
    required
    v-model="data.start_time"
    />
    <label
    for="floating_first_name"
    class="peer-focus:font-medium absolute text-sm text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
    >Start Time</label
    >
  </div>
  <div class="relative z-0 w-full mb-6 group">
    <input
    type="time"
    class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 ppearance-none text-white border-gray-600 focus:border-blue-500 focus:outline-none focus:ring-0 peer"
    placeholder=" "
    required
    v-model="data.end_time"
    />
    <label
    for="floating_first_name"
    class="peer-focus:font-medium absolute text-sm text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
    >End TIme</label
    >
  </div>
  
</div>

<div class="relative z-0 w-full mb-6 group">
  <select
  v-model="data.owner_id"
  class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none text-white border-gray-600 focus:border-blue-500 focus:outline-none focus:ring-0 peer"
  >
  <option
  class="bg-gray-700"
  v-for="(owner, index) in parseJson(owners)"
  :key="index"
  :value="owner.id"
  >
  {{ owner.firstname + " " + owner.lastname }}
</option>
</select>
<label
for="password"
class="peer-focus:font-medium absolute text-sm text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
>Owner</label
>
</div>

<div class="relative z-0 w-full mb-6 group">
  <input
  type="text"
  autocomplete="no"
  class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none text-white border-gray-600 focus:border-blue-500 focus:outline-none focus:ring-0 peer"
  placeholder=" "
  required
  v-model="data.location"
  />
  <label
  for="floating_email"
  class="peer-focus:font-medium absolute text-sm text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
  >Branch Complete Address</label
  >
</div>

<div class="relative z-0 w-full mb-6 group">
  <input
  type="text"
  autocomplete="no"
  class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none text-white border-gray-600 focus:border-blue-500 focus:outline-none focus:ring-0 peer"
  placeholder=" "
  required
  v-model="data.lat_long"
  />
  <label
  for="floating_email"
  class="peer-focus:font-medium absolute text-sm text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
  >Latitude and longitude</label
  >
</div>


<div class="relative z-0 w-full mb-6 group">
  <input
  type="file"
  name="profile"
  id="profile"
  class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none text-white border-gray-600 focus:border-blue-500 focus:outline-none focus:ring-0 peer"
  placeholder=" "
  
  @change="upload"
  />
  <label
  for="profile"
  class="peer-focus:font-medium absolute text-sm text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
  >Branch Photo</label
  >
</div>
</div>
          </div>
          <!-- Modal footer -->
          <div class="flex items-center p-6 space-x-2 border-t rounded-b border-gray-600">
            <button
              data-modal-hide="default-modal"
              type="submit"
              class="text-white focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-green-600 hover:bg-green-700 focus:ring-green-800"
            >
              {{loading ? 'Loading...' : 'Update Branch'}}
            </button>
            <button
              @click="modal = !modal"
              type="button"
              class="focus:ring-4 focus:outline-none rounded-lg border text-sm font-medium px-5 py-2.5 focus:z-10 bg-gray-700 text-gray-300 border-gray-500 hover:text-white hover:bg-gray-600 focus:ring-gray-600"
            >
              Decline
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>
<script setup>
import parseJson from "parse-json";
import { ref, reactive } from "vue";
import axios from "axios";
const props = defineProps(["data", "owners"]);
const loading = ref(false)
const modal = ref(false);
  const data = reactive({
    name: "",
    number: "",
    status: "",
    location: "",
    email: "",
    owner_id: "",
    photo: "",
    start_time: '',
    end_time: '',
    lat_long: ''
  });
const upload = (e) => {
  data.photo = e.target.files[0];
};
const update = async () => {
  loading.value = true
  var formData = new FormData();
formData.append("photo", data.photo);
    formData.append("name", data.name);
    formData.append("owner_id", data.owner_id);
    formData.append("email", data.email);
    formData.append("number", data.number);
    formData.append("location", data.location);
    formData.append("status", data.status);
    formData.append("start_time", data.start_time);
    formData.append("end_time", data.end_time);
    formData.append("lat_long", data.lat_long);
  await axios.post("/admin/branch/" + parseJson(props.data)?.id, formData);
  alert("updated successfully");
  window.location.reload();
};
const show = () => {
  const parseProps = parseJson(props.data);
  data.email = parseProps.email;
  data.name = parseProps.name;
  data.location = parseProps.location;
  data.status = parseProps.status;
  data.owner_id = parseProps.owner_id;
  data.number = parseProps.number;
  data.status = parseProps.status;
  data.start_time = parseProps.start_time;
  data.end_time = parseProps.end_time;
  data.lat_long = parseProps.lat_long;

  modal.value = true;
};
</script>
