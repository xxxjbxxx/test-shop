@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200 text-center">
                <h2 class="text-2xl font-bold mb-8">Главное меню</h2>
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <a href="{{ route('products.index') }}" 
                       class="block p-6 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                        <h3 class="text-xl font-semibold mb-2">Товары</h3>
                        <p class="text-gray-600">Управление товарами</p>
                    </a>
                    
                    <a href="{{ route('orders.index') }}" 
                       class="block p-6 border border-gray-200 rounded-lg hover:bg-gray-50 transition">
                        <h3 class="text-xl font-semibold mb-2">Заказы</h3>
                        <p class="text-gray-600">Управление заказами</p>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection