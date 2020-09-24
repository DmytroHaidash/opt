<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategorySavingRequest;
use App\Models\Category;
use App\Services\DataTables;
use Exception;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CategoriesController extends Controller
{
    /**
     * @return View
     */
    public function index(): View
    {
        $categories = (new DataTables(Category::where('taxonomy', request('taxonomy'))))
            ->add('title', __('admin.fields.title'))
            ->add('parent_id', __('admin.categories.fields.parent'))
            ->paginate();

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * @return View
     */
    public function create(): View
    {
        return view('admin.categories.create', [
            'categories' => Category::onlyParents(request('taxonomy'))->get()
        ]);
    }

    /**
     * @param CategorySavingRequest $request
     * @return RedirectResponse
     */
    public function store(CategorySavingRequest $request): RedirectResponse
    {
        $category = Category::create($request->only('title', 'description', 'taxonomy', 'parent_id'));

        return redirect(route('admin.categories.edit', [$category, 'taxonomy' => $category->taxonomy]))
            ->with('success', __('admin.messages.created', ['item' => $category->title]));
    }

    /**
     * @param Category $category
     * @return View
     */
    public function edit(Category $category): View
    {
        return view('admin.categories.edit', [
            'category' => $category,
            'categories' => Category::onlyParents($category->taxonomy)->where('id', '!=', $category->id)->get()
        ]);
    }

    /**
     * @param CategorySavingRequest $request
     * @param Category $category
     * @return RedirectResponse
     */
    public function update(CategorySavingRequest $request, Category $category): RedirectResponse
    {
        $category->update($request->only('title', 'description', 'taxonomy', 'parent_id'));

        return back()->with('success', __('admin.messages.updated', ['item' => $category->title]));
    }

    /**
     * @param Category $category
     * @return RedirectResponse
     * @throws Exception
     */
    public function destroy(Category $category): RedirectResponse
    {
        $category->delete();

        return back()->with('success', __('admin.messages.deleted', ['item' => $category->title]));
    }
}
