<?php

declare(strict_types=1);

use App\Core\View;
?>
<!doctype html>
<html lang="vi">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Khu vực quản trị SoleMate đang được thiết lập.">
    <title><?= View::escape($title ?? 'Quản trị') ?> | <?= View::escape(APP_NAME) ?></title>
    <link rel="stylesheet" href="<?= View::escape(View::asset('css/app.css')) ?>">
  </head>
  <body class="admin-page">
    <header class="site-header">
      <a class="brand" href="<?= View::escape(View::url('admin')) ?>" aria-label="Trang quản trị <?= View::escape(APP_NAME) ?>">
        <span class="brand-mark">S</span>
        <span><?= View::escape(APP_NAME) ?> <small>ADMIN</small></span>
      </a>
      <a class="back-link" href="<?= View::escape(View::url()) ?>">← Trang cửa hàng</a>
    </header>
    <main class="page-container">
      <?= $content ?>
    </main>
    <footer class="site-footer">
      <span>© <?= date('Y') ?> <?= View::escape(APP_NAME) ?> Admin</span>
      <span>Khung quản trị · Giai đoạn 1</span>
    </footer>
  </body>
</html>
