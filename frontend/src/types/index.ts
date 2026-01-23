// User types
export interface User {
  id: number;
  name: string;
  email: string;
  role: "admin" | "user";
  created_at?: string;
  updated_at?: string;
}

export interface AuthResponse {
  user: User;
  token: string;
}

export interface LoginCredentials {
  email: string;
  password: string;
}

export interface RegisterData {
  name: string;
  email: string;
  password: string;
  password_confirmation: string;
}

// Category types
export interface Category {
  id: number;
  name: string;
  created_at?: string;
  updated_at?: string;
}

// Product types
export interface Product {
  id: number;
  name: string;
  description: string;
  price: number;
  formatted_price?: string;
  category_id: number;
  category?: Category;
  image_url?: string;
  stock?: number;
  created_at?: string;
  updated_at?: string;
}

export interface ProductFilters {
  category_id?: number | null;
  search?: string;
  page?: number;
}

export interface ProductFormData {
  name: string;
  description: string;
  price: number;
  category_id: number;
  image_url?: string;
}

// Order types
export type OrderStatus = "pending" | "processing" | "completed";

export interface OrderItem {
  id: number;
  order_id: number;
  product_id: number;
  quantity: number;
  price: number;
  product?: Product;
  created_at?: string;
  updated_at?: string;
}

export interface Order {
  id: number;
  user_id: number;
  total: number;
  formatted_total?: string;
  status: OrderStatus;
  status_label?: string;
  user?: User;
  items?: OrderItem[];
  created_at?: string;
  updated_at?: string;
}

export interface CreateOrderItem {
  product_id: number;
  quantity: number;
  price: number;
}

export interface CreateOrderData {
  items: CreateOrderItem[];
}

// Cart types
export interface CartItem {
  product_id: number;
  name: string;
  price: number;
  quantity: number;
  image_url?: string;
}

// Pagination types
export interface PaginationMeta {
  current_page: number;
  last_page: number;
  per_page: number;
  total: number;
  from?: number;
  to?: number;
}

export interface PaginatedResponse<T> {
  data: T[];
  current_page: number;
  last_page: number;
  per_page: number;
  total: number;
  from?: number;
  to?: number;
}

// Admin stats types
export interface AdminStats {
  total_users: number;
  total_products: number;
  total_orders: number;
  pending_orders: number;
  total_revenue: number;
  recent_orders: Order[];
}

// API Response types
export interface ApiError {
  message: string;
  errors?: Record<string, string[]>;
}
