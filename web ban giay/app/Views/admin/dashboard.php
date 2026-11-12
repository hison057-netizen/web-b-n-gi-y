<?php

declare(strict_types=1);

use App\Core\View;
?>
<section class="welcome-card admin-card">
  <div class="eyebrow"><span class="status-dot"></span> KHU VỰC QUẢN TRỊ</div>
  <h1>Khung quản trị đã sẵn sàng</h1>
  <p>Đây mới là layout và route khởi tạo. Đăng nhập, phân quyền và dữ liệu dashboard sẽ được làm ở các giai đoạn tiếp theo.</p>
  <div class="notice">
    <strong>Chưa kết nối nghiệp vụ</strong>
    <span>Không có dữ liệu giả hoặc thao tác quản trị được thực hiện trên trang này.</span>
  </div>
  <a class="primary-link" href="<?= View::escape(View::url()) ?>">← Quay lại trang chủ</a>
</section>
