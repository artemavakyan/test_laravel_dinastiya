<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Article $article)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'content' => 'required|string',
            'rating' => 'integer|min:1|max:5',
        ]);

        $article->comments()->create($validated);
        $article->rating = round($article->comments()->avg('rating'));
        $article->save();

        return redirect()->route('articles.show', $article)->with('success', 'Комментарий добавлен!');
    }
}
