<?php

namespace App\Orchid\Screens\Articles;

use App\Models\Article;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Fields\Input;
use Orchid\Screen\Fields\TextArea;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Alert;
use Orchid\Support\Facades\Layout;

class ArticleEditScreen extends Screen
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
            'article' => $article,
            'comments' => $article->comments()->paginate()
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Редактирование статьи';
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

            Button::make('Удалить')
                ->icon('bs.trash3')
                ->confirm('Вы действительно хотите удалить эту статью?')
                ->method('delete'),
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
            ]),
            Layout::table('comments', [
                TD::make('name', 'Имя'),
                TD::make('content', 'Комментарий'),
                TD::make('rating', 'Оценка')
                    ->width('200px')
                    ->render(function (Comment $comment) {
                    return collect(range(1, 5))->map(fn($i) =>
                    $i <= $comment->rating
                        ? '<span style="color: gold; font-size: 16px;">★</span>'
                        : '<span style="color: #ddd; font-size: 16px;">★</span>'
                    )->implode('');
                }),
                TD::make('created_at', 'Дата'),
                TD::make(__('Действия'))
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(fn (Comment $comment) =>
                    Button::make(__('Удалить'))
                        ->icon('bs.trash3')
                        ->confirm(__('Удалить этот комментарий?'))
                        ->method('deleteComment', ['comment' => $comment->id])
                    ),
            ])->title('Комментарии'),
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

    public function delete(Article $article)
    {
        $article->delete();
        Alert::info('Статья удалена!');
        return redirect()->route('platform.articles');
    }

    /**
     * Метод удаления комментария.
     */
    public function deleteComment(Comment $comment)
    {
        $comment->delete();
        Alert::info('Комментарий удален!');
    }
}
