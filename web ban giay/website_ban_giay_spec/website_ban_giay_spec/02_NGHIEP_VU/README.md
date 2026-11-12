# Đặc tả nghiệp vụ – Website bán giày online

## 1. Mục tiêu hệ thống
Cho phép khách xem, tìm kiếm, chọn biến thể giày, đặt hàng và theo dõi đơn. Nhân viên/quản trị quản lý sản phẩm, kho, đơn hàng, marketing, khách hàng, nội dung và báo cáo.

## 2. Tác nhân (Actor)
- **Khách vãng lai (Guest):** chưa đăng nhập.
- **Khách đã có tài khoản (Registered Customer):** đã đăng nhập.
- **Quản trị & Phân quyền:** nhóm người vận hành có quyền được cấp.
- **Super Admin:** cấp quyền cao nhất, quản lý tài khoản quản trị và phân quyền. Đây là vai trò đặc biệt, không phải thao tác nghiệp vụ độc lập.

## 3. Nghiệp vụ khách hàng

### 3.1 Khách vãng lai
- Xem danh sách và chi tiết sản phẩm.
- Tìm kiếm, lọc theo danh mục, thương hiệu, size, màu, khoảng giá và tình trạng còn hàng.
- Đăng ký tài khoản.
- Đặt hàng không bắt buộc đăng nhập.
- Chọn phương thức thanh toán trong quá trình checkout.

### 3.2 Khách đã đăng ký
- Đăng nhập và đăng xuất.
- Xem sản phẩm.
- Quản lý hồ sơ cá nhân.
- Thêm/sửa/xóa địa chỉ giao hàng; chọn địa chỉ mặc định.
- Xem lịch sử mua hàng.
- Theo dõi trạng thái đơn hàng.
- Đánh giá sản phẩm đã mua.

### 3.3 Luồng đặt hàng đề xuất
1. Khách chọn sản phẩm, size, màu và số lượng.
2. Hệ thống kiểm tra biến thể còn hoạt động và đủ tồn kho.
3. Khách mở giỏ hàng, chỉnh sửa số lượng hoặc xóa sản phẩm.
4. Khách nhập/chọn thông tin người nhận và địa chỉ giao hàng.
5. Hệ thống tính lại giá, phí vận chuyển (nếu áp dụng), voucher và tổng thanh toán.
6. Khách chọn phương thức thanh toán: COD hoặc cổng thanh toán trực tuyến nếu được cấu hình.
7. Hệ thống tạo đơn hàng và chi tiết đơn trong transaction.
8. Hệ thống ghi nhận trạng thái thanh toán phù hợp, lưu lịch sử trạng thái và thông báo kết quả.

**Lưu ý:** COD có thể tạo đơn ở trạng thái chưa thanh toán; không được hiểu rằng mọi đơn đều phải thanh toán trực tuyến trước khi tạo.

## 4. Nghiệp vụ quản trị

### 4.1 Quản lý toàn bộ hệ thống / Super Admin
- Tạo, khóa/mở khóa tài khoản quản trị.
- Gán vai trò và quyền.
- Quản lý cấu hình quan trọng.
- Xem nhật ký hoạt động quản trị.

### 4.2 Quản lý sản phẩm
- Thêm, xem, sửa, ẩn/hiện sản phẩm.
- Quản lý danh mục, thương hiệu.
- Quản lý ảnh sản phẩm.
- Quản lý biến thể size/màu, SKU, giá bán, giá khuyến mãi và trạng thái.
- Không cho đặt mua biến thể đã ngừng kinh doanh.

### 4.3 Quản lý kho
- Xem tồn kho theo từng biến thể.
- Lập phiếu nhập hàng và chi tiết phiếu nhập.
- Ghi nhận tăng/giảm/điều chỉnh tồn kho.
- Lưu lịch sử biến động kho và người thực hiện.
- Không cho tồn kho âm nếu chưa có chính sách cho phép.

