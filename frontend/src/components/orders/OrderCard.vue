<script setup lang="ts">
import OrderStatusBadge from "./OrderStatusBadge.vue";
import type { Order } from "@/types";

interface Props {
  order: Order;
}

const props = defineProps<Props>();

const formatDate = (date: string | undefined) => {
  if (!date) return "";
  return new Date(date).toLocaleDateString("ru-RU", {
    year: "numeric",
    month: "long",
    day: "numeric",
    hour: "2-digit",
    minute: "2-digit",
  });
};
</script>

<template>
  <div class="card hover:shadow-xl transition-shadow">
    <div class="flex items-start justify-between mb-4">
      <div>
        <h3 class="text-lg font-semibold text-gray-900">
          Заказ #{{ order.id }}
        </h3>
        <p class="text-sm text-gray-500">
          {{ formatDate(order.created_at) }}
        </p>
      </div>
      <OrderStatusBadge :status="order.status" />
    </div>

    <div class="space-y-2 mb-4">
      <div
        v-for="item in order.items"
        :key="item.id"
        class="flex justify-between text-sm"
      >
        <span class="text-gray-700">
          {{ item.product?.name || "Товар" }} × {{ item.quantity }}
        </span>
        <span class="text-gray-900 font-medium">
          ${{ (Number(item.price) * Number(item.quantity)).toFixed(2) }}
        </span>
      </div>
    </div>

    <div class="border-t pt-4 flex justify-between items-center">
      <span class="text-gray-700 font-medium">Итого:</span>
      <span class="text-xl font-bold text-primary-600">
        ${{ Number(order.total).toFixed(2) }}
      </span>
    </div>
  </div>
</template>
