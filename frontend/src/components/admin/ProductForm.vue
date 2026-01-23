<script setup lang="ts">
import { ref, watch } from "vue";
import type { Product, Category, ProductFormData } from "@/types";

interface Props {
  product?: Product | null;
  categories: Category[];
}

const props = defineProps<Props>();
const emit = defineEmits<{
  submit: [data: ProductFormData];
  cancel: [];
}>();

const formData = ref<ProductFormData>({
  name: "",
  description: "",
  price: 0,
  category_id: 0,
  image_url: "",
});

watch(
  () => props.product,
  (product) => {
    if (product) {
      formData.value = {
        name: product.name,
        description: product.description,
        price: product.price,
        category_id: product.category_id,
        image_url: product.image_url || "",
      };
    } else {
      formData.value = {
        name: "",
        description: "",
        price: 0,
        category_id: props.categories[0]?.id || 0,
        image_url: "",
      };
    }
  },
  { immediate: true }
);

const handleSubmit = () => {
  emit("submit", formData.value);
};
</script>

<template>
  <form @submit.prevent="handleSubmit" class="space-y-4">
    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2">
        Название
      </label>
      <input v-model="formData.name" type="text" required class="input" />
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2">
        Описание
      </label>
      <textarea
        v-model="formData.description"
        rows="4"
        required
        class="input"
      ></textarea>
    </div>

    <div class="grid grid-cols-2 gap-4">
      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
          Цена ($)
        </label>
        <input
          v-model.number="formData.price"
          type="number"
          step="0.01"
          min="0"
          required
          class="input"
        />
      </div>

      <div>
        <label class="block text-sm font-medium text-gray-700 mb-2">
          Категория
        </label>
        <select v-model.number="formData.category_id" required class="input">
          <option
            v-for="category in categories"
            :key="category.id"
            :value="category.id"
          >
            {{ category.name }}
          </option>
        </select>
      </div>
    </div>

    <div>
      <label class="block text-sm font-medium text-gray-700 mb-2">
        URL изображения (опционально)
      </label>
      <input
        v-model="formData.image_url"
        type="url"
        class="input"
        placeholder="https://example.com/image.jpg"
      />
    </div>

    <div class="flex gap-3 pt-4">
      <button type="submit" class="btn btn-primary flex-1">
        {{ product ? "Обновить" : "Создать" }}
      </button>
      <button
        type="button"
        @click="emit('cancel')"
        class="btn btn-secondary flex-1"
      >
        Отмена
      </button>
    </div>
  </form>
</template>
