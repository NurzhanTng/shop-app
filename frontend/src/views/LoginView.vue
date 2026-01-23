<script setup lang="ts">
import { ref } from "vue";
import { useAuthStore } from "@/stores/auth";
import { useRouter, useRoute } from "vue-router";
import LoadingSpinner from "@/components/common/LoadingSpinner.vue";
import ErrorMessage from "@/components/common/ErrorMessage.vue";

const authStore = useAuthStore();
const router = useRouter();
const route = useRoute();

const email = ref("");
const password = ref("");
const error = ref<string | null>(null);

const handleSubmit = async () => {
  error.value = null;

  try {
    await authStore.login({
      email: email.value,
      password: password.value,
    });

    // Перенаправляем на страницу, с которой пришел пользователь, или на главную
    const redirect = (route.query.redirect as string) || "/";
    router.push(redirect);
  } catch (err: any) {
    error.value = err.response?.data?.message || "Ошибка входа";
  }
};
</script>

<template>
  <div class="min-h-screen bg-gray-50 flex items-center justify-center px-4">
    <div class="max-w-md w-full">
      <!-- Logo -->
      <div class="text-center mb-8">
        <RouterLink to="/" class="text-4xl font-bold text-primary-600">
          ShopApp
        </RouterLink>
        <h2 class="mt-4 text-2xl font-bold text-gray-900">Вход в аккаунт</h2>
      </div>

      <!-- Form -->
      <div class="bg-white rounded-lg shadow-md p-8">
        <ErrorMessage
          v-if="error"
          :message="error"
          dismissible
          @dismiss="error = null"
          class="mb-6"
        />

        <form @submit.prevent="handleSubmit" class="space-y-6">
          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Email
            </label>
            <input
              v-model="email"
              type="email"
              required
              class="input"
              placeholder="your@email.com"
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Пароль
            </label>
            <input
              v-model="password"
              type="password"
              required
              class="input"
              placeholder="••••••••"
            />
          </div>

          <button
            type="submit"
            :disabled="authStore.loading"
            class="btn btn-primary w-full"
          >
            <LoadingSpinner v-if="authStore.loading" size="sm" />
            <span v-else>Войти</span>
          </button>
        </form>

        <div class="mt-6 text-center">
          <p class="text-gray-600">
            Нет аккаунта?
            <RouterLink
              to="/register"
              class="text-primary-600 hover:text-primary-700 font-medium"
            >
              Зарегистрироваться
            </RouterLink>
          </p>
        </div>

        <!-- Test Credentials -->
        <div class="mt-6 p-4 bg-gray-50 rounded-lg">
          <p class="text-xs text-gray-600 mb-2 font-semibold">
            Тестовые данные:
          </p>
          <p class="text-xs text-gray-600">
            Admin: admin@example.com / password
          </p>
          <p class="text-xs text-gray-600">User: john@example.com / password</p>
          <p class="text-xs text-gray-600">User: jane@example.com / password</p>
        </div>
      </div>

      <div class="mt-6 text-center">
        <RouterLink to="/" class="text-gray-600 hover:text-gray-900">
          ← Вернуться на главную
        </RouterLink>
      </div>
    </div>
  </div>
</template>
