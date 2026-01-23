import { defineStore } from "pinia";
import ordersApi from "@/api/orders";
import { useCartStore } from "./cart";
import type { Order, OrderStatus, PaginationMeta } from "@/types";

interface OrdersState {
  orders: Order[];
  currentOrder: Order | null;
  pagination: PaginationMeta | null;
  loading: boolean;
  error: string | null;
}

export const useOrdersStore = defineStore("orders", {
  state: (): OrdersState => ({
    orders: [],
    currentOrder: null,
    pagination: null,
    loading: false,
    error: null,
  }),

  actions: {
    async fetchOrders() {
      this.loading = true;
      this.error = null;

      try {
        const response = await ordersApi.getAll();
        this.orders = response.data.data;
        this.pagination = {
          current_page: response.data.current_page,
          last_page: response.data.last_page,
          per_page: response.data.per_page,
          total: response.data.total,
        };
      } catch (error: any) {
        this.error = error.response?.data?.message || "Failed to fetch orders";
        throw error;
      } finally {
        this.loading = false;
      }
    },

    async fetchOrderById(id: number): Promise<Order> {
      this.loading = true;
      this.error = null;

      try {
        const response = await ordersApi.getById(id);
        this.currentOrder = response.data;
        return response.data;
      } catch (error: any) {
        this.error = error.response?.data?.message || "Failed to fetch order";
        throw error;
      } finally {
        this.loading = false;
      }
    },

    async createOrder(): Promise<Order> {
      this.loading = true;
      this.error = null;

      try {
        const cartStore = useCartStore();
        const items = cartStore.getOrderItems();

        if (items.length === 0) {
          throw new Error("Cart is empty");
        }

        const response = await ordersApi.create({ items });

        // Очищаем корзину после успешного создания заказа
        cartStore.clear();

        return response.data;
      } catch (error: any) {
        this.error = error.response?.data?.message || "Failed to create order";
        throw error;
      } finally {
        this.loading = false;
      }
    },

    async updateOrderStatus(id: number, status: OrderStatus): Promise<Order> {
      this.loading = true;
      this.error = null;

      try {
        const response = await ordersApi.updateStatus(id, status);

        // Обновляем заказ в списке
        const index = this.orders.findIndex((order) => order.id === id);
        if (index !== -1) {
          this.orders[index] = response.data;
        }

        return response.data;
      } catch (error: any) {
        this.error =
          error.response?.data?.message || "Failed to update order status";
        throw error;
      } finally {
        this.loading = false;
      }
    },
  },
});
