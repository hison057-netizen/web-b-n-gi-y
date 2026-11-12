-- MySQL 8.x / InnoDB / utf8mb4
CREATE DATABASE IF NOT EXISTS shoe_store
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE shoe_store;

CREATE TABLE roles (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(50) NOT NULL UNIQUE,
  description VARCHAR(255) NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE users (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  full_name VARCHAR(150) NOT NULL,
  email VARCHAR(190) NOT NULL UNIQUE,
  phone VARCHAR(30) NULL,
  password_hash VARCHAR(255) NOT NULL,
  status ENUM('active','blocked') NOT NULL DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

CREATE TABLE user_roles (
  user_id BIGINT UNSIGNED NOT NULL,
  role_id BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (user_id, role_id),
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (role_id) REFERENCES roles(id)
) ENGINE=InnoDB;

CREATE TABLE user_addresses (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL,
  recipient_name VARCHAR(150) NOT NULL,
  phone VARCHAR(30) NOT NULL,
  province VARCHAR(100) NOT NULL,
  district VARCHAR(100) NOT NULL,
  ward VARCHAR(100) NOT NULL,
  address_line VARCHAR(255) NOT NULL,
  is_default BOOLEAN NOT NULL DEFAULT FALSE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id),
  INDEX idx_address_user (user_id)
) ENGINE=InnoDB;

CREATE TABLE brands (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  name VARCHAR(120) NOT NULL UNIQUE,
  slug VARCHAR(150) NOT NULL UNIQUE,
  status ENUM('active','inactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB;

CREATE TABLE categories (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  parent_id BIGINT UNSIGNED NULL,
  name VARCHAR(120) NOT NULL,
  slug VARCHAR(150) NOT NULL UNIQUE,
  status ENUM('active','inactive') NOT NULL DEFAULT 'active',
  FOREIGN KEY (parent_id) REFERENCES categories(id)
) ENGINE=InnoDB;

CREATE TABLE products (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  brand_id BIGINT UNSIGNED NULL,
  name VARCHAR(200) NOT NULL,
  slug VARCHAR(220) NOT NULL UNIQUE,
  description TEXT NULL,
  status ENUM('active','inactive') NOT NULL DEFAULT 'active',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (brand_id) REFERENCES brands(id),
  INDEX idx_products_status (status)
) ENGINE=InnoDB;

CREATE TABLE product_categories (
  product_id BIGINT UNSIGNED NOT NULL,
  category_id BIGINT UNSIGNED NOT NULL,
  PRIMARY KEY (product_id, category_id),
  FOREIGN KEY (product_id) REFERENCES products(id),
  FOREIGN KEY (category_id) REFERENCES categories(id)
) ENGINE=InnoDB;

CREATE TABLE product_variants (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  product_id BIGINT UNSIGNED NOT NULL,
  sku VARCHAR(80) NOT NULL UNIQUE,
  size VARCHAR(20) NOT NULL,
  color VARCHAR(50) NOT NULL,
  price DECIMAL(12,2) NOT NULL,
  sale_price DECIMAL(12,2) NULL,
  stock_quantity INT UNSIGNED NOT NULL DEFAULT 0,
  status ENUM('active','inactive') NOT NULL DEFAULT 'active',
  FOREIGN KEY (product_id) REFERENCES products(id),
  INDEX idx_variant_product (product_id),
  CHECK (price >= 0),
  CHECK (sale_price IS NULL OR sale_price >= 0)
) ENGINE=InnoDB;

CREATE TABLE product_images (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  product_id BIGINT UNSIGNED NOT NULL,
  image_url VARCHAR(500) NOT NULL,
  alt_text VARCHAR(255) NULL,
  sort_order INT NOT NULL DEFAULT 0,
  is_primary BOOLEAN NOT NULL DEFAULT FALSE,
  FOREIGN KEY (product_id) REFERENCES products(id)
) ENGINE=InnoDB;

CREATE TABLE carts (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NULL,
  session_token VARCHAR(128) NULL UNIQUE,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id)
) ENGINE=InnoDB;

CREATE TABLE cart_items (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  cart_id BIGINT UNSIGNED NOT NULL,
  variant_id BIGINT UNSIGNED NOT NULL,
  quantity INT UNSIGNED NOT NULL,
  UNIQUE KEY uq_cart_variant (cart_id, variant_id),
  FOREIGN KEY (cart_id) REFERENCES carts(id) ON DELETE CASCADE,
  FOREIGN KEY (variant_id) REFERENCES product_variants(id),
  CHECK (quantity > 0)
) ENGINE=InnoDB;

CREATE TABLE vouchers (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  code VARCHAR(50) NOT NULL UNIQUE,
  discount_type ENUM('fixed','percent') NOT NULL,
  discount_value DECIMAL(12,2) NOT NULL,
  min_order_value DECIMAL(12,2) NOT NULL DEFAULT 0,
  max_discount DECIMAL(12,2) NULL,
  usage_limit INT UNSIGNED NULL,
  used_count INT UNSIGNED NOT NULL DEFAULT 0,
  starts_at DATETIME NULL,
  ends_at DATETIME NULL,
  status ENUM('active','inactive') NOT NULL DEFAULT 'active'
) ENGINE=InnoDB;

CREATE TABLE orders (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  order_code VARCHAR(40) NOT NULL UNIQUE,
  user_id BIGINT UNSIGNED NULL,
  voucher_id BIGINT UNSIGNED NULL,
  recipient_name VARCHAR(150) NOT NULL,
  recipient_phone VARCHAR(30) NOT NULL,
  shipping_address TEXT NOT NULL,
  subtotal DECIMAL(12,2) NOT NULL,
  discount_amount DECIMAL(12,2) NOT NULL DEFAULT 0,
  shipping_fee DECIMAL(12,2) NOT NULL DEFAULT 0,
  total_amount DECIMAL(12,2) NOT NULL,
  payment_method VARCHAR(40) NOT NULL,
  payment_status ENUM('unpaid','pending','paid','failed','refunded','partially_refunded') NOT NULL DEFAULT 'unpaid',
  order_status ENUM('pending','confirmed','processing','shipping','completed','cancelled','returned') NOT NULL DEFAULT 'pending',
  note TEXT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  FOREIGN KEY (voucher_id) REFERENCES vouchers(id),
  INDEX idx_orders_user (user_id),
  INDEX idx_orders_status (order_status),
  INDEX idx_orders_created (created_at)
) ENGINE=InnoDB;

CREATE TABLE order_items (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  order_id BIGINT UNSIGNED NOT NULL,
  variant_id BIGINT UNSIGNED NULL,
  product_name VARCHAR(200) NOT NULL,
  sku VARCHAR(80) NOT NULL,
  size VARCHAR(20) NOT NULL,
  color VARCHAR(50) NOT NULL,
  unit_price DECIMAL(12,2) NOT NULL,
  quantity INT UNSIGNED NOT NULL,
  line_total DECIMAL(12,2) NOT NULL,
  FOREIGN KEY (order_id) REFERENCES orders(id),
  FOREIGN KEY (variant_id) REFERENCES product_variants(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE order_status_histories (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  order_id BIGINT UNSIGNED NOT NULL,
  changed_by BIGINT UNSIGNED NULL,
  old_status VARCHAR(30) NULL,
  new_status VARCHAR(30) NOT NULL,
  note VARCHAR(500) NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (order_id) REFERENCES orders(id),
  FOREIGN KEY (changed_by) REFERENCES users(id) ON DELETE SET NULL
) ENGINE=InnoDB;

CREATE TABLE payments (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  order_id BIGINT UNSIGNED NOT NULL,
  provider VARCHAR(60) NOT NULL,
  transaction_code VARCHAR(150) NULL,
  amount DECIMAL(12,2) NOT NULL,
  status ENUM('pending','paid','failed','refunded','partially_refunded') NOT NULL DEFAULT 'pending',
  paid_at DATETIME NULL,
  raw_response JSON NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (order_id) REFERENCES orders(id),
  INDEX idx_payment_order (order_id),
  INDEX idx_payment_transaction (transaction_code)
) ENGINE=InnoDB;

CREATE TABLE voucher_redemptions (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  voucher_id BIGINT UNSIGNED NOT NULL,
  order_id BIGINT UNSIGNED NOT NULL,
  user_id BIGINT UNSIGNED NULL,
  discount_amount DECIMAL(12,2) NOT NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (voucher_id) REFERENCES vouchers(id),
  FOREIGN KEY (order_id) REFERENCES orders(id),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  UNIQUE KEY uq_voucher_order (voucher_id, order_id)
) ENGINE=InnoDB;

CREATE TABLE reviews (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  user_id BIGINT UNSIGNED NOT NULL,
  product_id BIGINT UNSIGNED NOT NULL,
  order_id BIGINT UNSIGNED NULL,
  rating TINYINT UNSIGNED NOT NULL,
  content TEXT NULL,
  status ENUM('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (user_id) REFERENCES users(id),
  FOREIGN KEY (product_id) REFERENCES products(id),
  FOREIGN KEY (order_id) REFERENCES orders(id),
  CHECK (rating BETWEEN 1 AND 5),
  INDEX idx_review_product_status (product_id, status)
) ENGINE=InnoDB;

CREATE TABLE inventory_movements (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  variant_id BIGINT UNSIGNED NOT NULL,
  user_id BIGINT UNSIGNED NULL,
  movement_type ENUM('import','export','adjustment','return') NOT NULL,
  quantity_change INT NOT NULL,
  reference_type VARCHAR(40) NULL,
  reference_id BIGINT UNSIGNED NULL,
  note VARCHAR(500) NULL,
  created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
  FOREIGN KEY (variant_id) REFERENCES product_variants(id),
  FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE SET NULL,
  INDEX idx_inventory_variant_date (variant_id, created_at)
) ENGINE=InnoDB;

CREATE TABLE settings (
  id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  setting_key VARCHAR(120) NOT NULL UNIQUE,
  setting_value TEXT NULL,
  updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB;

INSERT INTO roles (name, description) VALUES
('Super Admin', 'Toàn quyền quản trị hệ thống'),
('Admin', 'Quản trị các module được cấp quyền'),
('Staff', 'Nhân viên vận hành'),
('Customer', 'Khách hàng');
