@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-2xl font-bold">Заказ #{{ $order->id }}</h2>
                        <p class="text-gray-600">{{ $order->created_at->format('d.m.Y H:i') }}</p>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-primary">
                            Редактировать
                        </a>
                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Удалить этот заказ?')">
                                Удалить
                            </button>
                        </form>
                        @if($order->status === 'new')
                        <form action="{{ route('orders.complete', $order->id) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="btn btn-success">
                                Завершить
                            </button>
                        </form>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900">Информация о покупателе</h3>
                            <div class="mt-2 space-y-1">
                                <p><span class="font-medium">ФИО:</span> {{ $order->customer_name }}</p>
                                <p><span class="font-medium">Статус:</span> 
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full 
                                        {{ $order->status === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800' }}">
                                        {{ $order->status === 'completed' ? 'Выполнен' : 'Новый' }}
                                    </span>
                                </p>
                                @if($order->comment)
                                <p><span class="font-medium">Комментарий:</span> {{ $order->comment }}</p>
                                @endif
                            </div>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900">Информация о заказе</h3>
                            <div class="mt-2 space-y-1">
                                <p><span class="font-medium">Дата создания:</span> {{ $order->created_at->format('d.m.Y H:i') }}</p>
                                <p><span class="font-medium">Последнее обновление:</span> {{ $order->updated_at->format('d.m.Y H:i') }}</p>
                            </div>
                        </div>
                    </div>

                    <div>
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900">Товар</h3>
                            <div class="mt-2 p-4 border rounded-lg">
                                <p class="font-medium">{{ $order->product->name }}</p>
                                <p class="text-gray-600">{{ $order->product->category->name }}</p>
                                <p class="mt-2"><span class="font-medium">Цена:</span> {{ number_format($order->product->price, 2) }} ₽</p>
                                <p><span class="font-medium">Количество:</span> {{ $order->quantity }}</p>
                                <div class="mt-2 pt-2 border-t">
                                    <p class="font-bold">Итого: {{ number_format($order->total_price, 2) }} ₽</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <a href="{{ route('orders.index') }}" class="btn btn-secondary">
                        Вернуться к списку
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection