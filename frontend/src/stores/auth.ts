import { defineStore } from "pinia";
import authApi from "@/api/auth";
import type { User, LoginCredentials, RegisterData } from "@/types";

interface AuthState {
  user: User | null;
  token: string | null;
  loading: boolean;
  error: string | null;
}

export const useAuthStore = defineStore("auth", {
  state: (): AuthState => ({
    user: JSON.parse(localStorage.getItem("user") || "null"),
    token: localStorage.getItem("token"),
    loading: false,
    error: null,
  }),

  getters: {
    isAuthenticated: (state): boolean => !!state.token,
    isAdmin: (state): boolean => state.user?.role === "admin",
    userName: (state): string => state.user?.name || "Guest",
  },

  actions: {
    async register(data: RegisterData) {
      this.loading = true;
      this.error = null;

      try {
        const response = await authApi.register(data);
        this.user = response.data.user;
        this.token = response.data.token;

        localStorage.setItem("user", JSON.stringify(response.data.user));
        localStorage.setItem("token", response.data.token);

        return response.data;
      } catch (error: any) {
        this.error = error.response?.data?.message || "Registration failed";
        throw error;
      } finally {
        this.loading = false;
      }
    },

    async login(credentials: LoginCredentials) {
      this.loading = true;
      this.error = null;

      try {
        const response = await authApi.login(credentials);
        this.user = response.data.user;
        this.token = response.data.token;

        localStorage.setItem("user", JSON.stringify(response.data.user));
        localStorage.setItem("token", response.data.token);

        return response.data;
      } catch (error: any) {
        this.error = error.response?.data?.message || "Login failed";
        throw error;
      } finally {
        this.loading = false;
      }
    },

    async logout() {
      try {
        await authApi.logout();
      } catch (error) {
        console.error("Logout error:", error);
      } finally {
        this.user = null;
        this.token = null;
        localStorage.removeItem("user");
        localStorage.removeItem("token");
      }
    },

    async fetchUser() {
      if (!this.token) return;

      try {
        const response = await authApi.me();
        this.user = response.data;
        localStorage.setItem("user", JSON.stringify(response.data));
      } catch (error) {
        console.error("Fetch user error:", error);
        this.logout();
      }
    },
  },
});
