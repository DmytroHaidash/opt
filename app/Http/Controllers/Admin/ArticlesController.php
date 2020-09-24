<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ArticleSavingRequest;
use App\Models\Article;
use App\Services\DataTables;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class ArticlesController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $articles = (new DataTables(Article::query()))
            ->add('title', __('admin.fields.title'))
            ->add('published_at', __('admin.fields.published_at'))
            ->paginate();

        return view('admin.articles.index', compact('articles'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('admin.articles.create');
    }

    /**
     * @param ArticleSavingRequest $request
     * @return RedirectResponse
     */
    public function store(ArticleSavingRequest $request): RedirectResponse
    {
        $article = Article::create($this->handleAttributes($request));

        return redirect(route('admin.articles.edit', $article))
            ->with('success', __('admin.messages.created', ['item' => $article->title]));
    }

    /**
     * @param Article $article
     * @return View
     */
    public function edit(Article $article): View
    {
        return view('admin.articles.edit', compact('article'));
    }

    /**
     * @param ArticleSavingRequest $request
     * @param Article $article
     * @return RedirectResponse
     */
    public function update(ArticleSavingRequest $request, Article $article): RedirectResponse
    {
        $article->update($this->handleAttributes($request));

        return back()->with('success', __('admin.messages.updated', ['item' => $article->title]));
    }

    /**
     * @param Article $article
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Article $article): RedirectResponse
    {
        $article->delete();

        return redirect(route('admin.articles.index'))
            ->with('success', __('admin.messages.deleted', ['item' => $article->title]));
    }

    /**
     * @param ArticleSavingRequest $request
     * @return array
     */
    protected function handleAttributes(ArticleSavingRequest $request): array
    {
        $attributes = $request->only('title', 'description', 'content');

        $attributes['published_at'] = $request->input('is_published')
            ? Carbon::parse($request->input('published_at'))
            : null;

        return $attributes;
    }
}
