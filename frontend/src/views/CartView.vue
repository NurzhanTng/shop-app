<script setup lang="ts">
import { useCartStore } from "@/stores/cart";
import { useRouter } from "vue-router";
import AppHeader from "@/components/common/AppHeader.vue";
import CartItem from "@/components/cart/CartItem.vue";
import CartSummary from "@/components/cart/CartSummary.vue";

const cartStore = useCartStore();
const router = useRouter();

const updateQuantity = (productId: number, quantity: number) => {
  cartStore.updateQuantity(productId, quantity);
};

const removeItem = (productId: number) => {
  cartStore.removeItem(productId);
};

const goToCheckout = () => {
  router.push("/checkout");
};

const continueShopping = () => {
  router.push("/");
};
</script>

<template>
  <div class="min-h-screen flex flex-col">
    <AppHeader />

    <main class="flex-1 bg-gray-50">
      <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold text-gray-900 mb-8">Корзина</h1>

        <!-- Empty Cart -->
        <div v-if="cartStore.items.length === 0" class="text-center py-12">
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
              d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
            />
          </svg>
          <h2 class="text-2xl font-semibold text-gray-600 mb-4">
            Корзина пуста
          </h2>
          <p class="text-gray-500 mb-6">
            Добавьте товары в корзину, чтобы продолжить
          </p>
          <button @click="continueShopping" class="btn btn-primary">
            Перейти к покупкам
          </button>
        </div>

        <!-- Cart Items -->
        <div v-else class="grid grid-cols-1 lg:grid-cols-3 gap-8">
          <!-- Items List -->
          <div class="lg:col-span-2 space-y-4">
            <CartItem
              v-for="item in cartStore.items"
              :key="item.product_id"
              :item="item"
              @update-quantity="updateQuantity"
              @remove="removeItem"
            />
          </div>

          <!-- Summary -->
          <div class="lg:col-span-1">
            <CartSummary
              :total="cartStore.total"
              :item-count="cartStore.itemCount"
              @checkout="goToCheckout"
            />
          </div>
        </div>
      </div>
    </main>
  </div>
</template>
