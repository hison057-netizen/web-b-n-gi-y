<?php

declare(strict_types=1);

use App\Core\View;
?>
<section class="welcome-card">
  <div class="eyebrow"><span class="status-dot"></span> GIAI ĐOẠN 1 · KHỞI TẠO NỀN TẢNG</div>
  <h1>Website đang được chuẩn bị</h1>
  <p>Khung PHP MVC đã sẵn sàng để bắt đầu triển khai các chức năng cửa hàng theo đặc tả.</p>
  <div class="status-list">
    <div><span class="check-mark">✓</span><span>Front controller và định tuyến cơ bản</span></div>
    <div><span class="check-mark">✓</span><span>Tách Controller, View và layout</span></div>
    <div><span class="check-mark">✓</span><span>Cấu hình môi trường ngoài thư mục public</span></div>
  </div>
  <a class="primary-link" href="<?= View::escape(View::url('admin')) ?>">Mở khung quản trị <span>→</span></a>
</section>
