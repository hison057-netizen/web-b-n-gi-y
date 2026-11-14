<?php

declare(strict_types=1);

use App\Core\View;
?>
<!doctype html>
<html lang="vi">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="SoleMate - Cửa hàng giày thể thao & sneaker chính hãng.">
    <title><?= View::escape($title ?? APP_NAME) ?> | <?= View::escape(APP_NAME) ?></title>
    <link rel="stylesheet" href="<?= View::escape(View::asset('css/app.css')) ?>">
  </head>
  <body>
    <header class="site-header">
      <div class="header-left">
        <a class="brand" href="<?= View::escape(View::url()) ?>">
          <span class="brand-mark">S</span>
          <span><?= View::escape(APP_NAME) ?></span>
        </a>
        <nav>
          <ul class="nav-menu">
            <li><a href="<?= View::escape(View::url()) ?>">Trang chủ</a></li>
            <li><a href="<?= View::escape(View::url('products')) ?>">Sản phẩm</a></li>
          </ul>
        </nav>
      </div>
      <div class="header-right">
        <a class="admin-badge-btn" href="<?= View::escape(View::url('admin')) ?>">Quản trị (Admin) →</a>
      </div>
    </header>

    <main class="page-container">
      <?= $content ?>
    </main>

    <footer class="site-footer">
      <span>© <?= date('Y') ?> <?= View::escape(APP_NAME) ?> — Cửa hàng giày trực tuyến PHP MVC</span>
      <span>Hệ thống Model + PDO + MySQL 8.x</span>
    </footer>
  </body>
</html>
