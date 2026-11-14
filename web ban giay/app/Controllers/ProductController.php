<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;

final class ProductController extends Controller
{
    private Product $productModel;
    private Category $categoryModel;
    private Brand $brandModel;

    public function __construct()
    {
        $this->productModel = new Product();
        $this->categoryModel = new Category();
        $this->brandModel = new Brand();
    }

    public function index(): void
    {
        $products = $this->productModel->getFeatured(20);
        $categories = $this->categoryModel->getActive();
        $brands = $this->brandModel->getActive();

        $this->render('products/index', [
            'title' => 'Tất cả sản phẩm',
            'products' => $products,
            'categories' => $categories,
            'brands' => $brands,
        ]);
    }

    public function detail(): void
    {
        $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
        if (!$id) {
            header('Location: ' . \App\Core\View::url());
            exit;
        }

        $product = $this->productModel->getDetail($id);
        if (!$product) {
            http_response_code(404);
            $this->render('errors/404', ['title' => 'Không tìm thấy sản phẩm']);
            return;
        }

        $variants = $this->productModel->getVariants($id);
        $images = $this->productModel->getImages($id);
        $relatedProducts = $this->productModel->getFeatured(4);

        $this->render('products/detail', [
            'title' => $product['name'],
            'product' => $product,
            'variants' => $variants,
            'images' => $images,
            'relatedProducts' => $relatedProducts,
        ]);
    }

    public function adminIndex(): void
    {
        $products = $this->productModel->getAdminList(50);

        $this->render('admin/products', [
            'title' => 'Quản lý sản phẩm',
            'products' => $products,
        ], 'layouts/admin');
    }
}
