<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Alert;
use App\Models\User;
use Carbon\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $hoy = Carbon::today();
        $limite = Carbon::today()->addDays(7);

        $totalProducts   = Product::count();
        $lowStock        = Product::whereColumn('stock_actual', '<=', 'stock_minimo')->count();
        $nearExpiration  = Product::whereNotNull('fecha_caducidad')
                                ->whereBetween('fecha_caducidad', [$hoy, $limite])
                                ->count();
        $expired         = Product::whereNotNull('fecha_caducidad')
                                ->where('fecha_caducidad', '<', $hoy)
                                ->count();
        $activeAlerts    = Alert::where('estado', 'activa')->count();
        $totalUsers      = User::count();

        // Para mostrar listados cortos en el dashboard
        $criticalProducts = Product::whereColumn('stock_actual', '<=', 'stock_minimo')
                            ->orderBy('stock_actual')
                            ->take(5)
                            ->get();

        $soonToExpire = Product::whereNotNull('fecha_caducidad')
                            ->whereBetween('fecha_caducidad', [$hoy, $limite])
                            ->orderBy('fecha_caducidad')
                            ->take(5)
                            ->get();

        return view('dashboard', compact(
            'totalProducts',
            'lowStock',
            'nearExpiration',
            'expired',
            'activeAlerts',
            'totalUsers',
            'criticalProducts',
            'soonToExpire'
        ));
    }
}
