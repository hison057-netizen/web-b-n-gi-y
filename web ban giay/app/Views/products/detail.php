<?php

declare(strict_types=1);

use App\Core\View;
?>
<div style="margin-bottom: 24px;">
  <a href="<?= View::escape(View::url('products')) ?>" style="color: var(--blue); font-size: 13px; font-weight: 600;">← Quay lại danh sách sản phẩm</a>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 40px; background: #fff; border: 1px solid var(--border); border-radius: 16px; padding: 36px; margin-bottom: 48px;">
  <div>
    <div style="border-radius: 12px; overflow: hidden; height: 380px; background: #f8fafc; margin-bottom: 16px;">
      <img
        src="<?= View::escape($product['primary_image'] ?: 'https://images.unsplash.com/photo-1542291026-7eec264c27ff?w=600&auto=format&fit=crop&q=80') ?>"
        alt="<?= View::escape($product['name']) ?>"
        style="width: 100%; height: 100%; object-fit: cover;"
      >
    </div>
  </div>

  <div>
    <?php if (!empty($product['brand_name'])): ?>
      <span style="display: inline-block; padding: 4px 10px; background: #eff6ff; color: var(--blue); font-size: 12px; font-weight: 700; border-radius: 6px; margin-bottom: 12px;">
        THƯƠNG HIỆU: <?= View::escape($product['brand_name']) ?>
      </span>
    <?php endif; ?>

    <h1 style="font-size: 28px; font-weight: 800; color: #0f172a; margin: 0 0 16px;"><?= View::escape($product['name']) ?></h1>
    <p style="font-size: 14px; color: var(--muted); line-height: 1.7; margin-bottom: 24px;"><?= View::escape($product['description'] ?? '') ?></p>

    <!-- Biến thể size từ ProductVariant Model -->
    <?php if (!empty($variants)): ?>
      <div style="margin-bottom: 24px;">
        <label style="display: block; font-size: 13px; font-weight: 700; margin-bottom: 8px;">Kích cỡ (Size):</label>
        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
          <?php foreach ($variants as $v): ?>
            <button type="button" style="padding: 8px 16px; border: 1px solid var(--border); border-radius: 6px; background: #fff; font-weight: 600; font-size: 13px;">
              Size <?= View::escape($v['size']) ?> (<?= number_format((float)($v['sale_price'] ?? $v['price']), 0, ',', '.') ?>đ)
            </button>
          <?php endforeach; ?>
        </div>
      </div>
    <?php endif; ?>

    <div style="padding-top: 20px; border-top: 1px solid var(--border);">
      <button type="button" style="width: 100%; padding: 14px; background: var(--blue); color: #fff; border: none; border-radius: 8px; font-weight: 700; font-size: 15px; cursor: pointer;">
        Thêm Vào Giỏ Hàng
      </button>
    </div>
  </div>
</div>
