import { defineStore } from "pinia";
import type { CartItem, Product, CreateOrderItem } from "@/types";

interface CartState {
  items: CartItem[];
}

export const useCartStore = defineStore("cart", {
  state: (): CartState => ({
    items: JSON.parse(localStorage.getItem("cart") || "[]"),
  }),

  getters: {
    itemCount: (state): number => {
      return state.items.reduce((sum, item) => sum + item.quantity, 0);
    },

    total: (state): number => {
      return state.items.reduce(
        (sum, item) => sum + item.price * item.quantity,
        0
      );
    },

    formattedTotal(): string {
      return `$${this.total.toFixed(2)}`;
    },
  },

  actions: {
    addItem(product: Product, quantity: number = 1): void {
      const existingItem = this.items.find(
        (item) => item.product_id === product.id
      );

      if (existingItem) {
        existingItem.quantity += quantity;
      } else {
        this.items.push({
          product_id: product.id,
          name: product.name,
          price: product.price,
          quantity: quantity,
          image_url: product.image_url,
        });
      }

      this.saveToLocalStorage();
    },

    updateQuantity(productId: number, quantity: number): void {
      const item = this.items.find((item) => item.product_id === productId);

      if (item) {
        if (quantity <= 0) {
          this.removeItem(productId);
        } else {
          item.quantity = quantity;
          this.saveToLocalStorage();
        }
      }
    },

    removeItem(productId: number): void {
      this.items = this.items.filter((item) => item.product_id !== productId);
      this.saveToLocalStorage();
    },

    clear(): void {
      this.items = [];
      this.saveToLocalStorage();
    },

    saveToLocalStorage(): void {
      localStorage.setItem("cart", JSON.stringify(this.items));
    },

    // Подготовка данных для создания заказа
    getOrderItems(): CreateOrderItem[] {
      return this.items.map((item) => ({
        product_id: item.product_id,
        quantity: item.quantity,
        price: item.price,
      }));
    },
  },
});
