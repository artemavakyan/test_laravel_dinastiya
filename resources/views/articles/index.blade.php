@extends('layouts.app')

@section('content')
    <div class="max-w-5xl mx-auto">
        <h1 class="text-3xl font-bold text-center text-gray-800 mb-6">Все статьи</h1>

        <div class="grid grid-cols-3 gap-4">
            @foreach ($articles as $article)
                <div class="bg-white shadow-md rounded-lg p-6 mb-6 hover:shadow-lg transition">
                    <h2 class="text-2xl font-semibold text-blue-600">
                        <a href="{{ route('articles.show', $article) }}" class="hover:underline">{{ $article->title }}</a>
                    </h2>
                    <p class="text-gray-600 text-sm mt-2">Автор: <span class="font-medium">{{ $article->author->name }}</span></p>
                    <p class="text-gray-600 text-sm">Оценка: <span class="font-medium">{{ $article->rating }}/5</span></p>

                    <a href="{{ route('articles.show', $article) }}" class="inline-block mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600 transition">
                        Читать далее
                    </a>
                </div>
            @endforeach
        </div>

    </div>
@endsection
