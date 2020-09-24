<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UnitSavingRequest;
use App\Models\Unit;
use App\Services\DataTables;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class UnitsController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $units = (new DataTables(Unit::query()))
            ->add('name', __('admin.units.fields.name'))
            ->add('nicename', __('admin.units.fields.nicename'))
            ->paginate();

        return view('admin.units.index', compact('units'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('admin.units.create');
    }

    /**
     * @param UnitSavingRequest $request
     * @return RedirectResponse
     */
    public function store(UnitSavingRequest $request): RedirectResponse
    {
        $unit = Unit::create($request->only('name', 'nicename'));

        return redirect(route('admin.units.edit', $unit))
            ->with('success', __('admin.messages.created', ['item' => $unit->nicename]));
    }

    /**
     * @param Unit $unit
     * @return View
     */
    public function edit(Unit $unit): View
    {
        return view('admin.units.edit', compact('unit'));
    }

    /**
     * @param UnitSavingRequest $request
     * @param Unit $unit
     * @return RedirectResponse
     */
    public function update(UnitSavingRequest $request, Unit $unit): RedirectResponse
    {
        $unit->update($request->only('name', 'micename'));

        return back()->with('success', __('admin.messages.updated', ['item' => $unit->nicename]));
    }

    /**
     * @param Unit $unit
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Unit $unit): RedirectResponse
    {
        $unit->delete();

        return back()->with('success', __('admin.messages.deleted', ['item' => $unit->nicename]));
    }
}
