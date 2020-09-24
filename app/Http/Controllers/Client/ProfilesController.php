<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserUpdatingRequest;
use App\Http\Resources\ImageDisplayResource;
use App\Jobs\SendAdminCarrierUpdated;
use App\Models\Product;
use App\Models\Region;
use App\Models\User;
use Auth;
use Illuminate\Contracts\View\View;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Str;

class ProfilesController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        /** @var User $user */
        $user = Auth::user();
        $avatar = $user->hasMedia('avatar')
            ? json_encode(new ImageDisplayResource(
                $user->getFirstMedia('avatar'), 'large'
            ))
            : '';
        $regions = Region::get();
        return view('client.profile.index', compact('avatar', 'regions'));
    }

    /**
     * @return View
     */
    public function history(): View
    {
        $orders = Auth::user()->orders()->latest()->get();

        return view('client.profile.history', compact('orders'));
    }

    /**
     * @return View
     */
    public function favorites(): View
    {
        $products = Auth::user()->favorites()->whereHasMorph('favoritable',[Product::class])->get();
        $sellers = Auth::user()->favorites()->whereHasMorph('favoritable', [User::class], function ($query) {
            $query->where('role','!=',  'carrier');
        })->get();
        $carriers = Auth::user()->favorites()->whereHasMorph('favoritable', [User::class], function ($query) {
            $query->where('role', 'carrier');
        })->get();


        return \view('client.profile.favorites', compact('products', 'sellers', 'carriers'));
    }

    public function update(UserUpdatingRequest $request)
    {
        /** @var User $user */
        $user = Auth::user();
        $attributes= $request->only('name', 'phone', 'type_car', 'brand_car', 'tonnage', 'price_km',
            'organization', 'car_region', 'worked_region', 'carrier_description');
        $attributes['all_region'] = $request->has('all_region');
        $user->update($attributes);
        $user->carrier_regions()->sync($request->worked_region);
        if ($request->has('image-deletion')) {
            $user->clearMediaCollection('avatar');
        }

        if ($request->hasFile('avatar')) {
            $user->addMediaFromRequest('avatar')
                ->sanitizingFileName(function ($fileName) {
                    return Str::random(24) . "." . pathinfo($fileName, PATHINFO_EXTENSION);
                })
                ->toMediaCollection('avatar');
        }

        if ($deletions = $request->input('media-deletions')) {
            Media::whereIn('id', explode(',', $deletions))->delete();
        }

        if ($request->hasFile('uploads')) {
            foreach ($request->file('uploads') as $media) {
                $user->addMedia($media)
                    ->sanitizingFileName(function ($fileName) {
                        return Str::random(24) . "." . pathinfo($fileName, PATHINFO_EXTENSION);
                    })
                    ->toMediaCollection('carrier');
            }
        }

        if ($order = $request->input('media-order')) {
            Media::setNewOrder(array_map('intval', explode(',', $order)));
        }
        if($user->hasRole('carrier')){
            dispatch(new SendAdminCarrierUpdated($user));
        }
        return back()->with('success', __('profile.messages.updated'));
    }
}
