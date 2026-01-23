<script setup lang="ts">
import { onMounted } from "vue";
import { useAuthStore } from "@/stores/auth";
import { useProductsStore } from "@/stores/products";

const authStore = useAuthStore();
const productsStore = useProductsStore();

onMounted(() => {
  // Загружаем данные пользователя при запуске приложения
  if (authStore.isAuthenticated) {
    authStore.fetchUser();
  }

  // Загружаем категории
  productsStore.fetchCategories();
});
</script>

<template>
  <div id="app">
    <RouterView />
  </div>
</template>

<style>
#app {
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}
</style>
