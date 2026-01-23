import api from "./axios";
import type { AdminStats } from "@/types";
import type { AxiosResponse } from "axios";

export default {
  getStats(): Promise<AxiosResponse<AdminStats>> {
    return api.get("/admin/stats");
  },
};
