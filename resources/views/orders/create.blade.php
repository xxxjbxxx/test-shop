@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <h2 class="text-2xl font-bold mb-6">Создать новый заказ</h2>

                <form method="POST" action="{{ route('orders.store') }}">
                    @csrf

                    <!-- Поля формы -->
                    <div class="mb-4">
                        <label for="customer_name" class="block text-sm font-medium text-gray-700">ФИО покупателя *</label>
                        <input type="text" name="customer_name" id="customer_name" value="{{ old('customer_name') }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div class="mb-4">
                        <label for="product_id" class="block text-sm font-medium text-gray-700">Товар *</label>
                        <select name="product_id" id="product_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                            <option value="">Выберите товар</option>
                            @foreach($products as $product)
                                <option value="{{ $product->id }}" data-price="{{ $product->price }}"
                                    {{ old('product_id') == $product->id ? 'selected' : '' }}>
                                    {{ $product->name }} ({{ number_format($product->price, 2) }} ₽)
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="quantity" class="block text-sm font-medium text-gray-700">Количество *</label>
                        <input type="number" min="1" name="quantity" id="quantity" value="{{ old('quantity', 1) }}" 
                               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
                    </div>

                    <div class="mb-4 p-4 bg-gray-50 rounded-lg">
                        <h3 class="text-lg font-medium text-gray-900">Стоимость заказа</h3>
                        <div class="mt-2 flex justify-between items-center">
                            <span class="text-gray-600">Цена за единицу:</span>
                            <span id="unit-price" class="font-medium">0.00 ₽</span>
                        </div>
                        <div class="mt-1 flex justify-between items-center">
                            <span class="text-gray-600">Количество:</span>
                            <span id="display-quantity" class="font-medium">1</span>
                        </div>
                        <div class="mt-3 pt-2 border-t border-gray-200 flex justify-between items-center">
                            <span class="text-lg font-bold text-gray-900">Итого:</span>
                            <span id="total-price" class="text-xl font-bold text-indigo-600">0.00 ₽</span>
                        </div>
                    </div>

                    <div class="mb-4">
                        <label for="comment" class="block text-sm font-medium text-gray-700">Комментарий</label>
                        <textarea name="comment" id="comment" rows="3" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('comment') }}</textarea>
                    </div>

                    <div class="flex items-center justify-end mt-6">
                        <a href="{{ route('orders.index') }}" class="btn btn-secondary mr-4">Отмена</a>
                        <button type="submit" class="btn btn-primary">Создать заказ</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const productSelect = document.getElementById('product_id');
    const quantityInput = document.getElementById('quantity');
    const unitPriceElement = document.getElementById('unit-price');
    const displayQuantityElement = document.getElementById('display-quantity');
    const totalPriceElement = document.getElementById('total-price');

    function calculateTotal() {
        const selectedOption = productSelect.options[productSelect.selectedIndex];
        const quantity = parseInt(quantityInput.value) || 0;
        
        if (selectedOption && selectedOption.value) {
            const price = parseFloat(selectedOption.dataset.price);
            const total = price * quantity;
            
            unitPriceElement.textContent = price.toFixed(2) + ' ₽';
            displayQuantityElement.textContent = quantity;
            totalPriceElement.textContent = total.toFixed(2) + ' ₽';
        } else {
            unitPriceElement.textContent = '0.00 ₽';
            displayQuantityElement.textContent = '0';
            totalPriceElement.textContent = '0.00 ₽';
        }
    }

    productSelect.addEventListener('change', calculateTotal);
    quantityInput.addEventListener('input', calculateTotal);
    
    // Инициализация при загрузке
    calculateTotal();
});
</script>
@endsection