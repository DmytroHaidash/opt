<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Category;
use App\Models\City;
use App\Models\Page;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class PagesController extends Controller
{
    /**
     * @return View
     */
    public function home(): View
    {
        $categories = Category::onlyParents()->get();
        $cities = City::has('users')->get();

        $products = Product::latest()->paginate(24);
        $articles = Article::latest()->take(3)->get();

        return view('client.home.index', compact('products', 'articles', 'categories', 'cities'));
    }

    /**
     * @param Page $page
     * @return View
     */
    public function show(Page $page): View
    {
        $products = Product::latest()->take(4)->get();
        $articles = Article::latest()->take(3)->get();

        return view('client.pages.default', compact('page', 'products', 'articles'));
    }
}
