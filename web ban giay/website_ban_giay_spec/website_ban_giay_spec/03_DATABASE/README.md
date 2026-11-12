# Thiết kế cơ sở dữ liệu

## 1. Hệ quản trị
MySQL 8.x, InnoDB, `utf8mb4`. Tên bảng dùng số nhiều hoặc quy ước nhất quán; tài liệu này dùng tên tiếng Anh viết hoa để dễ đối chiếu.

## 2. Danh sách bảng đề xuất
Thiết kế nền gồm 21 bảng:

| Bảng | Mục đích |
|---|---|
| `ROLES` | Danh sách vai trò |
| `USERS` | Tài khoản khách hàng/nhân viên/quản trị |
| `USER_ROLES` | Gán nhiều vai trò cho người dùng |
| `USER_ADDRESSES` | Địa chỉ giao hàng |
| `BRANDS` | Thương hiệu giày |
| `CATEGORIES` | Danh mục, hỗ trợ danh mục cha |
| `PRODUCTS` | Thông tin sản phẩm gốc |
| `PRODUCT_CATEGORIES` | Quan hệ sản phẩm – danh mục |
| `PRODUCT_VARIANTS` | Biến thể size/màu, SKU, giá và tồn kho |
| `PRODUCT_IMAGES` | Ảnh sản phẩm |
| `CARTS` | Giỏ hàng lưu DB (có thể dùng Session cho khách) |
| `CART_ITEMS` | Các dòng sản phẩm trong giỏ |
| `ORDERS` | Đơn hàng và snapshot thông tin người nhận |
| `ORDER_ITEMS` | Chi tiết đơn và snapshot tên/size/màu/giá |
| `ORDER_STATUS_HISTORIES` | Lịch sử trạng thái đơn |
| `PAYMENTS` | Giao dịch thanh toán |
| `VOUCHERS` | Mã giảm giá |
| `VOUCHER_REDEMPTIONS` | Lịch sử sử dụng voucher |
| `REVIEWS` | Đánh giá sản phẩm |
| `INVENTORY_MOVEMENTS` | Lịch sử nhập/xuất/điều chỉnh kho |
| `SETTINGS` | Cấu hình hệ thống |

## 3. Quan hệ chính
- `USERS` 1–N `USER_ADDRESSES`.
- `USERS` N–N `ROLES` thông qua `USER_ROLES`.
- `BRANDS` 1–N `PRODUCTS`.
- `PRODUCTS` N–N `CATEGORIES` thông qua `PRODUCT_CATEGORIES`.
- `PRODUCTS` 1–N `PRODUCT_VARIANTS`.
- `PRODUCTS` 1–N `PRODUCT_IMAGES`.
- `USERS` 1–N `CARTS`; `CARTS` 1–N `CART_ITEMS`.
- `USERS` 1–N `ORDERS` (khách guest có thể có `user_id` NULL).
- `ORDERS` 1–N `ORDER_ITEMS`, `ORDER_STATUS_HISTORIES`, `PAYMENTS`.
- `PRODUCT_VARIANTS` 1–N `ORDER_ITEMS`, `CART_ITEMS`, `INVENTORY_MOVEMENTS`.
- `VOUCHERS` 1–N `VOUCHER_REDEMPTIONS`; `ORDERS` 0..1–N redemption tùy chính sách.
- `USERS` 1–N `REVIEWS`; `PRODUCTS` 1–N `REVIEWS`.

## 4. Nguyên tắc thiết kế
- Dùng khóa chính số nguyên tăng tự động hoặc UUID nhất quán toàn dự án.
- Tiền dùng `DECIMAL(12,2)`, không dùng FLOAT/DOUBLE.
- Số lượng dùng kiểu số nguyên không âm.
- `email`, `sku`, `order_code` cần unique phù hợp.
- Dùng `created_at`, `updated_at` cho các bảng nghiệp vụ quan trọng.
- Dùng FK và index cho cột thường xuyên lọc/join.
- Lưu snapshot trong `ORDER_ITEMS` và `ORDERS`; không phụ thuộc hoàn toàn vào dữ liệu sản phẩm/địa chỉ hiện tại.
- Không xóa đơn hàng/giao dịch đã phát sinh.
- Thao tác đặt hàng phải chạy trong transaction.

## 5. Những điểm cần chốt khi triển khai
- Có cho phép một sản phẩm thuộc nhiều danh mục hay chỉ một danh mục.
- Phí vận chuyển và đơn vị vận chuyển.
- Chính sách giữ tồn kho khi đơn pending.
- Có hỗ trợ hoàn hàng/đổi size và hoàn tiền một phần hay không.
- Phương thức đăng nhập (email, số điện thoại hoặc cả hai).
- Cơ chế giỏ hàng guest: Session hay DB bằng session token.
