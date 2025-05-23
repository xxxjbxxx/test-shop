@extends('layouts.app')

@section('content')
<div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
            <div class="p-6 bg-white border-b border-gray-200">
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h2 class="text-2xl font-bold">{{ $product->name }}</h2>
                        <p class="text-gray-600">{{ $product->category->name }}</p>
                    </div>
                    <div class="flex space-x-2">
                        <a href="{{ route('products.edit', $product->id) }}" class="btn btn-primary">
                            Редактировать
                        </a>
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Удалить этот товар?')">
                                Удалить
                            </button>
                        </form>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div>
                        @if($product->image_path)
                            <img src="{{ asset('storage/' . $product->image_path) }}" alt="{{ $product->name }}" class="w-full rounded-lg shadow-md">
                        @else
                            <div class="bg-gray-100 h-64 flex items-center justify-center rounded-lg">
                                <span class="text-gray-400">Изображение отсутствует</span>
                            </div>
                        @endif
                    </div>
                    <div>
                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900">Цена</h3>
                            <p class="mt-1 text-2xl font-bold">{{ number_format($product->price, 2) }} ₽</p>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900">Описание</h3>
                            <p class="mt-1 text-gray-600 whitespace-pre-line">{{ $product->description ?? 'Описание отсутствует' }}</p>
                        </div>

                        <div class="mb-6">
                            <h3 class="text-lg font-medium text-gray-900">Информация</h3>
                            <div class="mt-2 grid grid-cols-2 gap-4">
                                <div>
                                    <p class="text-sm text-gray-500">Дата создания</p>
                                    <p class="text-sm">{{ $product->created_at->format('d.m.Y H:i') }}</p>
                                </div>
                                <div>
                                    <p class="text-sm text-gray-500">Дата обновления</p>
                                    <p class="text-sm">{{ $product->updated_at->format('d.m.Y H:i') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="mt-8">
                    <a href="{{ route('products.index') }}" class="btn btn-secondary">
                        Вернуться к списку
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection