<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\PageSavingRequest;
use App\Models\Page;
use App\Services\DataTables;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Str;

class PagesController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $pages = (new DataTables(Page::query()))
            ->add('title', __('admin.fields.title'))
            ->paginate();

        return view('admin.pages.index', compact('pages'));
    }

    /**
     * @param Page $page
     * @return View
     */
    public function edit(Page $page): View
    {
        return view('admin.pages.edit', compact('page'));
    }

    /**
     * @param PageSavingRequest $request
     * @param Page $page
     * @return RedirectResponse
     */
    public function update(PageSavingRequest $request, Page $page): RedirectResponse
    {
        $attributes = $request->only('title', 'content');

        if ($request->has('change_slug')) {
            $attributes['slug'] = Str::slug($request->input('slug'));
        }

        $page->update($attributes);

        \Cache::flush();

        return redirect(route('admin.pages.edit', $page))
            ->with('success', __('admin.messages.updated', ['item' => $page->title]));
    }
}
