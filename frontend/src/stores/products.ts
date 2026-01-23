import { defineStore } from "pinia";
import productsApi from "@/api/products";
import categoriesApi from "@/api/categories";
import type {
  Product,
  Category,
  ProductFilters,
  ProductFormData,
  PaginationMeta,
} from "@/types";

interface ProductsState {
  products: Product[];
  categories: Category[];
  currentProduct: Product | null;
  pagination: PaginationMeta | null;
  filters: ProductFilters;
  loading: boolean;
  error: string | null;
}

export const useProductsStore = defineStore("products", {
  state: (): ProductsState => ({
    products: [],
    categories: [],
    currentProduct: null,
    pagination: null,
    filters: {
      category_id: null,
      search: "",
      page: 1,
    },
    loading: false,
    error: null,
  }),

  getters: {
    filteredProducts: (state): Product[] => state.products,
  },

  actions: {
    async fetchProducts(page: number = 1) {
      this.loading = true;
      this.error = null;

      try {
        const params: ProductFilters = {
          page,
          ...this.filters,
        };

        const response = await productsApi.getAll(params);
        this.products = response.data.data;
        this.pagination = {
          current_page: response.data.current_page,
          last_page: response.data.last_page,
          per_page: response.data.per_page,
          total: response.data.total,
        };
      } catch (error: any) {
        this.error =
          error.response?.data?.message || "Failed to fetch products";
        throw error;
      } finally {
        this.loading = false;
      }
    },

    async fetchProductById(id: number): Promise<Product> {
      this.loading = true;
      this.error = null;

      try {
        const response = await productsApi.getById(id);
        this.currentProduct = response.data;
        return response.data;
      } catch (error: any) {
        this.error = error.response?.data?.message || "Failed to fetch product";
        throw error;
      } finally {
        this.loading = false;
      }
    },

    async fetchCategories() {
      try {
        const response = await categoriesApi.getAll();
        this.categories = response.data;
      } catch (error) {
        console.error("Failed to fetch categories:", error);
      }
    },

    async createProduct(data: ProductFormData): Promise<Product> {
      this.loading = true;
      this.error = null;

      try {
        const response = await productsApi.create(data);
        await this.fetchProducts();
        return response.data;
      } catch (error: any) {
        this.error =
          error.response?.data?.message || "Failed to create product";
        throw error;
      } finally {
        this.loading = false;
      }
    },

    async updateProduct(
      id: number,
      data: Partial<ProductFormData>
    ): Promise<Product> {
      this.loading = true;
      this.error = null;

      try {
        const response = await productsApi.update(id, data);
        await this.fetchProducts();
        return response.data;
      } catch (error: any) {
        this.error =
          error.response?.data?.message || "Failed to update product";
        throw error;
      } finally {
        this.loading = false;
      }
    },

    async deleteProduct(id: number) {
      this.loading = true;
      this.error = null;

      try {
        await productsApi.delete(id);
        await this.fetchProducts();
      } catch (error: any) {
        this.error =
          error.response?.data?.message || "Failed to delete product";
        throw error;
      } finally {
        this.loading = false;
      }
    },

    setFilter(key: keyof ProductFilters, value: any): void {
      this.filters[key] = value;
      this.fetchProducts();
    },

    clearFilters(): void {
      this.filters = {
        category_id: null,
        search: "",
        page: 1,
      };
      this.fetchProducts();
    },
  },
});
