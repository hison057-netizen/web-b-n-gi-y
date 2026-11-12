# Quy trình xây dựng website bán giày online

Tài liệu này chuyển bộ đặc tả trong `website_ban_giay_spec/website_ban_giay_spec/` và sơ đồ Use Case thành các giai đoạn triển khai có thứ tự, tiêu chí bàn giao và điều kiện kiểm thử. Đây là quy trình triển khai PHP MVC thuần theo OOP, PDO và MySQL; không chuyển sang framework hoặc frontend framework khác.

## 1. Nguồn yêu cầu và nguyên tắc

- Đặc tả nghiệp vụ: `website_ban_giay_spec/website_ban_giay_spec/02_NGHIEP_VU/README.md`.
- Quy tắc bắt buộc khi viết/sửa mã: `website_ban_giay_spec/website_ban_giay_spec/01_QUY_TAC_AI/README.md`.
- Cơ sở dữ liệu tham chiếu: `website_ban_giay_spec/website_ban_giay_spec/03_DATABASE/README.md` và `website_ban_giay_spec/website_ban_giay_spec/03_DATABASE/schema.sql`.
- Kiến trúc dự án: `website_ban_giay_spec/website_ban_giay_spec/04_CAU_TRUC_THU_MUC/README.md`.
- Công nghệ/môi trường: `website_ban_giay_spec/website_ban_giay_spec/05_CONG_NGHE/README.md`.
- Sơ đồ Use Case dùng để xác định actor và phạm vi; các quy tắc chi tiết trong tài liệu nghiệp vụ được dùng để bổ sung luồng.

Quy tắc xuyên suốt:

1. Controller tiếp nhận request và điều phối; Model truy cập dữ liệu bằng PDO; View chỉ trình bày; nghiệp vụ nhiều bước đặt trong Service.
2. Dùng prepared statements, validate phía server, escape HTML, CSRF token cho thao tác thay đổi dữ liệu, và kiểm tra quyền quản trị ở server.
3. Không tin giá, giảm giá, tổng tiền, quyền hoặc tồn kho từ trình duyệt. Server phải xác minh/tính lại.
4. Đơn hàng, chi tiết đơn và cập nhật tồn kho phải nhất quán trong transaction; dữ liệu giá, sản phẩm và người nhận tại thời điểm đặt hàng phải được lưu snapshot.
5. Không xóa cứng đơn hàng/giao dịch đã phát sinh. Mọi thay đổi trạng thái đơn phải có lịch sử.
6. Giao diện tiếng Việt, responsive và có trạng thái tải, lỗi, rỗng, thành công cùng xác nhận thao tác nguy hiểm.
7. Không dùng dữ liệu giả trong chức năng kết nối cơ sở dữ liệu; dữ liệu demo phải được đánh dấu và đưa vào seeder.

## 2. Cổng quyết định trước khi làm nghiệp vụ

Các mục sau cần được xác nhận trước khi triển khai phần liên quan. Có thể dùng các mặc định đề xuất để bắt đầu khi chủ dự án đồng ý.

