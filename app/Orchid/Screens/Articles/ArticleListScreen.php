<?php

namespace App\Orchid\Screens\Articles;

use App\Models\Article;
use Orchid\Screen\Actions\Button;
use Orchid\Screen\Actions\DropDown;
use Orchid\Screen\Actions\Link;
use Orchid\Screen\Screen;
use Orchid\Screen\TD;
use Orchid\Support\Facades\Layout;

class ArticleListScreen extends Screen
{
    /**
     * Fetch data to be displayed on the screen.
     *
     * @return array
     */
    public function query(): iterable
    {
        return [
            'articles' => Article::paginate(),
        ];
    }

    /**
     * The name of the screen displayed in the header.
     *
     * @return string|null
     */
    public function name(): ?string
    {
        return 'Управление статьями';
    }

    /**
     * The screen's action buttons.
     *
     * @return \Orchid\Screen\Action[]
     */
    public function commandBar(): iterable
    {
        return [
            Link::make(__('Создать'))
                ->icon('bs.plus-circle')
                ->route('platform.articles.create'),
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
            Layout::table('articles', [
                TD::make('title','Заголовок')
                    ->align(TD::ALIGN_LEFT),
                TD::make('rating','Оценка')
                    ->align(TD::ALIGN_LEFT),
                TD::make(__('Действия'))
                    ->align(TD::ALIGN_CENTER)
                    ->width('100px')
                    ->render(fn (Article $article) => DropDown::make()
                        ->icon('bs.three-dots-vertical')
                        ->list([
                            Link::make(__('Изменить'))
                                ->route('platform.articles.edit', $article->id)
                                ->icon('bs.pencil'),

                            Button::make(__('Удалить'))
                                ->icon('bs.trash3')
                                ->confirm(__('Вы действительно хотите удалить эту статью?'))
                                ->method('delete', [
                                    'id' => $article->id,
                                ]),
                        ])),
            ])
        ];
    }

    public function edit(Article $article)
    {
        return redirect()->route('platform.articles.edit', $article);
    }

    public function delete(Article $article)
    {
        $article->delete();
    }
}
