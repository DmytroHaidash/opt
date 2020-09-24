<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(): View
    {
        $articles = Article::latest()->paginate(12);
        $products = Product::latest()->take(4)->get();

        return view('client.news.index', compact('articles', 'products'));
    }

    /**
     * @param Article $article
     * @return View
     */
    public function show(Article $article): View
    {
        $products = Product::latest()->take(4)->get();
        $articles = Article::latest()->where('id', '!=', $article->id)->take(3)->get();

        return view('client.news.show', compact('article', 'products', 'articles'));
    }
}
