<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index() {
        $products = Product::with('user')->get();
        return view('products.index', compact('products'));
    }

    public function create() {
        return view('products.create');
    }

    public function store(Request $request) {
        $data = $request->validate([
            'nombre' => 'required',
            'referencia' => 'required|unique:products',
            'stock_actual' => 'required|integer',
            'stock_minimo' => 'required|integer',
            'fecha_caducidad' => 'nullable|date'
        ]);

        $data['user_id'] = Auth::id();
        $product = Product::create($data);
        $product->verificarStock();

        return redirect()->route('products.index')->with('success', 'Producto creado correctamente');
    }

    public function edit(Product $product) {
        $this->authorize('update', $product);
        return view('products.edit', compact('product'));
    }

    public function update(Request $request, Product $product) {
        $data = $request->validate([
            'stock_minimo' => 'integer|nullable',
            'stock_actual' => 'integer|nullable'
        ]);

        $product->update($data);
        $product->verificarStock();

        return redirect()->route('products.index')->with('success', 'Producto actualizado correctamente');
    }

    public function destroy(Product $product) {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Producto eliminado');
    }
}
