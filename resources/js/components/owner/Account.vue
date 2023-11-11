<template>
  <div>
    <button
      @click="modal = !modal"
      type="button"
      class="focus:outline-none text-white font-medium rounded-lg text-sm px-5 py-2.5 mr-2 mb-2 bg-green-600 hover:bg-green-700 focus:ring-green-800"
    >
      Add Employee
    </button>

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
        <form @submit.prevent="store" class="relative rounded-lg shadow bg-gray-700">
          <!-- Modal header -->
          <div
            class="flex items-start justify-between p-4 border-b rounded-t border-gray-600"
          >
            <h3 class="text-xl font-semibold text-white">Create Employee</h3>
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
              <div class="relative z-0 w-full mb-6 group">
                <input
                  type="email"
                  name="floating_email"
                  id="floating_email"
                  class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none text-white border-gray-600 focus:border-blue-500 focus:outline-none focus:ring-0 peer"
                  placeholder=" "
                  required
                  v-model="data.email"
                />
                <label
                  for="floating_email"
                  class="peer-focus:font-medium absolute text-sm text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                  >Email address</label
                >
                 <small class="text-red-300" v-if="error.email">{{error?.email[0]}}</small>
              </div>
              <div class="relative z-0 w-full mb-6 group">
                <input
                  type="password"
                  name="password"
                  id="password"
                  autocomplete="on"
                  class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none text-white border-gray-600 focus:border-blue-500 focus:outline-none focus:ring-0 peer"
                  placeholder=" "
                  required
                  v-model="data.password"
                />
                <label
                  for="password"
                  class="peer-focus:font-medium absolute text-sm text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                  >Password</label
                >
                 <small class="text-red-300" v-if="error.password">{{error?.password[0]}}</small>
              </div>
              <div class="relative z-0 w-full mb-6 group">
                <input
                  type="file"
                  name="profile"
                  id="profile"
                  class="block py-2.5 px-0 w-full text-sm bg-transparent border-0 border-b-2 appearance-none text-white border-gray-600 focus:border-blue-500 focus:outline-none focus:ring-0 peer"
                  placeholder=" "
                  required
                  @change="upload"
                />
                <label
                  for="profile"
                  class="peer-focus:font-medium absolute text-sm text-gray-400 duration-300 transform -translate-y-6 scale-75 top-3 -z-10 origin-[0] peer-focus:left-0 peer-focus:text-blue-500 peer-placeholder-shown:scale-100 peer-placeholder-shown:translate-y-0 peer-focus:scale-75 peer-focus:-translate-y-6"
                  >Profile</label
                >
              </div>
            </div>
          </div>
          <!-- Modal footer -->
          <div class="flex items-center p-6 space-x-2 border-t rounded-b border-gray-600">
            <button
              data-modal-hide="default-modal"
              type="submit"
              class="text-white focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-blue-600 hover:bg-blue-700 focus:ring-blue-800"
            >
              {{loading ? 'Loading...' : 'Add Employee'}}
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
import { reactive, ref } from "vue";
import axios from "axios";
const modal = ref(false);
const data = reactive({
  firstname: "",
  lastname: "",
  email: "",
  password: "",
  profile: "",
});
const error = ref([]);
const loading = ref(false);
const upload = (e) => {
  data.profile = e.target.files[0];
};

const store = async () => {
    try {
      loading.value = false
        var formData = new FormData();
  formData.append("profile", data.profile);
  formData.append("firstname", data.firstname);
  formData.append("lastname", data.lastname);
  formData.append("email", data.email);
  formData.append("password", data.password);
  await axios.post("/owner/account", formData);
  alert("success");
  window.location.reload();
    } catch(err) {
      loading.value = true
      error.value = err.response.data.errors;
    }
};
</script>