| Chủ đề | Cần quyết định | Mặc định đề xuất |
|---|---|---|
| Đăng nhập | Email, số điện thoại hay cả hai? | Email; số điện thoại là thông tin liên hệ |
| Giỏ hàng guest | Session hay giỏ DB bằng session token? Cách gộp giỏ sau đăng nhập? | Session cho guest, gộp và kiểm tra lại tồn kho khi đăng nhập |
| Thanh toán | Chỉ COD hay có cổng online? Nếu online, nhà cung cấp/sandbox nào? | COD hoạt động độc lập; online là phương thức tùy chọn, chỉ tích hợp sau khi chốt nhà cung cấp |
| Vận chuyển | Phí cố định, miễn phí theo điều kiện hay tích hợp đơn vị vận chuyển? | Phí cấu hình được; chưa tích hợp hãng vận chuyển ở MVP |
| Giữ tồn kho | Khi nào giữ/trừ kho với đơn pending và online chưa thanh toán? | Quy định rõ thời hạn giữ kho; cập nhật kho có kiểm soát và không cho âm |
| Hủy/hoàn hàng | Điều kiện, hoàn kho, hoàn tiền, hoàn một phần, chống xử lý lặp? | Chỉ cho phép chuyển trạng thái theo ma trận; thao tác hoàn kho/tiền có mã tham chiếu chống lặp |
| Danh mục | Sản phẩm thuộc một hay nhiều danh mục? | Nhiều danh mục như `PRODUCT_CATEGORIES` hiện thiết kế |
| Phân quyền | Quyền theo vai trò, module và hành động nào? | Super Admin quản lý quyền; Staff/Admin chỉ có quyền được cấp |
| Nội dung | Phạm vi banner/trang nội dung và trường dữ liệu? | Chốt mô hình trước khi thêm bảng; schema hiện tại chưa có bảng banner/CMS |
| Báo cáo | Múi giờ, thời điểm ghi nhận doanh thu, bộ lọc/kỳ báo cáo? | Chỉ tính doanh thu đơn hoàn tất; loại trừ đơn hủy, tách khoản hoàn |

Không âm thầm coi `<<include>>` trong sơ đồ là bằng chứng một bước tùy chọn luôn bắt buộc: COD có thể tạo đơn chưa thanh toán; bước thanh toán cần hỗ trợ các nhánh theo phương thức.

## 3. Quy trình theo giai đoạn

### Giai đoạn 0 — Chốt phạm vi và quy tắc

**Thực hiện**
- Chuyển Use Case thành danh sách chức năng theo actor: Guest, Registered Customer, Admin/Staff và Super Admin.
- Lập ma trận quyền theo module và hành động: xem, tạo, sửa, ẩn/hiện, duyệt, xử lý trạng thái, hoàn tiền.
- Chốt các quyết định trong bảng cổng quyết định; đánh dấu tính năng MVP và tính năng để sau.
- Tạo danh sách luồng chính, luồng lỗi và trạng thái đơn/thanh toán.

**Bàn giao**
- Danh sách yêu cầu có mã, actor, độ ưu tiên và tiêu chí chấp nhận.
- Ma trận quyền; quyết định nghiệp vụ còn mở và người chịu trách nhiệm chốt.

**Điều kiện qua giai đoạn**
- Luồng đặt hàng guest/COD, đặt hàng online nếu có, hủy/hoàn và quyền quản trị không còn mâu thuẫn.

### Giai đoạn 1 — Khởi tạo nền tảng dự án

**Thực hiện**
- Chuyển workspace sang cấu trúc PHP MVC ở `website_ban_giay_spec/website_ban_giay_spec/04_CAU_TRUC_THU_MUC/README.md`.
- Khởi tạo Composer/autoload PSR-4 nếu sử dụng; cấu hình PHP 8.2+, MySQL 8.x, Apache/XAMPP và document root trỏ vào `public/`.
- Tạo front controller `public/index.php`, router tập trung, layout khách/admin, cấu hình môi trường và trang lỗi.
- Tạo `.env.example`, `.gitignore`; tuyệt đối không đưa `.env`, mật khẩu hoặc log lên Git.
- Phân tách tài nguyên giao diện vào `public/assets/`; chỉ public hóa `public/`.

**Bàn giao**
- Ứng dụng PHP MVC khởi động được; route trang chủ và trang lỗi hoạt động.
- README có hướng dẫn cài môi trường, cấu hình DB và chạy ứng dụng.

**Điều kiện qua giai đoạn**
- Không có truy vấn SQL trong View; không có cấu hình bí mật trong mã nguồn; lỗi môi trường được báo rõ.

### Giai đoạn 2 — Chuẩn hóa cơ sở dữ liệu

