<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\User;

final class HomeController extends Controller
{
    private Product $productModel;
    private Category $categoryModel;
    private Brand $brandModel;
    private Order $orderModel;
    private User $userModel;
    private ProductVariant $variantModel;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
        $this->brandModel = new Brand();
        $this->orderModel = new Order();
        $this->userModel = new User();
        $this->variantModel = new ProductVariant();
    }

    public function index(): void
    {
        $featuredProducts = $this->productModel->getFeatured(8);
        $categories = $this->categoryModel->getWithCount();
        $brands = $this->brandModel->getActive();

        $this->render('home/index', [
            'title' => 'Trang chủ cửa hàng SoleMate',
            'featuredProducts' => $featuredProducts,
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }

    public function admin(): void
    {
        $totalProducts = $this->productModel->count();
        $totalOrders = $this->orderModel->count();
        $totalUsers = $this->userModel->count();
        $totalRevenue = $this->orderModel->getTotalRevenue();
        $recentOrders = $this->orderModel->getRecent(5);
        $recentProducts = $this->productModel->getAdminList(5);

        $this->render('admin/dashboard', [
            'title' => 'Khu vực quản trị',
            'stats' => [
                'totalProducts' => $totalProducts,
                'totalOrders' => $totalOrders,
                'totalUsers' => $totalUsers,
                'totalRevenue' => $totalRevenue,
            ],
            'recentOrders' => $recentOrders,
            'recentProducts' => $recentProducts,
        ], 'layouts/admin');
    }
}
