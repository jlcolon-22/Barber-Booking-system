<template>
  <div
    v-if="mapToggle"
    tabindex="-1"
    aria-hidden="true"
    class="fixed top-0 left-0 right-0 z-50 flex justify-center pt-10 w-full px-4 pb-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full"
  >
    <div class="relative w-full max-w-2xl max-h-full">
      <!-- Modal content -->
      <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <!-- Modal header -->
        <div
          class="flex items-start justify-between p-4 border-b rounded-t dark:border-gray-600"
        >
          <h3 class="text-xl font-semibold text-gray-900 dark:text-white">Map</h3>
          <button
            @click="mapToggle = !mapToggle"
            type="button"
            class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ml-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white"
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
        <div class="space-y-6 max-h-[30rem] overflow-y-auto">
          <div v-if="mapToggle" class="w-full mx-auto h-[30rem]">
            <l-map
              ref="map"
              v-model:zoom="zoom"
              :center="[15.144271865053565, 120.59291644747233]"
            >
              <l-tile-layer
                url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
                layer-type="base"
                name="OpenStreetMap"
              ></l-tile-layer>

              <l-marker
                v-for="(marker, index) in markers"
                :key="index"
                attribution="dsada"
                :lat-lng="marker[0]"
                @click="show(marker[1][0])"
              >
                <l-tooltip>{{ marker[1][0]["name"] }}</l-tooltip>
              </l-marker>
            </l-map>
          </div>
        </div>
      </div>
    </div>
  </div>

  <a
    @click="mapToggle = !mapToggle"
    class="bg-blue-600 p-2 rounded text-sm text-white underline"
    >view map</a
  >
</template>
<script setup>
import parseJson from "parse-json";
import "leaflet/dist/leaflet.css";
import { LMap, LTileLayer, LMarker, LTooltip } from "@vue-leaflet/vue-leaflet";
import { ref, reactive, onMounted, watch } from "vue";
const props = defineProps(["locations"]);
const zoom = ref(12);
const markers = reactive([]);
const mapToggle = ref(false);
watch(props, (n, o) => {
  console.log(n);
});
onMounted(() => {
  const newData = parseJson(props.locations);
  //   newData.forEach(function (element, index) {
  //     markers.push([
  //       [element.lat_long.split(",")[0], element.lat_long.split(",")[1]],
  //       [element],
  //     ]);
  //   });
  markers.push([
    [newData.lat_long.split(",")[0], newData.lat_long.split(",")[1]],
    [newData],
  ]);
});
const show = (branch) => {
  window.location.href = `/view?branch=${branch.name}&q=${branch.id}`;
};
</script>
