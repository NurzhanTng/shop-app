<script setup lang="ts">
import { useRouter } from "vue-router";

const router = useRouter();

const goHome = () => {
  router.push("/");
};
</script>

<template>
  <div class="min-h-screen bg-gray-50 flex items-center justify-center px-4">
    <div class="text-center">
      <h1 class="text-9xl font-bold text-primary-600">404</h1>
      <h2 class="text-3xl font-semibold text-gray-900 mt-4 mb-2">
        Страница не найдена
      </h2>
      <p class="text-gray-600 mb-8">
        К сожалению, запрашиваемая страница не существует
      </p>
      <button @click="goHome" class="btn btn-primary">
        Вернуться на главную
      </button>
    </div>
  </div>
</template>
