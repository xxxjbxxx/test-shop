<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    /**
     * Список всех заказов с пагинацией
     */
    public function index()
    {
        $orders = Order::with('product')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Форма создания нового заказа
     */
    public function create(Product $product = null)
    {
        $products = Product::all();
        $selectedProduct = $product;

        return view('orders.create', compact('products', 'selectedProduct'));
    }

    /**
     * Сохранение нового заказа
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'comment' => 'nullable|string|max:500',
        ]);

        // Рассчитываем total_price
        $product = Product::find($validated['product_id']);
        $validated['total_price'] = $product->price * $validated['quantity'];
        $validated['status'] = 'new';

        Order::create($validated);

        return redirect()->route('orders.index')
            ->with('success', 'Заказ успешно создан');
       
    }

    /**
     * Форма редактирования заказа
     */
    public function edit(Order $order)
    {
        $products = Product::all();
        return view('orders.edit', compact('order', 'products'));
    }

    /**
     * Обновление заказа
     */
    public function update(Request $request, Order $order)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'product_id' => [
                'required',
                Rule::exists('products', 'id')
            ],
            'quantity' => 'required|integer|min:1',
            'comment' => 'nullable|string|max:500',
            'status' => ['required', Rule::in(['new', 'completed'])],
        ]);

        $order->update($validated);

        return redirect()
            ->route('orders.index')
            ->with('success', "Заказ #{$order->id} успешно обновлен");
    }

    /**
     * Удаление заказа
     */
    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()
            ->route('orders.index')
            ->with('success', "Заказ #{$order->id} успешно удален");
    }

    /**
     * Завершение заказа (изменение статуса)
     */
    public function complete(Order $order)
    {
        $order->update(['status' => 'completed']);

        return redirect()
            ->back()
            ->with('success', "Заказ #{$order->id} отмечен как выполненный");
    }

    /**
     * Просмотр информации о заказе
     */
    public function show(Order $order)
    {
        return view('orders.show', compact('order'));
    }
}