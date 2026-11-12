# SoleMate — Website bán giày online

Nền tảng được triển khai theo PHP MVC thuần, OOP, PDO và MySQL theo bộ đặc tả trong `website_ban_giay_spec/website_ban_giay_spec/`. Không sử dụng Laravel, React hoặc Vue.

## Yêu cầu môi trường

- PHP 8.2 trở lên.
- Apache (XAMPP hoặc tương đương) hoặc PHP built-in server để phát triển.
- MySQL 8.x sẽ cần ở giai đoạn tích hợp cơ sở dữ liệu.
- Composer được cung cấp cùng Laragon; hiện dự án chưa dùng package bên thứ ba.

## Chạy phát triển trên Windows

1. Mở Laragon Terminal hoặc PowerShell tại thư mục dự án. Môi trường hiện tại dùng PHP 8.3.30 và Composer 2.9.4.
2. Tạo file môi trường cục bộ từ mẫu:

   ```powershell
   Copy-Item .env.example .env
   ```

3. Cài autoloader của dự án:

   ```powershell
   composer install
   ```

4. Khởi động ứng dụng:

   ```powershell
   composer run serve
   ```

   Hoặc chạy trực tiếp PHP:

   ```powershell
   php -S 127.0.0.1:8000 -t public public/router.php
   ```
5. Mở `http://127.0.0.1:8000/`. Route khung quản trị là `http://127.0.0.1:8000/admin`.

`.env` hiện mới chứa cấu hình mẫu; giai đoạn 1 chưa kết nối hoặc truy vấn cơ sở dữ liệu. Không điền mật khẩu thật vào `.env.example` và không đưa `.env` lên Git.

## Chạy với Apache/XAMPP

- Đặt DocumentRoot/VirtualHost trỏ tới thư mục `public/`, không trỏ tới thư mục gốc dự án.
- Bật `mod_rewrite` để các route được chuyển đến `public/index.php`.
- Giữ `app/`, `config/`, `database/`, `storage/`, `tests/` và `.env` bên ngoài vùng public.
- Nếu ứng dụng đặt dưới đường dẫn con, cấu hình `APP_BASE_URL` trong `.env` cho đúng tiền tố URL.

## Khung hiện có

- `public/index.php`: front controller.
- `public/router.php`: router cho PHP built-in server.
- `routes/web.php`: khai báo route tập trung.
- `app/Controllers`, `app/Core`, `app/Views`: các lớp nền MVC.
- `vendor/autoload.php`: Composer PSR-4 autoloader, được tạo bởi `composer install`.
- `config/`: cấu hình ứng dụng và thông số DB; chưa mở kết nối.
- `storage/logs/`: log ứng dụng; không public.
- `public/assets/`: tài nguyên public.
- Route `/` và `/admin` chỉ là trang khởi tạo, chưa có nghiệp vụ, đăng nhập hay phân quyền.

Giao diện admin tĩnh cũ tại thư mục gốc được giữ lại làm tài liệu tham khảo; sẽ được chuyển thành PHP View trong giai đoạn xây giao diện/module tương ứng.

## Kiến trúc request

`public/index.php` nạp bootstrap và cấu hình, tạo Router, đăng ký route từ `routes/web.php`, sau đó điều phối đến Controller. Controller chọn View/layout; View không truy vấn cơ sở dữ liệu. Xử lý lỗi chung ghi log vào `storage/logs/app.log`; chi tiết lỗi chỉ hiển thị khi `APP_ENV=development` và `APP_DEBUG=true`.

## Kiểm tra cấu hình

```powershell
php -v
php -m
composer --version
```

Môi trường hiện tại đã bật `pdo_mysql`. Khi bắt đầu giai đoạn 2, cần cấu hình kết nối và chạy migration trên MySQL 8.x.
