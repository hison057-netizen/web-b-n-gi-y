<?php

declare(strict_types=1);

use App\Core\View;
?>
<section class="welcome-card error-card">
  <div class="error-code">404</div>
  <h1>Không tìm thấy trang</h1>
  <p>Địa chỉ bạn truy cập không tồn tại hoặc đã được thay đổi.</p>
  <a class="primary-link" href="<?= View::escape(View::url()) ?>">Về trang chủ <span>→</span></a>
</section>
