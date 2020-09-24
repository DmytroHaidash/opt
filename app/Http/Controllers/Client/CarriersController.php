<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Region;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;



class CarriersController extends Controller
{
    public function index(Request $request): View
    {
        $carriers = User::where('role', 'carrier');
        if ($request->filled('search')) {
            $carriers = $carriers->whereRaw('LOWER(name) LIKE "%' . mb_strtolower(request('search')) . '%"')
                ->orWhereRaw('LOWER(surname) LIKE "%' . mb_strtolower(request('search')) . '%"');
        }

        if ($request->filled('region'))
        {
            $carriers->where('car_region', $request->region)->orWhereHas('carrier_regions', function (Builder $builder) use ($request){
                $builder->where('region_id', $request->region);
            })->orWhere('all_region', 1);
        }
        
        $regions = Region::get();
        $articles = Article::latest()->take(3)->get();

        $carriers = $carriers->where('published_carrier', 1)->paginate(24);

        return view('client.carriers.index', compact('carriers', 'articles', 'regions'));
    }

    public function show(User $carrier): View
    {
        $articles = Article::latest()->take(3)->get();

        return view('client.carriers.show', compact('carrier', 'articles'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function search(Request $request): RedirectResponse
    {
        $filled = array_filter($request->except('_token'), function ($key) {
            return $key;
        });

        return redirect(route('client.carriers.index', $filled));
    }
}