**Thực hiện**
- Rà soát `website_ban_giay_spec/website_ban_giay_spec/03_DATABASE/schema.sql` so với nghiệp vụ, thống nhất quy tắc đặt tên, khóa, index, dữ liệu tiền `DECIMAL`, charset `utf8mb4` và engine InnoDB.
- Sửa và kiểm tra encoding tiếng Việt trong seed mô tả vai trò trước khi import; nội dung hiện có dấu hiệu mojibake.
- Tạo migration có thể áp dụng có kiểm soát và seeder cho vai trò/dữ liệu demo.
- Xác minh quan hệ sản phẩm–danh mục, biến thể–SKU–tồn kho, đơn hàng–snapshot, thanh toán, lịch sử trạng thái và biến động kho.
- Thiết kế bổ sung chỉ sau khi được duyệt: schema hiện chưa có bảng quyền chi tiết/nhật ký quản trị và banner/nội dung, dù nghiệp vụ yêu cầu các chức năng này.
- Rà soát chính sách xóa FK, unique/index và ràng buộc xuyên bảng mà CHECK hiện có chưa thể đảm bảo (ví dụ giá khuyến mãi không vượt giá niêm yết).

**Bàn giao**
- Schema/migration khởi tạo và seeder chạy được trên MySQL 8.
- Sơ đồ quan hệ và danh sách thay đổi so với `schema.sql`.

**Điều kiện qua giai đoạn**
- Có thể dựng DB mới từ đầu; khóa ngoại/ràng buộc trọng yếu kiểm tra được; không tồn tại mật khẩu quản trị mặc định yếu hoặc bí mật hard-code.

### Giai đoạn 3 — Hạ tầng dùng chung, xác thực và phân quyền

**Thực hiện**
- Xây dựng kết nối PDO, repository/model nền, routing, session, helper escape, validation, xử lý lỗi và logging.
- Làm đăng ký/đăng nhập/đăng xuất; dùng `password_hash()` / `password_verify()`, chống session fixation và giới hạn truy cập theo trạng thái tài khoản.
- Làm middleware xác thực và kiểm tra quyền ở từng request; Super Admin là vai trò đặc biệt có quyền cao nhất, không phải một nghiệp vụ song song.
- Thêm CSRF cho form thay đổi dữ liệu; thống nhất thông báo lỗi không lộ SQL, token hay bí mật.

**Bàn giao**
- Luồng auth và ma trận quyền có kiểm thử; tài khoản bị khóa không thể đăng nhập/thực hiện thao tác.

**Điều kiện qua giai đoạn**
- Truy cập trái quyền bị từ chối ở server kể cả khi gọi URL trực tiếp; CSRF và session hoạt động đúng.

### Giai đoạn 4 — Danh mục và giao diện cửa hàng

**Thực hiện**
- Làm quản trị thương hiệu, danh mục, sản phẩm, ảnh và biến thể (size/màu/SKU/giá/trạng thái).
- Làm trang danh sách/chi tiết cho guest và khách đăng nhập; tìm kiếm, lọc danh mục, thương hiệu, size, màu, giá và tình trạng hàng.
- Chỉ hiển thị biến thể đang kinh doanh; upload ảnh phải kiểm tra loại, kích thước, nội dung, đổi tên an toàn và lưu đường dẫn tương đối.
- Tạo trang admin sản phẩm/kho từ UI prototype hiện có nhưng tích hợp theo layout PHP MVC; không giữ số liệu demo như dữ liệu thật.

**Bàn giao**
- CRUD/ẩn hiện sản phẩm, ảnh và biến thể; trang catalog responsive và lọc đúng dữ liệu.

**Điều kiện qua giai đoạn**
- SKU duy nhất; sản phẩm/biến thể inactive không thể thêm vào giỏ hoặc đặt mua; dữ liệu hiển thị đã escape.

### Giai đoạn 5 — Giỏ hàng và checkout (đường đi nghiệp vụ cốt lõi)

