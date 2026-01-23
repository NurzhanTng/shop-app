import api from "./axios";
import type {
  Order,
  CreateOrderData,
  OrderStatus,
  PaginatedResponse,
} from "@/types";
import type { AxiosResponse } from "axios";

export default {
  getAll(): Promise<AxiosResponse<PaginatedResponse<Order>>> {
    return api.get("/orders");
  },

  getById(id: number): Promise<AxiosResponse<Order>> {
    return api.get(`/orders/${id}`);
  },

  create(data: CreateOrderData): Promise<AxiosResponse<Order>> {
    return api.post("/orders", data);
  },

  updateStatus(id: number, status: OrderStatus): Promise<AxiosResponse<Order>> {
    return api.patch(`/orders/${id}/status`, { status });
  },
};
