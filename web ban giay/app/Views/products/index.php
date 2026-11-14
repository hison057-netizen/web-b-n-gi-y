<?php

declare(strict_types=1);

use App\Core\View;
?>
<section>
  <div class="section-header">
    <div>
      <h1 class="section-title">Tất Cả Sản Phẩm</h1>
      <div class="section-subtitle">Danh sách giày được truy xuất từ Product Model</div>
    </div>
  </div>

  <div class="product-grid">
    <?php foreach ($products as $item): ?>
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
            <a class="btn-view" href="<?= View::escape(View::url('product?id=' . $item['id'])) ?>">Xem chi tiết</a>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</section>