### 4.4 Quản lý đơn hàng
- Xem và tìm kiếm đơn.
- Xem chi tiết đơn, người nhận, sản phẩm, thanh toán.
- Xác nhận, chuẩn bị hàng, giao hàng, hoàn tất hoặc hủy đơn theo quy trình.
- Cập nhật trạng thái và lưu lịch sử thay đổi.
- Khi hủy/hoàn trả, xử lý tồn kho và hoàn tiền theo chính sách; không tự động hoàn kho nhiều lần.

### 4.5 Marketing
- Quản lý voucher/mã giảm giá.
- Quản lý banner và nội dung quảng bá.
- Thiết lập thời gian hiệu lực, số lượt sử dụng và điều kiện áp dụng.
- Server xác minh voucher trước khi tạo đơn.

### 4.6 Chăm sóc khách hàng
- Xem thông tin khách hàng và lịch sử mua.
- Hỗ trợ yêu cầu của khách.
- Kiểm duyệt/xử lý đánh giá theo chính sách.
- Gửi thông báo về đơn hàng hoặc chương trình.
- Không sửa nội dung đánh giá để giả mạo ý kiến khách hàng.

### 4.7 Kế toán
- Xem báo cáo doanh thu, số đơn, sản phẩm bán chạy.
- Lọc báo cáo theo khoảng thời gian.
- Phân biệt doanh thu đơn hoàn tất với đơn mới tạo/đã hủy.
- Đối soát thanh toán và hoàn tiền.

### 4.8 Quản lý hệ thống
- Quản lý người dùng.
- Phân quyền chi tiết theo module và hành động.
- Quản lý nội dung website.
- Cài đặt hệ thống.

## 5. Quy tắc nghiệp vụ cốt lõi
- Mỗi biến thể sản phẩm có SKU duy nhất.
- Size và màu là thuộc tính của biến thể; tồn kho theo biến thể, không chỉ theo sản phẩm cha.
- Giá và tên sản phẩm tại thời điểm mua phải được chụp vào `ORDER_ITEMS`.
- Tổng tiền được tính lại ở server.
- Một đánh giá chỉ được tạo bởi khách đã mua sản phẩm; đề xuất chỉ cho đánh giá sau khi đơn hoàn tất.
- Khách có thể đặt hàng không đăng nhập nhưng phải cung cấp thông tin người nhận và liên hệ hợp lệ.
- Mỗi đơn có mã đơn duy nhất.
- Mọi thay đổi trạng thái đơn phải ghi lịch sử.
- Quyền quản trị được kiểm tra ở server.
- Voucher phải được kiểm tra thời hạn, số lượt, điều kiện đơn tối thiểu và phạm vi sản phẩm/danh mục nếu có.
- Thanh toán online cần lưu mã giao dịch và phản hồi từ cổng thanh toán; không tin redirect từ trình duyệt là bằng chứng thanh toán thành công.

## 6. Trạng thái đề xuất
- Đơn hàng: `pending`, `confirmed`, `processing`, `shipping`, `completed`, `cancelled`, `returned`.
- Thanh toán: `unpaid`, `pending`, `paid`, `failed`, `refunded`, `partially_refunded`.
- Sản phẩm/biến thể: `active`, `inactive`.
- Voucher: `active`, `inactive`, `expired`.

## 7. Quan hệ Use Case cần lưu ý
- “Đặt hàng” thường bao gồm bước “Thanh toán/ghi nhận phương thức thanh toán”; nếu thanh toán là tùy chọn theo COD hay online thì mô hình hóa như một bước/nhánh trong checkout, không nên mặc định mọi đơn đều phải thanh toán trước.
- `<<include>>` biểu thị hành vi bắt buộc được dùng lại; `<<extend>>` biểu thị hành vi mở rộng có điều kiện.
- “Super Admin” nên được thể hiện là actor chuyên biệt hoặc vai trò có quyền cao nhất, không nên đặt như một chức năng ngang hàng với “Quản lý sản phẩm”.
