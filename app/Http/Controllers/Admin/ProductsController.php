<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\TranslationHelper;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductSavingRequest;
use App\Http\Resources\UnitResource;
use App\Jobs\SendUserProductPublish;
use App\Models\Category;
use App\Models\Product;
use App\Models\Unit;
use App\Services\DataTables;
use Auth;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Str;

class ProductsController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $products = (new DataTables(Product::query()->orderByDesc('published_requested_at')))
            ->add('title', __('admin.fields.title'))
            ->add('user_id', __('admin.fields.created_by'))
            ->add('created_at', __('admin.fields.created_at'))
            ->add('views_count' , __('admin.fields.views_count'))
            ->paginate();

        return view('admin.products.index', compact('products'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        $categories = Category::onlyParents('shop')->get();
        $units = json_encode(UnitResource::collection(Unit::all()));

        return view('admin.products.create', compact('categories', 'units'));
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
            $product->update(['published_at' => Carbon::now()->toDateTimeString()]);
        }
        if($request->has('subcategory')){
            $product->categories()->attach([$request->input('category'), $request->input('subcategory')]);
        }else{
            $product->categories()->attach($request->input('category'));
        }
        $this->handleProductValues($request, $product);

        $this->handleProductUploads($request, $product);

        return redirect(route('admin.products.edit', $product))->with('success', __('admin.messages.created', ['item' => $product->title]));
    }

    /**
     * @param Product $product
     * @return View
     */
    public function edit(Product $product): View
    {
        $product = $product->load('values');
        $categories = Category::onlyParents('shop')->get();
        $units = json_encode(UnitResource::collection(Unit::all()));

        return view('admin.products.edit', compact('product', 'categories', 'units'));
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
            if ($request->has('is_published')) {
                $product->update([
                    'published_at' => Carbon::now()->toDateTimeString(),
                    'is_published' => $request->has('is_published'),
                    'published_requested_at' => null,
                ]);
                if($product->user->hasRole(['buyer', 'seller']))
                {
                    dispatch(new SendUserProductPublish($product));
                }
            } else {
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
        $product->delete();

        return redirect(route('admin.products.index'))->with('success', __('admin.messages.deleted', ['item' => $product->title]));
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
}
