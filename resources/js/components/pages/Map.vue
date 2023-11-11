<template>
  <div class=" lg:w-3/5 mx-auto h-[30rem]">
    <l-map ref="map" v-model:zoom="zoom" :center="[15.144271865053565, 120.59291644747233]">
      <l-tile-layer
        url="https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png"
        layer-type="base"
        name="OpenStreetMap"
      ></l-tile-layer>

        <l-marker v-for="(marker ,index) in markers" :key="index" attribution="dsada" :lat-lng="marker[0]" @click="show(marker[1][0])">
           <l-tooltip>{{marker[1][0]['name']}}</l-tooltip>
        </l-marker>
        
    
   
    </l-map>
  </div>
</template>
<script setup>
  import parseJson from "parse-json";
  import "leaflet/dist/leaflet.css";
import { LMap, LTileLayer ,LMarker ,LTooltip} from "@vue-leaflet/vue-leaflet";
import {ref , reactive ,onMounted} from 'vue';
const props = defineProps(["locations"]);
const zoom = ref(11);
const markers = reactive([]);
onMounted(() =>{
  const newData = parseJson(props.locations);
  newData.forEach( function(element, index) {
    markers.push([[element.lat_long.split(',')[0] , element.lat_long.split(',')[1]], [element]]);
  });
  
})
const show = (branch) => {
    window.location.href = `/view?branch=${branch.name}&q=${branch.id}`
}
</script>