**Thực hiện**
- Làm giỏ hàng guest bằng cơ chế đã chốt; hỗ trợ thêm/sửa/xóa và kiểm tra biến thể, số lượng, tình trạng kinh doanh.
- Khi đăng nhập, gộp giỏ theo chính sách và kiểm tra lại giá/tồn kho.
- Checkout guest và registered: kiểm tra thông tin nhận hàng, địa chỉ đã lưu, voucher, phí giao hàng và phương thức thanh toán.
- Đặt hàng trong Service/transaction: khóa/kiểm tra dữ liệu phù hợp, tính lại giá ở server, ghi `ORDERS`, snapshot `ORDER_ITEMS`, voucher redemption, payment và lịch sử trạng thái; xử lý tồn kho theo chính sách đã chốt.
- COD có thể tạo đơn với payment status `unpaid`; không yêu cầu thanh toán online thành công để tạo đơn COD.
- Cổng online (nếu có) chỉ cập nhật paid từ callback/webhook đã xác minh; không tin redirect trình duyệt.

**Bàn giao**
- Luồng mua hàng guest và registered có kết quả thành công/thất bại rõ ràng, không tạo đơn/ghi kho dở dang.

**Điều kiện qua giai đoạn**
- Kiểm thử đồng thời mua món cuối, gửi lại request, voucher hết hạn/hết lượt, giá/tồn kho bị thay đổi và thanh toán thất bại; không âm kho hoặc ghi nhận giao dịch trùng.

### Giai đoạn 6 — Vận hành đơn hàng và kho

**Thực hiện**
- Làm danh sách/tìm kiếm/chi tiết đơn; thông tin người nhận, sản phẩm, thanh toán và lịch sử trạng thái.
- Chuyển trạng thái theo ma trận hợp lệ: `pending → confirmed → processing → shipping → completed`; xử lý `cancelled`/`returned` theo chính sách, không cho chuyển tùy ý.
- Làm phiếu nhập/điều chỉnh kho và `INVENTORY_MOVEMENTS`, ghi người thao tác, lý do và tham chiếu đơn.
- Xây cơ chế chống hoàn kho/hoàn tiền lặp khi hủy/hoàn.

**Bàn giao**
- Quy trình nhân viên xử lý đơn từ tiếp nhận đến hoàn tất; sổ lịch sử đơn và kho truy vết được.

**Điều kiện qua giai đoạn**
- Trạng thái không hợp lệ bị chặn; tồn kho và lịch sử biến động khớp; không xóa cứng giao dịch/đơn.

### Giai đoạn 7 — Tài khoản khách hàng và hậu mãi

**Thực hiện**
- Hồ sơ, địa chỉ giao hàng, địa chỉ mặc định; lịch sử và theo dõi đơn.
- Đánh giá sản phẩm, trạng thái kiểm duyệt; chỉ khách đủ điều kiện theo chính sách (đề xuất: đơn hoàn tất) được đánh giá.
- Nhân viên tra cứu khách/lịch sử mua và xử lý yêu cầu; không sửa đánh giá để giả mạo ý kiến.

**Bàn giao**
- Khu vực tài khoản khách và công cụ CSKH theo quyền.

**Điều kiện qua giai đoạn**
- Người dùng chỉ sửa dữ liệu của mình; đánh giá phải có căn cứ mua hàng và không vượt giới hạn rating.

### Giai đoạn 8 — Marketing, nội dung và cài đặt

**Thực hiện**
- Quản lý voucher với thời hạn, giá trị đơn tối thiểu, giới hạn lượt, phạm vi áp dụng; xác minh lại tại server/transaction.
- Làm banner/nội dung sau khi chốt schema và luồng xuất bản.
- Làm người dùng quản trị, phân quyền chi tiết, cài đặt hệ thống và nhật ký hoạt động.

**Bàn giao**
- Công cụ quản trị marketing/nội dung/hệ thống theo ma trận quyền.

**Điều kiện qua giai đoạn**
- Voucher đồng thời không vượt usage limit; tài khoản không thể tự cấp quyền; nội dung chỉ hiển thị đúng trạng thái/lịch hiệu lực.

### Giai đoạn 9 — Kế toán, báo cáo, kiểm thử và phát hành

