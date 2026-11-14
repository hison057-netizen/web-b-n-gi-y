USE shoe_store;

-- 1. Thêm Brands
INSERT INTO brands (id, name, slug, status) VALUES
(1, 'Nike', 'nike', 'active'),
(2, 'Adidas', 'adidas', 'active'),
(3, 'Puma', 'puma', 'active'),
(4, 'Converse', 'converse', 'active'),
(5, 'Vans', 'vans', 'active')
ON DUPLICATE KEY UPDATE name=VALUES(name);

-- 2. Thêm Categories
INSERT INTO categories (id, name, slug, status) VALUES
(1, 'Giày Sneaker', 'giay-sneaker', 'active'),
(2, 'Giày Chạy Bộ (Running)', 'giay-chay-bo', 'active'),
(3, 'Giày Bóng Rổ', 'giay-bong-ro', 'active'),
(4, 'Giày Thời Trang / Casual', 'giay-thoi-trang', 'active'),
(5, 'Giày Lười / Slip-on', 'giay-luoi', 'active')
ON DUPLICATE KEY UPDATE name=VALUES(name);

-- 3. Thêm Users mẫu (mật khẩu mặc định: 123456)
INSERT INTO users (id, full_name, email, phone, password_hash, status) VALUES
(1, 'Quản Trị Viên', 'admin@solemate.vn', '0901234567', '$2y$10$wE3z.oX5bLqT2eQnJg6zre1XG8QW2F6H.yF9jE0pC1eH4vA5h2y6q', 'active'),
(2, 'Nguyễn Văn Phong', 'phong@gmail.com', '0987654321', '$2y$10$wE3z.oX5bLqT2eQnJg6zre1XG8QW2F6H.yF9jE0pC1eH4vA5h2y6q', 'active'),
(3, 'Trần Thị Mai', 'mai.tran@gmail.com', '0912345678', '$2y$10$wE3z.oX5bLqT2eQnJg6zre1XG8QW2F6H.yF9jE0pC1eH4vA5h2y6q', 'active')
ON DUPLICATE KEY UPDATE full_name=VALUES(full_name);

INSERT IGNORE INTO user_roles (user_id, role_id) VALUES
(1, 1),
(2, 4),
(3, 4);

-- 4. Thêm Products
INSERT INTO products (id, brand_id, name, slug, description, status) VALUES
(1, 1, 'Nike Air Force 1 \'07 Triple White', 'nike-air-force-1-07-triple-white', 'Mẫu giày sneaker huyền thoại của Nike với tông màu trắng tinh khiết thanh lịch, đệm Air êm ái suốt cả ngày.', 'active'),
(2, 1, 'Nike Air Jordan 1 Retro High OG', 'nike-air-jordan-1-retro-high-og', 'Biểu tượng văn hóa bóng rổ và streetwear toàn cầu với phối màu Chicago cổ điển.', 'active'),
(3, 2, 'Adidas Ultraboost Light Core Black', 'adidas-ultraboost-light-core-black', 'Giày chạy bộ công nghệ Boost siêu nhẹ, đàn hồi vượt trội hỗ trợ tối đa cho từng bước chạy.', 'active'),
(4, 2, 'Adidas Samba Classic OG White/Black', 'adidas-samba-classic-og-white-black', 'Đôi giày bóng đá đường phố kinh điển trở thành xu hướng thời trang retro hot nhất hiện nay.', 'active'),
(5, 3, 'Puma Suede Classic XXI Peacoat', 'puma-suede-classic-xxi-peacoat', 'Chất liệu da lộn cao cấp mang phong cách hip-hop cổ điển từ thập niên 60.', 'active'),
(6, 4, 'Converse Chuck Taylor All Star 70s Black', 'converse-chuck-70-black', 'Dòng Chuck 70 cao cấp với đế dầy, vải canvas bền bỉ và miếng lót đệm êm chân.', 'active')
ON DUPLICATE KEY UPDATE name=VALUES(name);

