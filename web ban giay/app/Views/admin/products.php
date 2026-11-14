<?php

declare(strict_types=1);

use App\Core\View;
?>
<div style="margin-bottom: 28px; display: flex; justify-content: space-between; align-items: center;">
  <div>
    <h1 style="font-size: 26px; font-weight: 800; color: #0f172a; margin: 0 0 6px;">Quản Lý Sản Phẩm</h1>
    <div style="font-size: 13px; color: var(--muted);">Danh sách đầy đủ sản phẩm từ Product Model</div>
  </div>
  <a href="<?= View::escape(View::url('admin')) ?>" style="font-size: 13px; color: var(--blue); font-weight: 600;">← Quay lại Dashboard</a>
</div>

<table class="admin-table">
  <thead>
    <tr>
      <th>ID</th>
      <th>Tên Sản Phẩm</th>
      <th>Thương Hiệu</th>
      <th>Tổng Tồn Kho</th>
      <th>Số Biến Thể</th>
      <th>Giá Thấp Nhất</th>
      <th>Trạng Thái</th>
      <th>Thao Tác</th>
    </tr>
  </thead>
  <tbody>
    <?php if (!empty($products)): ?>
      <?php foreach ($products as $p): ?>
        <tr>
          <td>#<?= (int)$p['id'] ?></td>
          <td><strong><?= View::escape($p['name']) ?></strong></td>
          <td><?= View::escape($p['brand_name'] ?? 'N/A') ?></td>
          <td><?= (int)$p['total_stock'] ?> đôi</td>
          <td><?= (int)$p['variant_count'] ?> size</td>
          <td><strong><?= !empty($p['min_price']) ? number_format((float)$p['min_price'], 0, ',', '.') . ' đ' : 'Liên hệ' ?></strong></td>
          <td><span class="status-pill status-active">Hoạt động</span></td>
          <td>
            <a href="<?= View::escape(View::url('product?id=' . $p['id'])) ?>" target="_blank" style="color: var(--blue); font-weight: 600; font-size: 12px;">Xem ngoài web ↗</a>
          </td>
        </tr>
      <?php endforeach; ?>
    <?php else: ?>
      <tr><td colspan="8" style="text-align: center;">Chưa có sản phẩm</td></tr>
    <?php endif; ?>
  </tbody>
</table>
