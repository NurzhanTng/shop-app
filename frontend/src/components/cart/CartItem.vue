<script setup lang="ts">
import type { CartItem } from "@/types";

interface Props {
  item: CartItem;
}

const props = defineProps<Props>();
const emit = defineEmits<{
  updateQuantity: [productId: number, quantity: number];
  remove: [productId: number];
}>();

const updateQuantity = (newQuantity: number) => {
  if (newQuantity > 0) {
    emit("updateQuantity", props.item.product_id, newQuantity);
  }
};

const removeItem = () => {
  emit("remove", props.item.product_id);
};
</script>

<template>
  <div class="flex gap-4 p-4 bg-white rounded-lg border">
    <!-- Image -->
    <div class="w-20 h-20 flex-shrink-0 bg-gray-100 rounded-lg overflow-hidden">
      <img
        v-if="item.image_url"
        :src="item.image_url"
        :alt="item.name"
        class="w-full h-full object-cover"
      />
      <div
        v-else
        class="w-full h-full flex items-center justify-center text-gray-400"
      >
        <svg
          class="w-8 h-8"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
          />
        </svg>
      </div>
    </div>

    <!-- Details -->
    <div class="flex-1 flex flex-col justify-between">
      <div>
        <h3 class="font-semibold text-gray-900">{{ item.name }}</h3>
        <p class="text-sm text-gray-500">
          ${{ Number(item.price).toFixed(2) }} за шт.
        </p>
      </div>

      <!-- Quantity Controls -->
      <div class="flex items-center gap-3">
        <button
          @click="updateQuantity(item.quantity - 1)"
          class="w-8 h-8 flex items-center justify-center border rounded hover:bg-gray-100"
        >
          -
        </button>
        <span class="w-8 text-center font-medium">{{ item.quantity }}</span>
        <button
          @click="updateQuantity(item.quantity + 1)"
          class="w-8 h-8 flex items-center justify-center border rounded hover:bg-gray-100"
        >
          +
        </button>
      </div>
    </div>

    <!-- Price & Remove -->
    <div class="flex flex-col items-end justify-between">
      <button @click="removeItem" class="text-red-600 hover:text-red-800">
        <svg
          class="w-5 h-5"
          fill="none"
          stroke="currentColor"
          viewBox="0 0 24 24"
        >
          <path
            stroke-linecap="round"
            stroke-linejoin="round"
            stroke-width="2"
            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"
          />
        </svg>
      </button>

      <p class="text-lg font-bold text-primary-600">
        ${{ (Number(item.price) * Number(item.quantity)).toFixed(2) }}
      </p>
    </div>
  </div>
</template>
