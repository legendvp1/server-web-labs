<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class ArticleController extends Controller
{
    public function index(): View
    {
        $articles = Article::latest()->orderByDesc('id')->paginate(5);

        return view('main', ['articles' => $articles]);
    }

    public function create(): View
    {
        return view('articles.form', ['article' => new Article, 'images' => Article::IMAGES]);
    }

    public function store(Request $request): RedirectResponse
    {
        $article = Article::create($this->validatedArticle($request));

        return redirect()->route('articles.show', $article)->with('status', 'Статья создана.');
    }

    public function show(Article $article): View
    {
        return view('articles.show', ['article' => $article]);
    }

    public function edit(Article $article): View
    {
        return view('articles.form', ['article' => $article, 'images' => Article::IMAGES]);
    }

    public function update(Request $request, Article $article): RedirectResponse
    {
        $article->update($this->validatedArticle($request));

        return redirect()->route('articles.show', $article)->with('status', 'Статья сохранена.');
    }

    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();

        return redirect()->route('articles.index')->with('status', 'Статья удалена.');
    }

    private function validatedArticle(Request $request): array
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'required|string|max:500',
            'content' => 'required|string|max:10000',
            'full_image' => ['required', 'string', Rule::in(array_keys(Article::IMAGES))],
        ], [
            'required' => 'Заполните поле «:attribute».',
            'string' => 'Поле «:attribute» должно содержать текст.',
            'max.string' => 'В поле «:attribute» допускается до :max символов.',
            'full_image.in' => 'Выберите одно из предложенных изображений.',
        ], [
            'title' => 'Название',
            'summary' => 'Краткое описание',
            'content' => 'Текст статьи',
            'full_image' => 'Изображение',
        ]);

        $data['preview_image'] = Article::IMAGES[$data['full_image']];

        return $data;
    }
}
