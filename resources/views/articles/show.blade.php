@extends('layouts.app')

@section('content')
    <div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6">
        <h1 class="text-3xl font-bold text-gray-800">{{ $article->title }}</h1>
        <p class="text-gray-600 mt-2">Автор: <span class="font-medium">{{ $article->author->name }}</span></p>
        <p class="text-gray-600 mt-2">Дата: <span class="font-medium">{{ $article->created_at }}</span></p>
        <div class="flex items-center space-x-1">
            @for ($i = 1; $i <= 5; $i++)
                <span class="{{ $i <= $article->rating ? 'text-yellow-400' : 'text-gray-300' }} text-xl">★</span>
            @endfor
        </div>

        <div class="mt-4 text-gray-700 leading-relaxed">
            {{ $article->content }}
        </div>
    </div>

    <div class="max-w-3xl mx-auto mt-8">
        <h2 class="text-2xl font-bold text-gray-800 mb-4">Комментарии</h2>

        @foreach ($article->comments as $comment)
            <div class="bg-white shadow-sm rounded-lg p-4 mb-4">
                <div class="flex items-center space-x-1">
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="{{ $i <= $article->rating ? 'text-yellow-400' : 'text-gray-300' }} text-xl">★</span>
                    @endfor
                </div>
                <p class="font-semibold text-blue-600">{{ $comment->name }}</p>
                <p class="text-gray-600 mt-2 text-sm">
                    {{ $comment->created_at }}
                </p>
                <p class="text-gray-700 mt-1">{{ $comment->content }}</p>
            </div>
        @endforeach
    </div>

    <div class="max-w-3xl mx-auto mt-8 bg-white shadow-md rounded-lg p-6">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Оставить комментарий</h3>

        <form action="{{ route('comments.store', $article) }}" method="POST" class="space-y-4">
            @csrf
            <input type="text" name="name" placeholder="Ваше имя" required
                   class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">

            <textarea name="content" placeholder="Комментарий" required
                      class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>

            <select name="rating" class="w-full p-2 border border-gray-300 rounded focus:outline-none focus:ring-2 focus:ring-blue-500">
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>

            <button type="submit" class="w-full bg-blue-500 text-white py-2 rounded hover:bg-blue-600 transition">
                Отправить
            </button>
        </form>
    </div>
@endsection


