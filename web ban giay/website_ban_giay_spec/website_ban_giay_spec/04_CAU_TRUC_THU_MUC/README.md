# Cấu trúc thư mục đề xuất – PHP MVC

```text
shoe-store/
├── app/
│   ├── Controllers/
│   │   ├── AuthController.php
│   │   ├── ProductController.php
│   │   ├── CartController.php
│   │   ├── CheckoutController.php
│   │   ├── OrderController.php
│   │   └── Admin/
│   ├── Models/
│   │   ├── User.php
│   │   ├── Product.php
│   │   ├── ProductVariant.php
│   │   ├── Order.php
│   │   └── ...
│   ├── Services/
│   │   ├── CheckoutService.php
│   │   ├── PaymentService.php
│   │   ├── InventoryService.php
│   │   └── VoucherService.php
│   ├── Middleware/
│   │   ├── AuthMiddleware.php
│   │   ├── GuestMiddleware.php
│   │   └── PermissionMiddleware.php
│   ├── Requests/
│   ├── Helpers/
│   └── Views/
│       ├── layouts/
│       ├── components/
│       ├── auth/
│       ├── products/
│       ├── cart/
│       ├── checkout/
│       ├── orders/
│       └── admin/
├── config/
│   ├── app.php
│   └── database.php
├── database/
│   ├── migrations/
│   ├── seeders/
│   └── schema.sql
├── public/
│   ├── index.php
│   ├── assets/
│   │   ├── css/
│   │   ├── js/
│   │   └── images/
│   └── uploads/
│       └── products/
├── routes/
│   └── web.php
├── storage/
│   ├── logs/
│   └── cache/
├── tests/
├── .env.example
├── .gitignore
├── composer.json
└── README.md
```

## Trách nhiệm
- `app/Controllers`: nhận request, gọi service/model, trả view hoặc redirect.
- `app/Models`: truy vấn và thao tác dữ liệu bằng PDO.
- `app/Services`: xử lý nghiệp vụ nhiều bước và transaction.
- `app/Middleware`: xác thực đăng nhập, vai trò và quyền.
- `app/Requests`: validate dữ liệu đầu vào.
- `app/Views`: giao diện; không truy vấn DB.
- `config`: cấu hình ứng dụng và kết nối.
- `database`: schema, migration và dữ liệu mẫu.
- `public`: thư mục public duy nhất; entry point là `index.php`.
- `storage`: log/cache, không public trực tiếp.
- `tests`: kiểm thử nghiệp vụ.

## Quy tắc tổ chức
- Mỗi class PHP đặt trong file riêng, tên file trùng tên class.
- Dùng namespace/autoload PSR-4 nếu cấu hình Composer.
- Route khai báo tập trung trong `routes/web.php`.
- Tách giao diện khách hàng và quản trị trong các thư mục View riêng.
- Không đặt file `.env`, log hoặc file backup trong `public/`.
- Upload ảnh phải kiểm tra file và lưu tên ngẫu nhiên; DB chỉ lưu đường dẫn tương đối.
- Không tạo thư mục hoặc class trùng chức năng nếu đã có thành phần tương ứng.
