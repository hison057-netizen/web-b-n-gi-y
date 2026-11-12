<?php

declare(strict_types=1);

use App\Core\View;
?>
<!doctype html>
<html lang="vi">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="Nền tảng cửa hàng giày SoleMate đang được thiết lập.">
    <title><?= View::escape($title ?? APP_NAME) ?> | <?= View::escape(APP_NAME) ?></title>
    <link rel="stylesheet" href="<?= View::escape(View::asset('css/app.css')) ?>">
  </head>
  <body>
    <header class="site-header">
      <a class="brand" href="<?= View::escape(View::url()) ?>" aria-label="<?= View::escape(APP_NAME) ?> trang chủ">
        <span class="brand-mark">S</span>
        <span><?= View::escape(APP_NAME) ?></span>
      </a>
      <span class="environment-badge">ĐANG KHỞI TẠO</span>
    </header>
    <main class="page-container">
      <?= $content ?>
    </main>
    <footer class="site-footer">
      <span>© <?= date('Y') ?> <?= View::escape(APP_NAME) ?></span>
      <span>Website bán giày online</span>
    </footer>
  </body>
</html>
