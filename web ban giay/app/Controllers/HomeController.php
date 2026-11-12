<?php

declare(strict_types=1);

namespace App\Controllers;

use App\Core\Controller;

final class HomeController extends Controller
{
    public function index(): void
    {
        $this->render('home/index', [
            'title' => 'Nền tảng đang khởi tạo',
        ]);
    }

    public function admin(): void
    {
        $this->render('admin/dashboard', [
            'title' => 'Khu vực quản trị',
        ], 'layouts/admin');
    }
}
