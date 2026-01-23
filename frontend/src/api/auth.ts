import api from "./axios";
import type {
  AuthResponse,
  LoginCredentials,
  RegisterData,
  User,
} from "@/types";
import type { AxiosResponse } from "axios";

export default {
  register(data: RegisterData): Promise<AxiosResponse<AuthResponse>> {
    return api.post("/register", data);
  },

  login(credentials: LoginCredentials): Promise<AxiosResponse<AuthResponse>> {
    return api.post("/login", credentials);
  },

  logout(): Promise<AxiosResponse<{ message: string }>> {
    return api.post("/logout");
  },

  me(): Promise<AxiosResponse<User>> {
    return api.get("/me");
  },
};
