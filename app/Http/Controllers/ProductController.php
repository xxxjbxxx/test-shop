<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Список товаров с пагинацией
     */
    public function index()
    {
        $products = Product::with('category')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('products.index', [
            'products' => $products,
            'categories' => Category::all() // Для фильтрации, если потребуется
        ]);
    }

    /**
     * Форма создания товара
     */
    public function create()
    {
        return view('products.create', [
            'categories' => Category::all()
        ]);
    }

    /**
     * Сохранение нового товара
     */
    public function store(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:products',
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')
            ],
            'price' => 'required|numeric|min:0.01|max:999999.99',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        if ($request->hasFile('image')) {
            $validated['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product = Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with('success', "Товар {$product->name} успешно добавлен");
    }

    /**
     * Просмотр информации о товаре
     */
    public function show(Product $product)
    {
        return view('products.show', compact('product'));
    }

    /**
     * Форма редактирования товара
     */
    public function edit(Product $product)
    {
        return view('products.edit', [
            'product' => $product,
            'categories' => Category::all()
        ]);
    }

    /**
     * Обновление товара
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('products')->ignore($product->id)
            ],
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')
            ],
            'price' => 'required|numeric|min:0.01|max:999999.99',
            'description' => 'nullable|string|max:1000',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048'
        ]);

        // Обработка изображения
        if ($request->hasFile('image')) {
            // Удаляем старое изображение
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $validated['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with('success', "Товар {$product->name} успешно обновлен");
    }

    /**
     * Удаление товара
     */
    public function destroy(Product $product)
    {
        // Удаляем изображение при наличии
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with('success', "Товар {$product->name} успешно удален");
    }
}