-- 5. Liên kết Category - Product
INSERT IGNORE INTO product_categories (product_id, category_id) VALUES
(1, 1), (1, 4),
(2, 1), (2, 3),
(3, 2),
(4, 1), (4, 4),
(5, 1), (5, 4),
(6, 1), (6, 4);

-- 6. Thêm Product Variants (Size, Color, Price, Stock)
INSERT INTO product_variants (product_id, sku, size, color, price, sale_price, stock_quantity, status) VALUES
(1, 'AF1-07-WHT-40', '40', 'Trắng', 2890000, 2590000, 15, 'active'),
(1, 'AF1-07-WHT-41', '41', 'Trắng', 2890000, 2590000, 20, 'active'),
(1, 'AF1-07-WHT-42', '42', 'Trắng', 2890000, 2590000, 12, 'active'),
(2, 'AJ1-HIGH-CHI-41', '41', 'Đỏ/Trắng/Đen', 5200000, 4850000, 8, 'active'),
(2, 'AJ1-HIGH-CHI-42', '42', 'Đỏ/Trắng/Đen', 5200000, 4850000, 5, 'active'),
(3, 'UB-LT-BLK-41', '41', 'Đen', 4500000, 3990000, 10, 'active'),
(3, 'UB-LT-BLK-42', '42', 'Đen', 4500000, 3990000, 14, 'active'),
(4, 'SAMBA-OG-WHT-40', '40', 'Trắng/Đen', 2600000, 2350000, 18, 'active'),
(4, 'SAMBA-OG-WHT-41', '41', 'Trắng/Đen', 2600000, 2350000, 25, 'active'),
(5, 'PUMA-SD-BLU-41', '41', 'Xanh Navy', 1890000, 1590000, 16, 'active'),
(6, 'CHUCK70-BLK-41', '41', 'Đen', 2000000, 1750000, 30, 'active')
ON DUPLICATE KEY UPDATE price=VALUES(price);

-- 7. Thêm Product Images
INSERT INTO product_images (product_id, image_url, alt_text, sort_order, is_primary) VALUES
(1, 'https://images.unsplash.com/photo-1595950653106-6c9ebd614d3a?w=600&auto=format&fit=crop&q=80', 'Nike Air Force 1 07', 1, 1),
(2, 'https://images.unsplash.com/photo-1552346154-21d32810aba3?w=600&auto=format&fit=crop&q=80', 'Air Jordan 1 High', 1, 1),
(3, 'https://images.unsplash.com/photo-1584735935682-2f2b69dff9d2?w=600&auto=format&fit=crop&q=80', 'Adidas Ultraboost', 1, 1),
(4, 'https://images.unsplash.com/photo-1607522370275-f14206abe5d3?w=600&auto=format&fit=crop&q=80', 'Adidas Samba Classic', 1, 1),
(5, 'https://images.unsplash.com/photo-1608231387042-66d1773070a5?w=600&auto=format&fit=crop&q=80', 'Puma Suede Classic', 1, 1),
(6, 'https://images.unsplash.com/photo-1607522370275-f14206abe5d3?w=600&auto=format&fit=crop&q=80', 'Converse Chuck 70', 1, 1)
ON DUPLICATE KEY UPDATE image_url=VALUES(image_url);

-- 8. Thêm Đơn Hàng Mẫu
INSERT INTO orders (id, order_code, user_id, recipient_name, recipient_phone, shipping_address, subtotal, discount_amount, shipping_fee, total_amount, payment_method, payment_status, order_status) VALUES
(1, 'ORD-20261114-001', 2, 'Nguyễn Văn Phong', '0987654321', 'Số 123 Đường Cầu Giấy, Hà Nội', 2590000, 0, 30000, 2620000, 'cod', 'unpaid', 'confirmed'),
(2, 'ORD-20261114-002', 3, 'Trần Thị Mai', '0912345678', '45 Lê Duẩn, Quận 1, TP.HCM', 4850000, 200000, 0, 4650000, 'banking', 'paid', 'completed')
ON DUPLICATE KEY UPDATE order_code=VALUES(order_code);
