import api from "./axios";
import type { Category } from "@/types";
import type { AxiosResponse } from "axios";

export default {
  getAll(): Promise<AxiosResponse<Category[]>> {
    return api.get("/categories");
  },

  create(data: { name: string }): Promise<AxiosResponse<Category>> {
    return api.post("/categories", data);
  },

  update(id: number, data: { name: string }): Promise<AxiosResponse<Category>> {
    return api.put(`/categories/${id}`, data);
  },

  delete(id: number): Promise<AxiosResponse<{ message: string }>> {
    return api.delete(`/categories/${id}`);
  },
};
