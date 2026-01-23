import api from "./axios";
import type {
  Product,
  ProductFilters,
  ProductFormData,
  PaginatedResponse,
} from "@/types";
import type { AxiosResponse } from "axios";

export default {
  getAll(
    filters: ProductFilters = {}
  ): Promise<AxiosResponse<PaginatedResponse<Product>>> {
    return api.get("/products", { params: filters });
  },

  getById(id: number): Promise<AxiosResponse<Product>> {
    return api.get(`/products/${id}`);
  },

  create(data: ProductFormData): Promise<AxiosResponse<Product>> {
    return api.post("/products", data);
  },

  update(
    id: number,
    data: Partial<ProductFormData>
  ): Promise<AxiosResponse<Product>> {
    return api.put(`/products/${id}`, data);
  },

  delete(id: number): Promise<AxiosResponse<{ message: string }>> {
    return api.delete(`/products/${id}`);
  },
};
