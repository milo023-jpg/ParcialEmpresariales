<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Alert;
use App\Models\User;

class AdminDashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'totalProducts' => Product::count(),
            'lowStock' => Product::whereColumn('stock_actual', '<=', 'stock_minimo')->count(),
            'activeAlerts' => Alert::where('estado', 'activa')->count(),
            'totalUsers' => User::count(),
        ]);
    }
}
