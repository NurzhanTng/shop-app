import {
  createRouter,
  createWebHistory,
  RouteRecordRaw,
  RouteLocationNormalized,
} from "vue-router";
import { useAuthStore } from "@/stores/auth";

const routes: RouteRecordRaw[] = [
  // Публичные маршруты
  {
    path: "/",
    name: "home",
    component: () => import("@/views/Home.vue"),
  },
  {
    path: "/products/:id",
    name: "product",
    component: () => import("@/views/ProductView.vue"),
  },
  {
    path: "/login",
    name: "login",
    component: () => import("@/views/LoginView.vue"),
    meta: { guest: true },
  },
  {
    path: "/register",
    name: "register",
    component: () => import("@/views/RegisterView.vue"),
    meta: { guest: true },
  },

  // Защищенные маршруты
  {
    path: "/cart",
    name: "cart",
    component: () => import("@/views/CartView.vue"),
    meta: { requiresAuth: true },
  },
  {
    path: "/checkout",
    name: "checkout",
    component: () => import("@/views/CheckoutView.vue"),
    meta: { requiresAuth: true },
  },
  {
    path: "/orders",
    name: "orders",
    component: () => import("@/views/OrdersView.vue"),
    meta: { requiresAuth: true },
  },

  // Админ маршруты
  {
    path: "/admin",
    redirect: "/admin/dashboard",
    meta: { requiresAdmin: true },
  },
  {
    path: "/admin/dashboard",
    name: "admin-dashboard",
    component: () => import("@/views/admin/DashboardView.vue"),
    meta: { requiresAdmin: true },
  },
  {
    path: "/admin/products",
    name: "admin-products",
    component: () => import("@/views/admin/ProductsView.vue"),
    meta: { requiresAdmin: true },
  },
  {
    path: "/admin/orders",
    name: "admin-orders",
    component: () => import("@/views/admin/OrdersView.vue"),
    meta: { requiresAdmin: true },
  },

  // 404
  {
    path: "/:pathMatch(.*)*",
    name: "not-found",
    component: () => import("@/views/NotFound.vue"),
  },
];

const router = createRouter({
  history: createWebHistory(),
  routes,
  scrollBehavior(to, from, savedPosition) {
    if (savedPosition) {
      return savedPosition;
    } else {
      return { top: 0 };
    }
  },
});

// Navigation Guards
router.beforeEach(
  (to: RouteLocationNormalized, from: RouteLocationNormalized, next) => {
    const authStore = useAuthStore();

    // Проверка для админских маршрутов
    if (to.meta.requiresAdmin) {
      if (!authStore.isAuthenticated) {
        next({ name: "login", query: { redirect: to.fullPath } });
      } else if (!authStore.isAdmin) {
        next({ name: "home" });
      } else {
        next();
      }
    }
    // Проверка для защищенных маршрутов
    else if (to.meta.requiresAuth) {
      if (!authStore.isAuthenticated) {
        next({ name: "login", query: { redirect: to.fullPath } });
      } else {
        next();
      }
    }
    // Проверка для гостевых маршрутов (login, register)
    else if (to.meta.guest && authStore.isAuthenticated) {
      next({ name: "home" });
    } else {
      next();
    }
  }
);

export default router;
