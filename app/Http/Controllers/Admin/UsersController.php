<?php

namespace App\Http\Controllers\Admin;

use App\Exports\UsersExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\UserSavingRequest;
use App\Models\Region;
use App\Models\User;
use App\Services\DataTables;
use Carbon\Carbon;
use Exception;
use Hash;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist;
use Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Str;

class UsersController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $users = (new DataTables((request()->has('role') ? User::query()->where('role', request('role')) :
            User::query()), ['name', 'email']))
            ->add('name', __('admin.users.fields.name'))
            ->add('phone', __('admin.users.fields.phone'), false)
            ->add('role', __('admin.users.fields.role'))
            ->add('active', __('admin.users.fields.status'))
            ->paginate(25);

        return view('admin.users.index', compact('users'));
    }

    /**
     * @param User $user
     * @return View
     */
    public function show(User $user): View
    {
        return view('admin.users.show', compact('user'));
    }

    /**
     * @return View
     */
    public function create(): View
    {

        return view('admin.users.create', [
            'regions' => Region::get(),
        ]);
    }

    /**
     * @param UserSavingRequest $request
     * @return RedirectResponse
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function store(UserSavingRequest $request): RedirectResponse
    {
        $attributes = $request->only('name', 'surname', 'email', 'role', 'phone','type_car', 'brand_car',
            'tonnage', 'price_km', 'organization', 'car_region', 'worked_region', 'carrier_description');
        $attributes['all_region'] = $request->has('all_region');
        $attributes['password'] = Hash::make($request->input('password'));
        $attributes['published_carrier']= $request->has('published_carrier');

        $user = User::create($attributes);
        $user->carrier_regions()->attach($request->worked_region);
        $this->handleCarrierUploads($request, $user);
        return redirect(route('admin.users.edit', $user));
    }

    /**
     * @param User $user
     * @return View
     */
    public function edit(User $user): View
    {
        $regions = Region::get();
        return view('admin.users.edit', compact('user', 'regions'));
    }

    /**
     * @param UserSavingRequest $request
     * @param User $user
     * @return RedirectResponse
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    public function update(UserSavingRequest $request, User $user): RedirectResponse
    {
        $attributes = $request->only('name', 'surname', 'email', 'role', 'phone', 'type_car', 'brand_car',
            'tonnage', 'price_km', 'organization', 'car_region', 'all_region', 'worked_region', 'carrier_description');
        $attributes['all_region'] = $request->has('all_region');
        $attributes['published_carrier']= $request->has('published_carrier');
        if ($request->has('change_password')) {
            $attributes['password'] = Hash::make($request->input('password'));
        }

        $user->update($attributes);
        $user->carrier_regions()->sync($request->worked_region);
        $this->handleCarrierUploads($request, $user);
        return back()->with('success', __('admin.users.messages.updated'));
    }

    /**
     * @param User $user
     * @return RedirectResponse
     */
    public function access(User $user): RedirectResponse
    {
        $user->active = !$user->active;
        $user->save();

        return back();
    }

    public function export()
    {
        return Excel::download(new UsersExport, 'users-' .Carbon::now(). '.xlsx');
    }

    /**
     * @param User $user
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(User $user): RedirectResponse
    {
        $user->delete();

        return redirect(route('admin.users.index'))->with('success', __('admin.users.messages.deleted'));
    }

    /**
     * @param UserSavingRequest $request
     * @param User $user
     * @throws FileDoesNotExist
     * @throws FileIsTooBig
     */
    protected function handleCarrierUploads(UserSavingRequest $request, User $user): void
    {
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
    }
}
