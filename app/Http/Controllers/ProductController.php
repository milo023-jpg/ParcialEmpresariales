<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class ProductController extends Controller
{
    use AuthorizesRequests;
     
    // Mostrar listado de productos
    public function index() {
        $products = Product::with('user')->paginate(10);
        return view('products.index', compact('products'));
    }

    // Mostrar formulario de creación
    public function create() {
        return view('products.create');
    }

    // Guardar nuevo producto
    public function store(Request $request) {
        $data = $request->validate([
            'nombre' => 'required|string|max:255',
            'referencia' => 'required|string|unique:products',
            'stock_actual' => 'required|integer|min:0',
            'stock_minimo' => 'required|integer|min:0', // ✅ Cambiado de stock_minimo_alerta
            'fecha_caducidad' => 'nullable|date'
        ]);

        $data['user_id'] = Auth::id();

        $product = Product::create($data);
        $product->verificarStock(); // Método del modelo para marcar stock crítico si aplica

        return redirect()->route('products.index')->with('success', 'Producto creado correctamente.');
    }

    // Mostrar formulario de edición
    public function edit(Product $product) {
        $this->authorize('update', $product);
        return view('products.edit', compact('product'));
    }

    // Actualizar producto (general)
    public function update(Request $request, Product $product) {
    $data = $request->validate([
        'nombre' => 'required|string|max:255',
        'referencia' => 'required|string|unique:products,referencia,' . $product->id,
        'stock_actual' => 'required|integer|min:0',
        'stock_minimo' => 'required|integer|min:0',
        'fecha_caducidad' => 'nullable|date'
    ]);

    $product->update($data);
    $product->verificarStock();

    return redirect()->route('products.index')->with('success', 'Producto actualizado correctamente.');
}

    // Eliminar producto
    public function destroy(Product $product) {
        $product->delete();
        return redirect()->route('products.index')->with('success', 'Producto eliminado correctamente.');
    }

    // Actualizar solo stock mínimo (desde la tabla)
    public function updateMinStock(Request $request, Product $product) {
        $request->validate([
            'stock_minimo' => 'required|integer|min:0' // ✅ Cambiado
        ]);

        $product->stock_minimo = $request->stock_minimo; // ✅ Cambiado
        $product->save();

        return redirect()->back()->with('success', 'Stock mínimo actualizado.');
    }

    // Registrar salida de inventario
    public function registerOutput(Request $request, Product $product) {
    $request->validate([
        'quantity' => 'required|integer|min:1|max:' . $product->stock_actual
    ]);

    // Se resta la cantidad al stock actual
    $product->stock_actual -= $request->quantity;
    $product->save();

    $product->verificarStock(); // Marca stock crítico si aplica

    return redirect()->back()->with('success', 'Salida registrada correctamente.');
}
}
