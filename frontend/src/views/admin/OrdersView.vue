<script setup lang="ts">
import { onMounted } from "vue";
import { useOrdersStore } from "@/stores/orders";
import AppHeader from "@/components/common/AppHeader.vue";
import OrderStatusBadge from "@/components/orders/OrderStatusBadge.vue";
import LoadingSpinner from "@/components/common/LoadingSpinner.vue";
import ErrorMessage from "@/components/common/ErrorMessage.vue";
import type { Order, OrderStatus } from "@/types";

const ordersStore = useOrdersStore();

onMounted(() => {
  ordersStore.fetchOrders();
});

const handleStatusChange = async (order: Order, status: OrderStatus) => {
  try {
    await ordersStore.updateOrderStatus(order.id, status);
  } catch (err: any) {
    alert(err.response?.data?.message || "Ошибка обновления статуса");
  }
};

const formatDate = (date: string | undefined) => {
  if (!date) return "";
  return new Date(date).toLocaleDateString("ru-RU", {
    year: "numeric",
    month: "short",
    day: "numeric",
    hour: "2-digit",
    minute: "2-digit",
  });
};
</script>

<template>
  <div class="min-h-screen flex flex-col">
    <AppHeader />

    <main class="flex-1 bg-gray-50">
      <div class="container mx-auto px-4 py-8">
        <div class="mb-8">
          <h1 class="text-3xl font-bold text-gray-900 mb-2">
            Управление заказами
          </h1>
          <RouterLink
            to="/admin/dashboard"
            class="text-primary-600 hover:text-primary-700"
          >
            ← Назад к дашборду
          </RouterLink>
        </div>

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
          <p class="text-gray-500">Нет заказов</p>
        </div>

        <!-- Orders Table -->
        <div v-else class="bg-white rounded-lg shadow-md overflow-hidden">
          <table class="w-full">
            <thead class="bg-gray-50 border-b">
              <tr>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                >
                  ID
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                >
                  Пользователь
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                >
                  Дата
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                >
                  Товары
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                >
                  Сумма
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                >
                  Статус
                </th>
                <th
                  class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase"
                >
                  Действия
                </th>
              </tr>
            </thead>
            <tbody class="divide-y">
              <tr
                v-for="order in ordersStore.orders"
                :key="order.id"
                class="hover:bg-gray-50"
              >
                <td class="px-6 py-4 text-sm text-gray-900">#{{ order.id }}</td>
                <td class="px-6 py-4 text-sm text-gray-900">
                  {{ order.user?.name || "Пользователь" }}
                  <div class="text-xs text-gray-500">
                    {{ order.user?.email }}
                  </div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">
                  {{ formatDate(order.created_at) }}
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">
                  {{ order.items?.length || 0 }} товар(ов)
                </td>
                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                  ${{ Number(order.total).toFixed(2) }}
                </td>
                <td class="px-6 py-4">
                  <OrderStatusBadge :status="order.status" />
                </td>
                <td class="px-6 py-4 text-right">
                  <select
                    :value="order.status"
                    @change="
                      handleStatusChange(
                        order,
                        ($event.target as HTMLSelectElement)
                          .value as OrderStatus
                      )
                    "
                    class="text-sm border rounded px-2 py-1"
                  >
                    <option value="pending">В ожидании</option>
                    <option value="processing">В обработке</option>
                    <option value="completed">Завершен</option>
                  </select>
                </td>
              </tr>
            </tbody>
          </table>
        </div>
      </div>
    </main>
  </div>
</template>
