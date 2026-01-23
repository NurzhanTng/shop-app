<script setup lang="ts">
interface Props {
  size?: "sm" | "md" | "lg";
}

const props = withDefaults(defineProps<Props>(), {
  size: "md",
});

const sizeClasses = {
  sm: "w-4 h-4 border-2",
  md: "w-8 h-8 border-4",
  lg: "w-12 h-12 border-4",
};
</script>

<template>
  <div class="flex justify-center items-center">
    <div
      :class="[
        'animate-spin rounded-full border-t-primary-600 border-r-primary-600 border-b-transparent border-l-transparent',
        sizeClasses[size],
      ]"
    ></div>
  </div>
</template>
