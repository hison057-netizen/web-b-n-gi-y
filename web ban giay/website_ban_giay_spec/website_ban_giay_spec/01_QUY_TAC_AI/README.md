# Quy tắc dành cho AI

## 1. Vai trò
AI đóng vai trò trợ lý phân tích, thiết kế, lập trình và kiểm tra website bán giày online. AI phải làm đúng phạm vi yêu cầu, không tự ý thay đổi kiến trúc hoặc tạo chức năng ngoài đặc tả.

## 2. Quy tắc trước khi viết code
1. Xác định chức năng thuộc nhóm nào: khách hàng, quản trị, kho, đơn hàng, marketing, chăm sóc khách hàng hay kế toán.
2. Đọc nghiệp vụ liên quan trong `02_NGHIEP_VU/`.
3. Đọc bảng và quan hệ liên quan trong `03_DATABASE/`.
4. Tuân thủ cấu trúc tại `04_CAU_TRUC_THU_MUC/` và công nghệ tại `05_CONG_NGHE/`.
5. Nếu yêu cầu mâu thuẫn với tài liệu, nêu rõ điểm mâu thuẫn và đề xuất cách xử lý; không âm thầm tự chọn.

## 3. Quy tắc kiến trúc
- Bắt buộc sử dụng PHP MVC và OOP.
- Controller tiếp nhận request, kiểm tra đầu vào cơ bản, gọi Model/Service và chọn View hoặc trả response.
- Model chịu trách nhiệm truy cập dữ liệu qua PDO; không viết SQL trực tiếp trong View.
- View chỉ hiển thị dữ liệu và giao diện; không chứa truy vấn SQL hoặc xử lý nghiệp vụ quan trọng.
- Nghiệp vụ nhiều bước (đặt hàng, thanh toán, trừ kho, áp voucher) nên đặt trong Service để dễ kiểm thử.
- Không tạo một file PHP khổng lồ chứa toàn bộ chức năng.
- Tái sử dụng layout, component, helper và validation; tránh lặp code.

## 4. Quy tắc PHP và cơ sở dữ liệu
- Dùng PDO, prepared statements và bind/execute tham số; tuyệt đối không nối chuỗi dữ liệu người dùng vào SQL.
- Không sử dụng `mysqli`.
- Không đặt thông tin kết nối DB trực tiếp trong mã nguồn được commit. Dùng `.env` hoặc file cấu hình không công khai.
- Mọi dữ liệu đầu vào phải được kiểm tra phía server; kiểm tra phía trình duyệt chỉ nhằm cải thiện trải nghiệm.
- Dùng transaction cho các thao tác nhiều bảng có tính nguyên tử, đặc biệt là tạo đơn hàng, chi tiết đơn, thanh toán và cập nhật tồn kho.
- Không xóa cứng dữ liệu đơn hàng hoặc giao dịch đã phát sinh; ưu tiên trạng thái/soft delete khi phù hợp.
- Dùng khóa ngoại, unique, index và kiểu dữ liệu phù hợp.
- Không tin giá, tổng tiền, giảm giá hay tồn kho gửi từ trình duyệt. Server phải tính lại.

## 5. Quy tắc bảo mật
- Dùng `password_hash()` và `password_verify()` cho mật khẩu.
- Chống SQL Injection bằng prepared statements.
- Escape dữ liệu khi hiển thị HTML để giảm XSS.
- Dùng CSRF token cho biểu mẫu thay đổi dữ liệu.
- Kiểm tra đăng nhập và quyền truy cập ở server cho mọi trang quản trị.
- Không chỉ ẩn nút trên giao diện để phân quyền.
- Kiểm tra loại, kích thước và nội dung file khi upload ảnh; đổi tên file an toàn.
- Không hiển thị mật khẩu, token, thông tin bí mật hoặc lỗi SQL chi tiết cho người dùng cuối.

## 6. Quy tắc giao diện
- Giao diện tiếng Việt, dễ dùng trên máy tính và điện thoại.
- Có trạng thái loading, thành công, thất bại, danh sách rỗng và xác nhận trước thao tác nguy hiểm.
- Form phải có nhãn, thông báo lỗi rõ ràng và giữ lại dữ liệu hợp lệ khi validation thất bại.
- Không tự ý thay đổi màu sắc, nhận diện thương hiệu hoặc bố cục đã được người dùng duyệt.
- Không dùng dữ liệu giả trong chức năng đã kết nối DB, trừ khi được yêu cầu tạo seed/demo.

## 7. Quy tắc khi sửa code hiện có
- Kiểm tra file và luồng liên quan trước khi sửa.
- Chỉ sửa phạm vi cần thiết; không tự ý viết lại module đang hoạt động.
- Giữ tương thích với tên bảng, cột, route và quy ước đã có.
- Nêu các file đã tạo/sửa, mục đích thay đổi và cách kiểm tra.
- Không tuyên bố đã chạy test nếu chưa thực sự chạy.

## 8. Quy tắc đầu ra
Khi được yêu cầu xây dựng một chức năng, AI nên trình bày:
1. Mục tiêu và luồng hoạt động ngắn gọn.
2. Các file cần tạo/sửa.
3. Code hoàn chỉnh theo từng file, ghi rõ đường dẫn.
4. Cách cấu hình/chạy thử.
5. Các trường hợp cần kiểm tra.

## 9. Không được làm
- Không tự ý đổi PHP MVC sang Laravel, Node.js, React hoặc framework khác.
- Không dùng `mysqli`.
- Không đặt SQL trong View.
- Không bỏ qua kiểm tra quyền ở server.
- Không trừ kho chỉ dựa trên số lượng client gửi lên.
- Không lưu mật khẩu dạng chữ thường.
- Không tự tạo bảng/cột khác đặc tả mà không giải thích lý do.
