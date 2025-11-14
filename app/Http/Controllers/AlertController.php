<?php

namespace App\Http\Controllers;

use App\Models\Alert;

class AlertController extends Controller
{
    public function index() {
        $alerts = Alert::with('product')->orderBy('created_at', 'desc')->get();
        return view('alerts.index', compact('alerts'));
    }

    public function show(Alert $alert) {
        return view('alerts.show', compact('alert'));
    }
}
