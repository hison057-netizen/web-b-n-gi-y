<?php

declare(strict_types=1);

use App\Core\View;
?>
<div style="margin-bottom: 28px;">
  <h1 style="font-size: 26px; font-weight: 800; color: #0f172a; margin: 0 0 6px;">Bảng Điều Khiển Quản Trị</h1>
  <div style="font-size: 13px; color: var(--muted);">Thống kê dữ liệu thực tế từ các Model: Product, Order, User</div>
</div>

<!-- Stats Grid từ các Model -->
<div class="stats-grid">
  <div class="stat-card">
    <span class="stat-title">TỔNG DOANH THU</span>
    <span class="stat-value"><?= number_format($stats['totalRevenue'], 0, ',', '.') ?> đ</span>
    <span class="stat-desc">Đơn hàng hoàn tất / đã thanh toán</span>
  </div>
  <div class="stat-card">
    <span class="stat-title">TỔNG ĐƠN HÀNG</span>
    <span class="stat-value"><?= (int)$stats['totalOrders'] ?></span>
    <span class="stat-desc">Truy xuất từ Order Model</span>
  </div>
  <div class="stat-card">
    <span class="stat-title">TỔNG SẢN PHẨM</span>
    <span class="stat-value"><?= (int)$stats['totalProducts'] ?></span>
    <span class="stat-desc">Truy xuất từ Product Model</span>
  </div>
  <div class="stat-card">
    <span class="stat-title">KHÁCH HÀNG</span>
    <span class="stat-value"><?= (int)$stats['totalUsers'] ?></span>
    <span class="stat-desc">Truy xuất từ User Model</span>
  </div>
</div>

<!-- Recent Orders Table -->
<div style="margin-bottom: 40px;">
  <div class="section-header">
    <h2 class="section-title">Đơn Hàng Gần Đây (Order Model)</h2>
  </div>
  <table class="admin-table">
    <thead>
      <tr>
        <th>Mã Đơn</th>
        <th>Khách Hàng</th>
        <th>Số Điện Thoại</th>
        <th>Tổng Tiền</th>
        <th>Thanh Toán</th>
        <th>Trạng Thái</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($recentOrders)): ?>
        <?php foreach ($recentOrders as $order): ?>
          <tr>
            <td><strong><?= View::escape($order['order_code']) ?></strong></td>
            <td><?= View::escape($order['recipient_name']) ?></td>
            <td><?= View::escape($order['recipient_phone']) ?></td>
            <td><strong><?= number_format((float)$order['total_amount'], 0, ',', '.') ?> đ</strong></td>
            <td>
              <span class="status-pill status-<?= View::escape($order['payment_status']) ?>">
                <?= View::escape(strtoupper($order['payment_status'])) ?> (<?= View::escape($order['payment_method']) ?>)
              </span>
            </td>
            <td>
              <span class="status-pill status-<?= View::escape($order['order_status']) ?>">
                <?= View::escape($order['order_status']) ?>
              </span>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="6" style="text-align: center; color: var(--muted);">Chưa có đơn hàng nào</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>

<!-- Products Table -->
<div>
  <div class="section-header">
    <h2 class="section-title">Sản Phẩm Mới Nhất (Product Model)</h2>
    <a href="<?= View::escape(View::url('admin/products')) ?>" style="color: var(--blue); font-size: 13px; font-weight: 600;">Xem tất cả sản phẩm →</a>
  </div>
  <table class="admin-table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Tên Giày</th>
        <th>Thương Hiệu</th>
        <th>Tồn Kho</th>
        <th>Số Biến Thể</th>
        <th>Giá Khởi Điểm</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($recentProducts)): ?>
        <?php foreach ($recentProducts as $prod): ?>
          <tr>
            <td>#<?= (int)$prod['id'] ?></td>
            <td><strong><?= View::escape($prod['name']) ?></strong></td>
            <td><?= View::escape($prod['brand_name'] ?? 'Chưa rõ') ?></td>
            <td><?= (int)$prod['total_stock'] ?> đôi</td>
            <td><?= (int)$prod['variant_count'] ?> size</td>
            <td><?= !empty($prod['min_price']) ? number_format((float)$prod['min_price'], 0, ',', '.') . ' đ' : 'Chưa có' ?></td>
          </tr>
        <?php endforeach; ?>
      <?php else: ?>
        <tr><td colspan="6" style="text-align: center; color: var(--muted);">Chưa có sản phẩm nào</td></tr>
      <?php endif; ?>
    </tbody>
  </table>
</div>
