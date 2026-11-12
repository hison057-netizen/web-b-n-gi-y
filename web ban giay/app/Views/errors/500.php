<?php

declare(strict_types=1);

use App\Core\View;
?>
<section class="welcome-card error-card">
  <div class="error-code">500</div>
  <h1>Không thể xử lý yêu cầu</h1>
  <p>Hệ thống gặp sự cố. Vui lòng thử lại sau.</p>
  <a class="primary-link" href="<?= View::escape(View::url()) ?>">Về trang chủ <span>→</span></a>
</section>