**Thực hiện**
- Báo cáo doanh thu, số đơn, sản phẩm bán chạy theo thời gian; tách đơn pending/cancelled/completed và khoản hoàn.
- Đối soát `PAYMENTS` với đơn; phân quyền xem báo cáo.
- Chạy kiểm thử đơn vị cho Service/validation, tích hợp DB cho transaction/permission, và end-to-end cho các hành trình chính.
- Kiểm tra responsive, khả năng truy cập form, thông báo lỗi, upload, backup/restore và cấu hình production.
- Rà soát bảo mật: SQL injection, XSS, CSRF, quyền truy cập, session, upload và rò rỉ bí mật.

**Bàn giao**
- Báo cáo khớp dữ liệu kiểm thử; checklist phát hành, hướng dẫn deploy/backup/khôi phục.

**Điều kiện phát hành**
- Các kiểm thử nghiệp vụ cốt lõi đạt; không còn lỗi nghiêm trọng; môi trường production dùng secret riêng, HTTPS, document root `public/`, logging và backup được xác minh.

## 4. Thứ tự phụ thuộc và cách làm từng tính năng

```text
Chốt nghiệp vụ
  → Nền tảng MVC + môi trường
  → Schema/migration
  → Auth + phân quyền
  → Sản phẩm/biến thể
  → Catalog + giỏ hàng
  → Checkout + thanh toán + transaction kho
  → Xử lý đơn/hậu mãi
  → Marketing/CMS/cài đặt
  → Báo cáo + phát hành
```

Mỗi tính năng đi qua cùng một vòng lặp:

1. Đọc quy tắc AI và đúng phần nghiệp vụ liên quan.
2. Kiểm tra bảng/cột/quan hệ hiện có trước khi sửa schema.
3. Chốt tiêu chí chấp nhận và luồng lỗi.
4. Viết Model/Service/Controller/Request/Middleware/View đúng trách nhiệm.
5. Thêm migration/seed nếu có thay đổi DB; không sửa dữ liệu production thủ công.
6. Kiểm thử quyền, dữ liệu sai, thao tác lặp, trạng thái rỗng và lỗi hạ tầng.
7. Rà soát bảo mật và responsive.
8. Ghi rõ file thay đổi, cách chạy và kết quả kiểm thử thực tế.

## 5. Đánh giá hiện trạng workspace

Workspace hiện có `index.html`, `styles.css`, `app.js` là giao diện admin tĩnh để tham khảo, chưa có PHP MVC, Composer, route, kết nối MySQL hay cơ chế xác thực/phân quyền. Vì vậy, khi bắt đầu xây dựng sản phẩm thật:

- Giữ UI làm tài liệu tham khảo; chuyển thành PHP View/component theo cấu trúc được duyệt.
- Thay số liệu tĩnh bằng dữ liệu từ Controller/Model; không coi menu/ẩn nút là phân quyền.
- Khởi đầu từ Giai đoạn 0–1, không nối trực tiếp giao diện tĩnh vào DB hoặc viết nghiệp vụ trong file hiện tại.
- Tài liệu `website_ban_giay_spec/website_ban_giay_spec/03_DATABASE/schema.sql` là nền tham chiếu, chưa bao phủ đầy đủ một số chức năng quản trị; mọi mở rộng phải được xác nhận và ghi migration.

## 6. Checklist hoàn tất một module

- [ ] Đúng actor và quyền; kiểm tra quyền ở server.
- [ ] Request được validate ở server; lỗi hiển thị rõ và không lộ chi tiết nhạy cảm.
- [ ] Dữ liệu SQL dùng PDO prepared statements.
- [ ] Thay đổi trạng thái/dữ liệu quan trọng có CSRF và transaction khi cần.
- [ ] Không tin giá, tiền, quyền hoặc tồn kho từ client.
- [ ] Có trạng thái loading, thành công, lỗi, rỗng và xác nhận thao tác nguy hiểm.
- [ ] Có kiểm thử luồng thành công, thất bại, biên và thao tác lặp.
- [ ] Giao diện tiếng Việt, responsive; dữ liệu hiển thị được escape.
- [ ] Tài liệu/cấu hình cần thiết được cập nhật; không commit secret hoặc dữ liệu cá nhân.
