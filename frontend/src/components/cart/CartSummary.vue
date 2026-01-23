<script setup lang="ts">
interface Props {
  total: number;
  itemCount: number;
}

const props = defineProps<Props>();
const emit = defineEmits<{
  checkout: [];
}>();
</script>

<template>
  <div class="bg-white rounded-lg shadow-md p-6 sticky top-20">
    <h2 class="text-xl font-bold mb-4">Итого</h2>

    <div class="space-y-2 mb-4">
      <div class="flex justify-between text-gray-600">
        <span>Товаров:</span>
        <span>{{ itemCount }}</span>
      </div>
      <div class="flex justify-between text-gray-600">
        <span>Подытог:</span>
        <span>${{ Number(total).toFixed(2) }}</span>
      </div>
    </div>

    <div class="border-t pt-4 mb-6">
      <div class="flex justify-between text-lg font-bold">
        <span>Всего:</span>
        <span class="text-primary-600">${{ Number(total).toFixed(2) }}</span>
      </div>
    </div>

    <button
      @click="emit('checkout')"
      class="btn btn-primary w-full"
      :disabled="itemCount === 0"
    >
      Оформить заказ
    </button>
  </div>
</template>
