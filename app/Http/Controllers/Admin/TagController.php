<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagRequest;
use App\Models\Tag;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $tags = Tag::query()->paginate(5);
        return view('admin.tags.index', compact('tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        return view('admin.tags.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreTagRequest $request
     * @return RedirectResponse
     */
    public function store(StoreTagRequest $request)
    {
        Tag::query()->create($request->all());
        $request->session()->flash('success', 'Тэг добавлен');
        return redirect()->route('tags.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $tag = Tag::query()->find($id);
        return view('admin.tags.edit', compact('tag'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StoreTagRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(StoreTagRequest $request, $id)
    {
        $tag = Tag::query()->find($id);
        //$category->slug = null; //если нужно изменить slug. Нежелательное поведение!!! для SEO
        $tag->update($request->all());
        $request->session()->flash('success', 'Тэг успешно изменен');
        return redirect()->route('tags.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $tag = Tag::query()->find($id);
        $tag->delete(); // Первый вариант удаления
        /*Tag::destroy($id); // Второй вариант удаления*/
        return redirect()->route('tags.index');
    }
}
