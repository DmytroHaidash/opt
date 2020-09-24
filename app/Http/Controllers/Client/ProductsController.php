<?php

namespace App\Http\Controllers\Client;

use App\Helpers\TranslationHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductSavingRequest;
use App\Http\Resources\UnitResource;
use App\Jobs\SendModeratorProductCreated;
use App\Models\{Article, Category, City, Product, Unit};
use App\Services\DataTables;
use Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Str;

class ProductsController extends Controller
{
    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        if (app('router')->is('client.products.index')) {
            return $this->shopProducts($request);
        }

        return $this->profileProducts($request);
    }

    /**
     * @param Product $product
     * @return View
     */
    public function show(Product $product): View
    {
        $product->handleViewed();
        $articles = Article::latest()->take(3)->get();

        return view('client.products.show', compact('product', 'articles'));
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

        return redirect(route('client.products.index', $filled));
    }

    /**
     * @return View
     * @throws AuthorizationException
     */
    public function create(): View
    {
        $this->authorize('create', Product::class);
        $categories = Category::onlyParents('shop')->get();
        $units = json_encode(UnitResource::collection(Unit::all()));

        return view('client.products.create', compact('categories', 'units'));
    }

    /**
     * @param ProductSavingRequest $request
     * @return RedirectResponse
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function store(ProductSavingRequest $request): RedirectResponse
    {
        /** @var Product $product */
        $product = Auth::user()->products()->create($this->handleProductAttributes($request));
        if ($request->has('is_published')) {
            $product->update(['published_requested_at' => Carbon::now()->toDateTimeString()]);
        }

        if($request->has('subcategory')){
            $product->categories()->attach([$request->input('category'), $request->input('subcategory')]);
        }else{
            $product->categories()->attach($request->input('category'));
        }

        $this->handleProductValues($request, $product);

        $this->handleProductUploads($request, $product);

        Auth::user()->update(['ads_in_day' => (Auth::user()->ads_in_day + 1)]);

        dispatch(new SendModeratorProductCreated($product));

        return redirect(route('client.profile.products.edit', $product))
            ->with('success', __('admin.messages.created', ['item' => $product->title]));
    }

    /**
     * @param Product $product
     * @return View
     * @throws AuthorizationException
     */
    public function edit(Product $product): View
    {
        $this->authorize('update', $product);
        $product = $product->load('values');
        $categories = Category::onlyParents('shop')->get();
        $units = json_encode(UnitResource::collection(Unit::all()));

        return view('client.products.edit', compact('product', 'categories', 'units'));
    }

    /**
     * @param ProductSavingRequest $request
     * @param Product $product
     * @return RedirectResponse
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function update(ProductSavingRequest $request, Product $product): RedirectResponse
    {
        if ($product->is_published != $request->has('is_published')) {
            if($request->has('is_published')){
                $product->update(['published_requested_at' => Carbon::now()->toDateTimeString()]);
            }else{
                $product->update([
                    'is_published' => 0,
                    'published_at' => null,
                    'published_requested_at' => null,
                    ]);
            }
        }

        $product->update($this->handleProductAttributes($request));

        if($request->has('subcategory')){
            $product->categories()->sync([$request->input('category'), $request->input('subcategory')]);
        }else{
            $product->categories()->sync($request->input('category'));
        }

        $this->handleProductValues($request, $product);

        $this->handleProductUploads($request, $product);

        return back()->with('success', __('admin.messages.updated', ['item' => $product->title]));
    }

    /**
     * @param Product $product
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Product $product): RedirectResponse
    {
        $this->authorize('delete', $product);
        $product->delete();

        return redirect(route('client.profile.products.index'))
            ->with('success', __('admin.messages.deleted', ['item' => $product->title]));
    }

    /**
     * @param ProductSavingRequest $request
     * @param Product $product
     */
    protected function handleProductValues(ProductSavingRequest $request, Product $product): void
    {
        $values = [];

        if ($deletions = $request->input('product-deletions')) {
            $product->values()->whereIn('id', explode(',', $deletions))->delete();
        }

        foreach ($items = $request->input('values') as $key => $val) {
            foreach ($items[$key] as $index => $value) {
                $values[$index][$key] = $value;
            }
        }

        foreach ($values as $value) {
            $product->values()->updateOrCreate([
                'id' => $value['id']
            ], $value);
        }
    }

    /**
     * @param ProductSavingRequest $request
     * @param Product $product
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    protected function handleProductUploads(ProductSavingRequest $request, Product $product): void
    {
        if ($deletions = $request->input('media-deletions')) {
            Media::whereIn('id', explode(',', $deletions))->delete();
        }

        if ($request->hasFile('uploads')) {
            foreach ($request->file('uploads') as $media) {
                $product->addMedia($media)
                    ->sanitizingFileName(function ($fileName) {
                        return Str::random(24) . "." . pathinfo($fileName, PATHINFO_EXTENSION);
                    })
                    ->toMediaCollection();
            }
        }

        if ($order = $request->input('media-order')) {
            Media::setNewOrder(array_map('intval', explode(',', $order)));
        }
    }

    /**
     * @param ProductSavingRequest $request
     * @return array
     */
    protected function handleProductAttributes(ProductSavingRequest $request): array
    {
        $attributes = $request->only('latitude', 'longitude', 'address', 'city_id');
        $attributes['has_delivery'] = $request->has('has_delivery');
        $attributes['has_pickup'] = $request->has('has_pickup');
        $attributes['price_arranged'] = $request->has('price_arranged');

        $attributes['title'] = TranslationHelper::columnFill('title', $request->input('title'));
        $attributes['content'] = TranslationHelper::columnFill('content', $request->input('content'));

        return $attributes;
    }

    /**
     * @param Request $request
     * @return View
     */
    protected function shopProducts(Request $request): View
    {
        /** @var Builder $products */
        $products = Product::orderBy('title');

        $categories = Category::onlyParents()->get();
        $articles = Article::latest()->take(3)->get();

        if ($request->filled('city_id')) {
            $products = $products->where('city_id', $request->input('city_id'));
        }

        if ($request->filled('region_id')) {
            $products = $products->whereIn('city_id', City::where('region_id', $request->input('region_id'))->pluck('id'));
        }

        if ($request->filled('category')) {
            $products = $products->whereHas('categories', function (Builder $builder) use ($request) {
                $builder->where('id', $request->input('category'));
            });
        }
        if ($request->filled('subcategory')) {
            $products = $products->whereHas('categories', function (Builder $builder) use ($request) {
                $builder->where('id', $request->input('subcategory  '));
            });
        }

        if ($request->filled('price')) {
            $products = $products->whereHas('values', function (Builder $builder) use ($request) {
                $builder->orderBy('price', $request->input('price'));
            });
        }

        if ($request->filled('search')) {
            $products = $products->whereRaw('LOWER(title) LIKE "%' . mb_strtolower(request('search')) . '%"');
        }

        $products = $products->paginate(24);

        return view('client.products.index', compact('products', 'categories', 'articles'));
    }

    /**
     * @param Request $request
     * @return View
     */
    protected function profileProducts(Request $request): View
    {
        $products = (new DataTables(Product::query()->where('user_id', Auth::user()->id)))
            ->add('title', __('admin.fields.title'))
            ->add('created_at', __('admin.fields.created_at'))
            ->add('views_count' , __('admin.fields.views_count'))
            ->paginate();


        return view('client.products.list', compact('products'));
    }
}
