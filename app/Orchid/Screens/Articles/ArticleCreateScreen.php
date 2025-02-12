<?php

namespace App\Orchid\Screens\Articles;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class ArticleCreateScreen extends Screen
{

    public $article;
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(Article $article): iterable
    {
        return [
            'article' => $article
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Создание статьи';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Button::make('Сохранить')
                ->icon('bs.check-circle')
                ->method('save'),
        ];
    }

    /**
     * The screen's layout elements.
     *
     * @return \Orchid\Screen\Layout[]|string[]
     */
    public function layout(): iterable
    {
        return [
            Layout::rows([
                Input::make('article.title')
                    ->title('Заголовок')
                    ->required()
                    ->placeholder('Введите заголовок статьи'),
                Textarea::make('article.content')
                    ->title('Текст статьи')
                    ->rows(6)
                    ->required()
                    ->placeholder('Введите текст статьи'),
            ])
        ];
    }

    public function save(Article $article, Request $request)
    {
        $validated = $request->validate([
            'article.title' => 'required|string|max:255',
            'article.content' => 'required|string',
            'article.rating' => 'integer|min:0|max:5',
        ]);

        $validated['article']['user_id'] = Auth::id();

        $article->fill($validated['article'])->save();

        Alert::info('Статья сохранена!');
        return redirect()->route('platform.articles');
    }
}
