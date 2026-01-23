<script setup lang="ts">
import { onMounted, ref } from "vue";
import { useProductsStore } from "@/stores/products";
import AppHeader from "@/components/common/AppHeader.vue";
import ProductForm from "@/components/admin/ProductForm.vue";
import Modal from "@/components/common/Modal.vue";
import LoadingSpinner from "@/components/common/LoadingSpinner.vue";
import ErrorMessage from "@/components/common/ErrorMessage.vue";
import type { Product, ProductFormData } from "@/types";

const productsStore = useProductsStore();

const showModal = ref(false);
const editingProduct = ref<Product | null>(null);
const error = ref<string | null>(null);

onMounted(() => {
  productsStore.fetchProducts();
});

const openCreateModal = () => {
  editingProduct.value = null;
  showModal.value = true;
};

const openEditModal = (product: Product) => {
  editingProduct.value = product;
  showModal.value = true;
};

const closeModal = () => {
  showModal.value = false;
  editingProduct.value = null;
  error.value = null;
};

const handleSubmit = async (data: ProductFormData) => {
  error.value = null;

  try {
    if (editingProduct.value) {
      await productsStore.updateProduct(editingProduct.value.id, data);
    } else {
      await productsStore.createProduct(data);
    }
    closeModal();
  } catch (err: any) {
    error.value = err.response?.data?.message || "Ошибка сохранения";
  }
};

const handleDelete = async (product: Product) => {
  if (!confirm(`Удалить товар "${product.name}"?`)) return;

  try {
    await productsStore.deleteProduct(product.id);
  } catch (err: any) {
    alert(err.response?.data?.message || "Ошибка удаления");
  }
};
</script>

<template>
  <div class="min-h-screen flex flex-col">
    <AppHeader />

    <main class="flex-1 bg-gray-50">
      <div class="container mx-auto px-4 py-8">
        <div class="flex items-center justify-between mb-8">
          <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">
              Управление товарами
            </h1>
            <RouterLink
              to="/admin/dashboard"
              class="text-primary-600 hover:text-primary-700"
            >
              ← Назад к дашборду
            </RouterLink>
          </div>
          <button @click="openCreateModal" class="btn btn-primary">
            + Добавить товар
          </button>
        </div>

        <!-- Loading -->
        <div v-if="productsStore.loading" class="flex justify-center py-12">
          <LoadingSpinner size="lg" />
        </div>

        <!-- Error -->
        <ErrorMessage
          v-else-if="productsStore.error"
          :message="productsStore.error"
        />

        <!-- Products Table -->
        <div v-else class="bg-white rounded-lg shadow-md overflow-hidden">
          <table class="w-full">
            <thead class="bg-gray-50 border-b">
              <tr>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                >
                  ID
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                >
                  Название
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                >
                  Категория
                </th>
                <th
                  class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase"
                >
                  Цена
                </th>
                <th
                  class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase"
                >
                  Действия
                </th>
              </tr>
            </thead>
            <tbody class="divide-y">
              <tr
                v-for="product in productsStore.products"
                :key="product.id"
                class="hover:bg-gray-50"
              >
                <td class="px-6 py-4 text-sm text-gray-900">
                  {{ product.id }}
                </td>
                <td class="px-6 py-4">
                  <div class="font-medium text-gray-900">
                    {{ product.name }}
                  </div>
                  <div class="text-sm text-gray-500">
                    {{ product.description.substring(0, 50) }}...
                  </div>
                </td>
                <td class="px-6 py-4 text-sm text-gray-600">
                  {{ product.category?.name }}
                </td>
                <td class="px-6 py-4 text-sm font-medium text-gray-900">
                  ${{ Number(product.price).toFixed(2) }}
                </td>
                <td class="px-6 py-4 text-right space-x-2">
                  <button
                    @click="openEditModal(product)"
                    class="text-primary-600 hover:text-primary-900"
                  >
                    Изменить
                  </button>
                  <button
                    @click="handleDelete(product)"
                    class="text-red-600 hover:text-red-900"
                  >
                    Удалить
                  </button>
                </td>
              </tr>
            </tbody>
          </table>
        </div>

        <!-- Modal -->
        <Modal
          :show="showModal"
          :title="editingProduct ? 'Редактировать товар' : 'Создать товар'"
          @close="closeModal"
        >
          <ErrorMessage
            v-if="error"
            :message="error"
            dismissible
            @dismiss="error = null"
            class="mb-4"
          />

          <ProductForm
            :product="editingProduct"
            :categories="productsStore.categories"
            @submit="handleSubmit"
            @cancel="closeModal"
          />
        </Modal>
      </div>
    </main>
  </div>
</template>
