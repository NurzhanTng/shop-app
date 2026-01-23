<script setup lang="ts">
import { onMounted, ref } from "vue";
import statsApi from "@/api/stats";
import AppHeader from "@/components/common/AppHeader.vue";
import LoadingSpinner from "@/components/common/LoadingSpinner.vue";
import OrderStatusBadge from "@/components/orders/OrderStatusBadge.vue";
import type { AdminStats } from "@/types";

const stats = ref<AdminStats | null>(null);
const loading = ref(false);

onMounted(async () => {
  loading.value = true;
  try {
    const response = await statsApi.getStats();
    stats.value = response.data;
  } catch (error) {
    console.error("Failed to load stats:", error);
  } finally {
    loading.value = false;
  }
});
</script>

<template>
  <div class="min-h-screen flex flex-col">
    <AppHeader />

    <main class="flex-1 bg-gray-50">
      <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
          <h1 class="text-3xl font-bold text-gray-900 mb-2">
            Панель администратора
          </h1>
          <div class="flex gap-4">
            <RouterLink
              to="/admin/products"
              class="text-primary-600 hover:text-primary-700"
            >
              Управление товарами
            </RouterLink>
            <RouterLink
              to="/admin/orders"
              class="text-primary-600 hover:text-primary-700"
            >
              Управление заказами
            </RouterLink>
          </div>
        </div>

        <div v-if="loading" class="flex justify-center py-12">
          <LoadingSpinner size="lg" />
        </div>

        <div v-else-if="stats">
          <!-- Stats Cards -->
          <div
            class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8"
          >
            <div class="card">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm text-gray-600">Пользователи</p>
                  <p class="text-3xl font-bold text-gray-900">
                    {{ stats.total_users }}
                  </p>
                </div>
                <div
                  class="w-12 h-12 bg-blue-100 rounded-lg flex items-center justify-center"
                >
                  <svg
                    class="w-6 h-6 text-blue-600"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                    />
                  </svg>
                </div>
              </div>
            </div>

            <div class="card">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm text-gray-600">Товары</p>
                  <p class="text-3xl font-bold text-gray-900">
                    {{ stats.total_products }}
                  </p>
                </div>
                <div
                  class="w-12 h-12 bg-green-100 rounded-lg flex items-center justify-center"
                >
                  <svg
                    class="w-6 h-6 text-green-600"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"
                    />
                  </svg>
                </div>
              </div>
            </div>

            <div class="card">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm text-gray-600">Всего заказов</p>
                  <p class="text-3xl font-bold text-gray-900">
                    {{ stats.total_orders }}
                  </p>
                </div>
                <div
                  class="w-12 h-12 bg-purple-100 rounded-lg flex items-center justify-center"
                >
                  <svg
                    class="w-6 h-6 text-purple-600"
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
                </div>
              </div>
            </div>

            <div class="card">
              <div class="flex items-center justify-between">
                <div>
                  <p class="text-sm text-gray-600">Выручка</p>
                  <p class="text-3xl font-bold text-gray-900">
                    ${{ Number(stats.total_revenue).toFixed(2) }}
                  </p>
                </div>
                <div
                  class="w-12 h-12 bg-yellow-100 rounded-lg flex items-center justify-center"
                >
                  <svg
                    class="w-6 h-6 text-yellow-600"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                  >
                    <path
                      stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"
                    />
                  </svg>
                </div>
              </div>
            </div>
          </div>

          <!-- Recent Orders -->
          <div class="card">
            <h2 class="text-xl font-bold mb-4">Последние заказы</h2>

            <div
              v-if="stats.recent_orders.length === 0"
              class="text-center py-8 text-gray-500"
            >
              Нет заказов
            </div>

            <div v-else class="space-y-4">
              <div
                v-for="order in stats.recent_orders"
                :key="order.id"
                class="flex items-center justify-between p-4 bg-gray-50 rounded-lg"
              >
                <div>
                  <p class="font-semibold">Заказ #{{ order.id }}</p>
                  <p class="text-sm text-gray-600">
                    {{ order.user?.name || "Пользователь" }}
                  </p>
                </div>
                <div class="text-right">
                  <p class="font-bold text-primary-600">
                    ${{ Number(order.total).toFixed(2) }}
                  </p>
                  <OrderStatusBadge :status="order.status" />
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>
