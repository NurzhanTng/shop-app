<script setup lang="ts">
import { onMounted, ref } from "vue";
import { useRoute, useRouter } from "vue-router";
import { useProductsStore } from "@/stores/products";
import { useCartStore } from "@/stores/cart";
import AppHeader from "@/components/common/AppHeader.vue";
import LoadingSpinner from "@/components/common/LoadingSpinner.vue";
import ErrorMessage from "@/components/common/ErrorMessage.vue";

const route = useRoute();
const router = useRouter();
const productsStore = useProductsStore();
const cartStore = useCartStore();

const quantity = ref(1);

onMounted(async () => {
  try {
    await productsStore.fetchProductById(Number(route.params.id));
  } catch (error) {
    console.error("Failed to load product:", error);
  }
});

const addToCart = () => {
  if (productsStore.currentProduct) {
    cartStore.addItem(productsStore.currentProduct, quantity.value);
    router.push("/cart");
  }
};

const goBack = () => {
  router.push("/");
};
</script>

<template>
  <div class="min-h-screen flex flex-col">
    <AppHeader />

    <main class="flex-1 bg-gray-50">
      <div class="container mx-auto px-4 py-8">
        <!-- Back Button -->
        <button
          @click="goBack"
          class="flex items-center gap-2 text-gray-600 hover:text-gray-900 mb-6"
        >
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
              d="M15 19l-7-7 7-7"
            />
          </svg>
          Назад к каталогу
        </button>

        <!-- Loading -->
        <div v-if="productsStore.loading" class="flex justify-center py-12">
          <LoadingSpinner size="lg" />
        </div>

        <!-- Error -->
        <ErrorMessage
          v-else-if="productsStore.error"
          :message="productsStore.error"
        />

        <!-- Product Details -->
        <div
          v-else-if="productsStore.currentProduct"
          class="grid grid-cols-1 lg:grid-cols-2 gap-8"
        >
          <!-- Image -->
          <div class="bg-white rounded-lg p-8">
            <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden">
              <img
                v-if="productsStore.currentProduct.image_url"
                :src="productsStore.currentProduct.image_url"
                :alt="productsStore.currentProduct.name"
                class="w-full h-full object-cover"
              />
              <div
                v-else
                class="w-full h-full flex items-center justify-center text-gray-400"
              >
                <svg
                  class="w-32 h-32"
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
          </div>

          <!-- Info -->
          <div class="bg-white rounded-lg p-8">
            <div class="mb-4">
              <p class="text-sm text-gray-500 mb-2">
                {{ productsStore.currentProduct.category?.name }}
              </p>
              <h1 class="text-3xl font-bold text-gray-900 mb-4">
                {{ productsStore.currentProduct.name }}
              </h1>
              <p class="text-gray-700 leading-relaxed">
                {{ productsStore.currentProduct.description }}
              </p>
            </div>

            <div class="border-t border-b py-6 my-6">
              <p class="text-4xl font-bold text-primary-600">
                ${{ Number(productsStore.currentProduct.price).toFixed(2) }}
              </p>
            </div>

            <!-- Quantity -->
            <div class="mb-6">
              <label class="block text-sm font-medium text-gray-700 mb-2">
                Количество
              </label>
              <div class="flex items-center gap-4">
                <button
                  @click="quantity = Math.max(1, quantity - 1)"
                  class="w-10 h-10 flex items-center justify-center border rounded hover:bg-gray-100"
                >
                  -
                </button>
                <span class="text-xl font-medium w-12 text-center">{{
                  quantity
                }}</span>
                <button
                  @click="quantity++"
                  class="w-10 h-10 flex items-center justify-center border rounded hover:bg-gray-100"
                >
                  +
                </button>
              </div>
            </div>

            <!-- Add to Cart -->
            <button
              @click="addToCart"
              class="btn btn-primary w-full text-lg py-4"
            >
              Добавить в корзину
            </button>
          </div>
        </div>
      </div>
    </main>
  </div>
</template>
