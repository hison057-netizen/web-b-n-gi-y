# Tài liệu đặc tả – Website bán giày online

Bộ tài liệu được tách thành 5 phần độc lập để AI và lập trình viên có thể đọc đúng phạm vi cần thiết.

## Thành phần
1. `01_QUY_TAC_AI/` – Quy tắc bắt buộc khi AI phân tích, sinh và chỉnh sửa mã nguồn.
2. `02_NGHIEP_VU/` – Actor, chức năng, luồng nghiệp vụ và quy tắc vận hành.
3. `03_DATABASE/` – Mô hình dữ liệu, quan hệ bảng, quy ước và SQL khởi tạo.
4. `04_CAU_TRUC_THU_MUC/` – Cấu trúc dự án PHP MVC và trách nhiệm từng thư mục.
5. `05_CONG_NGHE/` – Công nghệ, phiên bản khuyến nghị và nguyên tắc sử dụng.

## Thứ tự đọc
- Đọc `05_CONG_NGHE/README.md` và `04_CAU_TRUC_THU_MUC/README.md` trước khi tạo dự án.
- Đọc `03_DATABASE/README.md` trước khi viết Model hoặc truy vấn.
- Đọc `02_NGHIEP_VU/README.md` để hiểu chức năng cần xây dựng.
- Luôn tuân thủ `01_QUY_TAC_AI/README.md` khi dùng AI để viết hoặc sửa code.

## Phạm vi
Website thương mại điện tử chuyên bán giày. Các nhóm người dùng chính: khách vãng lai, khách đã đăng ký, quản trị viên và nhân viên. Bộ tài liệu lấy sơ đồ Use Case được cung cấp làm nguồn yêu cầu; những chi tiết chưa thể hiện trên sơ đồ được ghi thành quy tắc đề xuất để dự án có thể triển khai nhất quán.

## Các quyết định thiết kế quan trọng
- PHP theo mô hình MVC, lập trình hướng đối tượng và PDO.
- MySQL làm hệ quản trị cơ sở dữ liệu.
- Một sản phẩm có nhiều biến thể theo size/màu; tồn kho được quản lý ở cấp biến thể.
- Vai trò mặc định: Admin, Staff, Customer. Super Admin là cấp quyền quản trị cao nhất, không phải một nghiệp vụ mua hàng.
- Giỏ hàng có thể lưu trong Session khi chưa đăng nhập; khi đăng nhập có thể đồng bộ vào cơ sở dữ liệu.
- Đơn hàng phải lưu ảnh chụp thông tin sản phẩm, giá và địa chỉ tại thời điểm đặt hàng để không bị thay đổi khi dữ liệu gốc cập nhật.
