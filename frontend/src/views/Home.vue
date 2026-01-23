<script setup lang="ts">
import { onMounted, ref, watch } from "vue";
import { useProductsStore } from "@/stores/products";
import AppHeader from "@/components/common/AppHeader.vue";
import ProductList from "@/components/products/ProductList.vue";
import ProductFilters from "@/components/products/ProductFilters.vue";
import ErrorMessage from "@/components/common/ErrorMessage.vue";

const productsStore = useProductsStore();

const filters = ref({
  category_id: null as number | null,
  search: "",
});

onMounted(() => {
  productsStore.fetchProducts();
});

watch(
  filters,
  () => {
    productsStore.filters.category_id = filters.value.category_id;
    productsStore.filters.search = filters.value.search;
    productsStore.fetchProducts();
  },
  { deep: true }
);

const handlePageChange = (page: number) => {
  productsStore.fetchProducts(page);
  window.scrollTo({ top: 0, behavior: "smooth" });
};
</script>

<template>
  <div class="min-h-screen flex flex-col">
    <AppHeader />

    <main class="flex-1 bg-gray-50">
      <div class="container mx-auto px-4 py-8">
        <!-- Header -->
        <div class="mb-8">
          <h1 class="text-4xl font-bold text-gray-900 mb-2">Каталог товаров</h1>
          <p class="text-gray-600">Найдите то, что вам нужно</p>
        </div>

        <!-- Filters -->
        <ProductFilters
          v-model="filters"
          :categories="productsStore.categories"
          @clear="productsStore.clearFilters()"
        />

        <!-- Error -->
        <ErrorMessage
          v-if="productsStore.error"
          :message="productsStore.error"
          class="mb-6"
        />

        <!-- Products -->
        <ProductList
          :products="productsStore.products"
          :loading="productsStore.loading"
        />

        <!-- Pagination -->
        <div
          v-if="
            productsStore.pagination && productsStore.pagination.last_page > 1
          "
          class="flex justify-center gap-2 mt-8"
        >
          <button
            v-for="page in productsStore.pagination.last_page"
            :key="page"
            @click="handlePageChange(page)"
            :class="[
              'px-4 py-2 rounded-lg font-medium',
              page === productsStore.pagination.current_page
                ? 'bg-primary-600 text-white'
                : 'bg-white text-gray-700 hover:bg-gray-100',
            ]"
          >
            {{ page }}
          </button>
        </div>
      </div>
    </main>
  </div>
</template>
