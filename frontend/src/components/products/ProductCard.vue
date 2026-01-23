<script setup lang="ts">
import { useCartStore } from "@/stores/cart";
import { useRouter } from "vue-router";
import type { Product } from "@/types";

interface Props {
  product: Product;
}

const props = defineProps<Props>();
const cartStore = useCartStore();
const router = useRouter();

const addToCart = () => {
  cartStore.addItem(props.product);
};

const viewDetails = () => {
  router.push(`/products/${props.product.id}`);
};
</script>

<template>
  <div class="card hover:shadow-xl transition-shadow cursor-pointer group">
    <div @click="viewDetails" class="mb-4">
      <div class="aspect-square bg-gray-100 rounded-lg overflow-hidden mb-4">
        <img
          v-if="product.image_url"
          :src="product.image_url"
          :alt="product.name"
          class="w-full h-full object-cover group-hover:scale-105 transition-transform"
        />
        <div
          v-else
          class="w-full h-full flex items-center justify-center text-gray-400"
        >
          <svg
            class="w-16 h-16"
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

      <div class="space-y-2">
        <p class="text-sm text-gray-500">{{ product.category?.name }}</p>
        <h3
          class="text-lg font-semibold text-gray-900 group-hover:text-primary-600 transition-colors"
        >
          {{ product.name }}
        </h3>
        <p class="text-gray-600 text-sm line-clamp-2">
          {{ product.description }}
        </p>
      </div>
    </div>

    <div class="flex items-center justify-between pt-4 border-t">
      <span class="text-2xl font-bold text-primary-600">
        ${{ Number(product.price).toFixed(2) }}
      </span>
      <button @click.stop="addToCart" class="btn btn-primary">В корзину</button>
    </div>
  </div>
</template>
