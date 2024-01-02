<template>
  <div class="grid grid-cols-3 gap-10">
    <div v-for="branch in branches" :key="branch.id" class="bg-white">
      <img
        :src="branch?.photo"
        class="object-cover min-h-[20rem] max-h-[20rem] w-full"
        alt=""
      />
      <div class="p-2 grid">
        <div class="text-2xl text-black font-semibold">{{ branch.name }}</div>
        <a
          :href="`/view?branch=${branch.name}&q=${branch.id}`"
          class="bg-blue-500 text-center py-2"
          >view</a
        >
      </div>
    </div>
  </div>
</template>
<script setup>
import { onMounted, ref } from "vue";
const props = defineProps(["locations"]);
const branches = ref([]);
onMounted(() => {
  branches.value = JSON.parse(props.locations);
});
</script>
