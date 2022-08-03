<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCategoriesRequest;
use App\Models\Category;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $categories = Category::query()->paginate(5);
        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('admin.categories.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreCategoriesRequest $request
     * @return RedirectResponse
     */
    public function store(StoreCategoriesRequest $request)
    {
        Category::query()->create($request->all());
        $request->session()->flash('success', 'Категория добавлена');
        return redirect()->route('categories.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $category = Category::query()->find($id);
        return view('admin.categories.edit', compact('category'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreCategoriesRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(StoreCategoriesRequest $request, $id)
    {
        $category = Category::query()->find($id);
        //$category->slug = null; //если нужно изменить slug. Нежелательное поведение!!! для SEO
        $category->update($request->all());
        $request->session()->flash('success', 'Категория успешно изменена');
        return redirect()->route('categories.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        /*$category = Category::query()->find($id);
        $category->delete(); // Первый вариант удаления*/
        Category::destroy($id); // Второй вариант удаления
        return redirect()->route('categories.index');
    }
}
