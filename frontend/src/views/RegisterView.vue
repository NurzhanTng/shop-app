<script setup lang="ts">
import { ref } from "vue";
import { useAuthStore } from "@/stores/auth";
import { useRouter } from "vue-router";
import LoadingSpinner from "@/components/common/LoadingSpinner.vue";
import ErrorMessage from "@/components/common/ErrorMessage.vue";

const authStore = useAuthStore();
const router = useRouter();

const name = ref("");
const email = ref("");
const password = ref("");
const password_confirmation = ref("");
const error = ref<string | null>(null);

const handleSubmit = async () => {
  error.value = null;

  if (password.value !== password_confirmation.value) {
    error.value = "Пароли не совпадают";
    return;
  }

  try {
    await authStore.register({
      name: name.value,
      email: email.value,
      password: password.value,
      password_confirmation: password_confirmation.value,
    });

    router.push("/");
  } catch (err: any) {
    error.value = err.response?.data?.message || "Ошибка регистрации";
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
        <h2 class="mt-4 text-2xl font-bold text-gray-900">Создать аккаунт</h2>
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
              Имя
            </label>
            <input
              v-model="name"
              type="text"
              required
              class="input"
              placeholder="Ваше имя"
            />
          </div>

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
              minlength="8"
              class="input"
              placeholder="••••••••"
            />
          </div>

          <div>
            <label class="block text-sm font-medium text-gray-700 mb-2">
              Подтвердите пароль
            </label>
            <input
              v-model="password_confirmation"
              type="password"
              required
              minlength="8"
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
            <span v-else>Зарегистрироваться</span>
          </button>
        </form>

        <div class="mt-6 text-center">
          <p class="text-gray-600">
            Уже есть аккаунт?
            <RouterLink
              to="/login"
              class="text-primary-600 hover:text-primary-700 font-medium"
            >
              Войти
            </RouterLink>
          </p>
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
