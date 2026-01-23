<script setup lang="ts">
import { ref } from "vue";
import { useAuthStore } from "@/stores/auth";
import { useCartStore } from "@/stores/cart";
import { useRouter, RouterLink } from "vue-router";

const authStore = useAuthStore();
const cartStore = useCartStore();
const router = useRouter();

const showMobileMenu = ref(false);

const handleLogout = async () => {
  await authStore.logout();
  router.push("/login");
};
</script>

<template>
  <header class="bg-white shadow-md sticky top-0 z-50">
    <div class="container mx-auto px-4">
      <div class="flex items-center justify-between h-16">
        <!-- Logo -->
        <RouterLink to="/" class="text-2xl font-bold text-primary-600">
          ShopApp
        </RouterLink>

        <!-- Desktop Navigation -->
        <nav class="hidden md:flex items-center gap-6">
          <RouterLink to="/" class="text-gray-700 hover:text-primary-600">
            Каталог
          </RouterLink>

          <RouterLink
            v-if="authStore.isAuthenticated"
            to="/orders"
            class="text-gray-700 hover:text-primary-600"
          >
            Мои заказы
          </RouterLink>

          <RouterLink
            v-if="authStore.isAdmin"
            to="/admin/dashboard"
            class="text-gray-700 hover:text-primary-600"
          >
            Админка
          </RouterLink>
        </nav>

        <!-- Right Side -->
        <div class="flex items-center gap-4">
          <!-- Cart -->
          <RouterLink
            to="/cart"
            class="relative text-gray-700 hover:text-primary-600"
          >
            <svg
              class="w-6 h-6"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
              height="24"
              width="24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"
              />
            </svg>
            <span
              v-if="cartStore.itemCount > 0"
              class="absolute -top-2 -right-2 bg-red-500 text-white text-xs rounded-full w-5 h-5 flex items-center justify-center"
            >
              {{ cartStore.itemCount }}
            </span>
          </RouterLink>

          <!-- User Menu -->
          <div
            v-if="authStore.isAuthenticated"
            class="hidden md:flex items-center gap-4"
          >
            <span class="text-gray-700">{{ authStore.userName }}</span>
            <button @click="handleLogout" class="btn btn-secondary">
              Выйти
            </button>
          </div>

          <div v-else class="hidden md:flex items-center gap-2">
            <RouterLink to="/login" class="btn btn-secondary">
              Вход
            </RouterLink>
            <RouterLink to="/register" class="btn btn-primary">
              Регистрация
            </RouterLink>
          </div>

          <!-- Mobile Menu Button -->
          <button
            @click="showMobileMenu = !showMobileMenu"
            class="md:hidden text-gray-700"
          >
            <svg
              class="w-6 h-6"
              fill="none"
              stroke="currentColor"
              viewBox="0 0 24 24"
            >
              <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M4 6h16M4 12h16M4 18h16"
              />
            </svg>
          </button>
        </div>
      </div>

      <!-- Mobile Menu -->
      <div v-if="showMobileMenu" class="md:hidden py-4 border-t">
        <nav class="flex flex-col gap-3">
          <RouterLink
            to="/"
            class="text-gray-700 hover:text-primary-600"
            @click="showMobileMenu = false"
          >
            Каталог
          </RouterLink>

          <RouterLink
            v-if="authStore.isAuthenticated"
            to="/orders"
            class="text-gray-700 hover:text-primary-600"
            @click="showMobileMenu = false"
          >
            Мои заказы
          </RouterLink>

          <RouterLink
            v-if="authStore.isAdmin"
            to="/admin/dashboard"
            class="text-gray-700 hover:text-primary-600"
            @click="showMobileMenu = false"
          >
            Админка
          </RouterLink>

          <div v-if="authStore.isAuthenticated" class="border-t pt-3 mt-3">
            <p class="text-gray-700 mb-2">{{ authStore.userName }}</p>
            <button @click="handleLogout" class="btn btn-secondary w-full">
              Выйти
            </button>
          </div>

          <div v-else class="flex flex-col gap-2">
            <RouterLink
              to="/login"
              class="btn btn-secondary"
              @click="showMobileMenu = false"
            >
              Вход
            </RouterLink>
            <RouterLink
              to="/register"
              class="btn btn-primary"
              @click="showMobileMenu = false"
            >
              Регистрация
            </RouterLink>
          </div>
        </nav>
      </div>
    </div>
  </header>
</template>
