<script setup lang="ts">
import { ref, watch } from "vue";
import type { Category } from "@/types";

interface Props {
  categories: Category[];
  modelValue: {
    category_id: number | null;
    search: string;
  };
}

const props = defineProps<Props>();
const emit = defineEmits<{
  "update:modelValue": [value: { category_id: number | null; search: string }];
  clear: [];
}>();

const localFilters = ref({ ...props.modelValue });

watch(
  localFilters,
  (newValue) => {
    emit("update:modelValue", newValue);
  },
  { deep: true }
);

const clearFilters = () => {
  localFilters.value = {
    category_id: null,
    search: "",
  };
  emit("clear");
};
</script>

<template>
  <div class="bg-white rounded-lg shadow-md p-6 mb-6">
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <!-- Поиск -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
          Поиск
        </label>
        <input
          v-model="localFilters.search"
          type="text"
          placeholder="Название товара..."
          class="input"
        />
      </div>

      <!-- Категория -->
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
          Категория
        </label>
        <select v-model="localFilters.category_id" class="input">
          <option :value="null">Все категории</option>
          <option
            v-for="category in categories"
            :key="category.id"
            :value="category.id"
          >
            {{ category.name }}
          </option>
        </select>
      </div>

      <!-- Кнопка очистки -->
      <div class="flex items-end">
        <button @click="clearFilters" class="btn btn-secondary w-full">
          Сбросить фильтры
        </button>
      </div>
    </div>
  </div>
</template>
