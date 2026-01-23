<script setup lang="ts">
import { ref } from "vue";
import { useCartStore } from "@/stores/cart";
import { useOrdersStore } from "@/stores/orders";
import { useRouter } from "vue-router";
import AppHeader from "@/components/common/AppHeader.vue";
import LoadingSpinner from "@/components/common/LoadingSpinner.vue";
import ErrorMessage from "@/components/common/ErrorMessage.vue";

const cartStore = useCartStore();
const ordersStore = useOrdersStore();
const router = useRouter();

const loading = ref(false);
const error = ref<string | null>(null);
const success = ref(false);

const handleSubmit = async () => {
  if (cartStore.items.length === 0) {
    error.value = "Корзина пуста";
    return;
  }

  loading.value = true;
  error.value = null;

  try {
    const order = await ordersStore.createOrder();
    success.value = true;

    // Перенаправляем на страницу заказов через 2 секунды
    setTimeout(() => {
      router.push("/orders");
    }, 2000);
  } catch (err: any) {
    error.value = err.response?.data?.message || "Не удалось создать заказ";
  } finally {
    loading.value = false;
  }
};
</script>

<template>
  <div class="min-h-screen flex flex-col">
    <AppHeader />

    <main class="flex-1 bg-gray-50">
      <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Оформление заказа</h1>

        <div class="max-w-2xl mx-auto">
          <!-- Success Message -->
          <div
            v-if="success"
            class="bg-green-50 border border-green-200 text-green-800 px-6 py-4 rounded-lg mb-6"
          >
            <div class="flex items-center gap-3">
              <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                <path
                  fill-rule="evenodd"
                  d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                  clip-rule="evenodd"
                />
              </svg>
              <div>
                <p class="font-semibold">Заказ успешно создан!</p>
                <p class="text-sm">Перенаправление на страницу заказов...</p>
              </div>
            </div>
          </div>

          <!-- Error Message -->
          <ErrorMessage
            v-if="error"
            :message="error"
            dismissible
            @dismiss="error = null"
            class="mb-6"
          />

          <!-- Order Summary -->
          <div class="bg-white rounded-lg shadow-md p-6 mb-6">
            <h2 class="text-xl font-bold mb-4">Ваш заказ</h2>

            <div class="space-y-3 mb-4">
              <div
                v-for="item in cartStore.items"
                :key="item.product_id"
                class="flex justify-between text-sm"
              >
                <span class="text-gray-700">
                  {{ item.name }} × {{ item.quantity }}
                </span>
                <span class="font-medium">
                  ${{ (item.price * item.quantity).toFixed(2) }}
                </span>
              </div>
            </div>

            <div class="border-t pt-4">
              <div class="flex justify-between text-lg font-bold">
                <span>Итого:</span>
                <span class="text-primary-600">{{
                  cartStore.formattedTotal
                }}</span>
              </div>
            </div>
          </div>

          <!-- Confirm Button -->
          <button
            @click="handleSubmit"
            :disabled="loading || cartStore.items.length === 0"
            class="btn btn-primary w-full text-lg py-4"
          >
            <LoadingSpinner v-if="loading" size="sm" />
            <span v-else>Подтвердить заказ</span>
          </button>
        </div>
      </div>
    </main>
  </div>
</template>
