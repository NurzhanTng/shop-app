<script setup lang="ts">
import { onMounted } from "vue";
import { useOrdersStore } from "@/stores/orders";
import AppHeader from "@/components/common/AppHeader.vue";
import OrderCard from "@/components/orders/OrderCard.vue";
import LoadingSpinner from "@/components/common/LoadingSpinner.vue";
import ErrorMessage from "@/components/common/ErrorMessage.vue";

const ordersStore = useOrdersStore();

onMounted(() => {
  ordersStore.fetchOrders();
});
</script>

<template>
  <div class="min-h-screen flex flex-col">
    <AppHeader />

    <main class="flex-1 bg-gray-50">
      <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Мои заказы</h1>

        <!-- Loading -->
        <div v-if="ordersStore.loading" class="flex justify-center py-12">
          <LoadingSpinner size="lg" />
        </div>

        <!-- Error -->
        <ErrorMessage
          v-else-if="ordersStore.error"
          :message="ordersStore.error"
        />

        <!-- Empty State -->
        <div
          v-else-if="ordersStore.orders.length === 0"
          class="text-center py-12"
        >
          <svg
            class="w-24 h-24 mx-auto text-gray-300 mb-4"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
          >
            <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"
            />
          </svg>
          <h2 class="text-2xl font-semibold text-gray-600 mb-4">
            У вас пока нет заказов
          </h2>
          <p class="text-gray-500 mb-6">Сделайте свой первый заказ!</p>
          <RouterLink to="/" class="btn btn-primary">
            Перейти к покупкам
          </RouterLink>
        </div>

        <!-- Orders List -->
        <div
          v-else
          class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6"
        >
          <OrderCard
            v-for="order in ordersStore.orders"
            :key="order.id"
            :order="order"
          />
        </div>
      </div>
    </main>
  </div>
</template>
