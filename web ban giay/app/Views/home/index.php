<?php

declare(strict_types=1);

use App\Core\View;
?>
<section class="hero-banner">
  <div class="hero-content">
    <h1>Bước Đi Khác Biệt Cùng SoleMate</h1>
    <p>Khám phá các bộ sưu tập sneaker, giày chạy bộ và giày thời trang chính hãng từ các thương hiệu hàng đầu thế giới.</p>
    <a class="hero-btn" href="<?= View::escape(View::url('products')) ?>">Xem toàn bộ giày →</a>
  </div>
</section>

<!-- Danh mục từ Category Model -->
<section style="margin-bottom: 36px;">
  <div class="section-header">
    <div>
      <h2 class="section-title">Danh Mục Nổi Bật</h2>
      <div class="section-subtitle">Dữ liệu tải từ Category Model</div>
    </div>
  </div>
  <div class="category-chips">
    <a class="chip active" href="<?= View::escape(View::url('products')) ?>">Tất cả danh mục</a>
    <?php foreach ($categories as $cat): ?>
      <a class="chip" href="<?= View::escape(View::url('products?category=' . $cat['id'])) ?>">
        <?= View::escape($cat['name']) ?> (<?= (int)$cat['product_count'] ?>)
      </a>
    <?php endforeach; ?>
  </div>
</section>

<!-- Sản phẩm từ Product Model -->
<section>
  <div class="section-header">
    <div>
      <h2 class="section-title">Sản Phẩm Mới & Nổi Bật</h2>
      <div class="section-subtitle">Tải tự động qua Product Model và Database</div>
    </div>
    <a href="<?= View::escape(View::url('products')) ?>" style="color: var(--blue); font-size: 13px; font-weight: 600;">Xem tất cả →</a>
  </div>

  <div class="product-grid">
    <?php foreach ($featuredProducts as $item): ?>
      <div class="product-card">
        <div class="product-image-wrap">
          <?php if (!empty($item['brand_name'])): ?>
            <span class="brand-tag"><?= View::escape($item['brand_name']) ?></span>
          <?php endif; ?>
          <img
            src="<?= View::escape($item['primary_image'] ?: 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600&auto=format&fit=crop&q=80') ?>"
            alt="<?= View::escape($item['name']) ?>"
            loading="lazy"
          >
        </div>
        <div class="product-body">
          <h3 class="product-name">
            <a href="<?= View::escape(View::url('product?id=' . $item['id'])) ?>"><?= View::escape($item['name']) ?></a>
          </h3>
          <p class="product-desc"><?= View::escape($item['description'] ?? '') ?></p>
          <div class="product-footer">
            <div class="price-wrap">
              <?php if (!empty($item['min_sale_price']) && $item['min_sale_price'] < $item['min_price']): ?>
                <span class="current-price"><?= number_format((float)$item['min_sale_price'], 0, ',', '.') ?> đ</span>
                <span class="original-price"><?= number_format((float)$item['min_price'], 0, ',', '.') ?> đ</span>
              <?php elseif (!empty($item['min_price'])): ?>
                <span class="current-price"><?= number_format((float)$item['min_price'], 0, ',', '.') ?> đ</span>
              <?php else: ?>
                <span class="current-price">Liên hệ</span>
              <?php endif; ?>
            </div>
            <a class="btn-view" href="<?= View::escape(View::url('product?id=' . $item['id'])) ?>">Chi tiết</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>
