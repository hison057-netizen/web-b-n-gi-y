# Công nghệ sử dụng

## 1. Stack đề xuất
| Thành phần | Công nghệ | Vai trò |
|---|---|---|
| Backend | PHP 8.2+ | Xử lý nghiệp vụ server |
| Kiến trúc | PHP MVC + OOP | Tách Controller, Model, View |
| Database access | PDO | Truy vấn DB an toàn |
| Database | MySQL 8.x | Lưu dữ liệu |
| Frontend | HTML5, CSS3, JavaScript | Giao diện và tương tác |
| UI framework | Bootstrap 5 | Responsive layout và component |
| JavaScript helper | jQuery (chỉ khi cần) | Tương tác DOM/AJAX đơn giản |
| Web server local | Apache (XAMPP) | Chạy ứng dụng PHP khi phát triển |
| Version control | Git + GitHub | Quản lý phiên bản |

## 2. Nguyên tắc lựa chọn
- Đây là stack PHP MVC thuần theo hướng OOP, không sử dụng Laravel trong phạm vi hiện tại.
- Không dùng React/Vue làm frontend chính nếu chưa có yêu cầu thay đổi kiến trúc.
- Dùng Bootstrap để xây dựng giao diện responsive; CSS riêng để tùy biến.
- Dùng JavaScript thuần cho tương tác cơ bản; chỉ thêm jQuery khi dự án thực sự cần.
- Dùng Composer cho autoload và thư viện PHP nếu cần.
- Có thể tích hợp cổng thanh toán sau khi xác định nhà cung cấp và môi trường sandbox.

## 3. Môi trường phát triển
- PHP 8.2 trở lên.
- MySQL 8.x.
- Apache thông qua XAMPP hoặc môi trường tương đương.
- Visual Studio Code.
- Git.
- Trình duyệt Chrome/Edge để kiểm thử.

## 4. Quy tắc cấu hình
- Lưu DB_HOST, DB_NAME, DB_USER, DB_PASS và APP_ENV trong `.env`.
- Cung cấp `.env.example` không chứa mật khẩu thật.
- Không commit thư mục `vendor/`, file log, file cache, file upload riêng tư hoặc `.env`.
- Dùng `public/` làm document root nếu cấu hình Apache cho phép.
- Tách cấu hình môi trường phát triển và triển khai.

## 5. Lệnh khởi tạo tham khảo
```bash
composer init
composer dump-autoload
```

Không bắt buộc cài thư viện ngoài nếu chức năng có thể thực hiện an toàn bằng PHP core và PDO. Trước khi thêm package, kiểm tra mức độ cần thiết, khả năng bảo trì và giấy phép.
