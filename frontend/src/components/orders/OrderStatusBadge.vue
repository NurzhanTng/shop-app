<script setup lang="ts">
import type { OrderStatus } from "@/types";

interface Props {
  status: OrderStatus;
}

const props = defineProps<Props>();

const statusConfig: Record<OrderStatus, { label: string; class: string }> = {
  pending: {
    label: "В ожидании",
    class: "bg-yellow-100 text-yellow-800",
  },
  processing: {
    label: "В обработке",
    class: "bg-blue-100 text-blue-800",
  },
  completed: {
    label: "Завершен",
    class: "bg-green-100 text-green-800",
  },
};
</script>

<template>
  <span
    :class="[
      'px-3 py-1 rounded-full text-sm font-medium',
      statusConfig[status].class,
    ]"
  >
    {{ statusConfig[status].label }}
  </span>
</template>
