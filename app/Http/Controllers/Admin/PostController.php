<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Application|Factory|View
     */
    public function index()
    {
        $posts = Post::query()->paginate(5);
        return view('admin.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Application|Factory|View
     */
    public function create()
    {
        $tags = Tag::query()->pluck('title', 'id');
        $categories = Category::query()->pluck('title', 'id');
        return view('admin.posts.create', compact('tags', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StorePostRequest $request
     * @return RedirectResponse
     */
    public function store(StorePostRequest $request)
    {
        $data = $request->all();

        $data['thumbnail'] = Post::uploadImage($request);

        $post = Post::query()->create($data);

        $post->tags()->sync($request->tags);

        $request->session()->flash('success', 'Статья добавлена');
        return redirect()->route('posts.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     * @return Application|Factory|View
     */
    public function edit($id)
    {
        $post = Post::query()->find($id);
        $tags = Tag::query()->pluck('title', 'id');
        $categories = Category::query()->pluck('title', 'id');
        return view('admin.posts.edit', compact('post', 'tags', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StorePostRequest $request
     * @param int $id
     * @return RedirectResponse
     */
    public function update(StorePostRequest $request, $id)
    {
        $post = Post::query()->find($id);

        $data = $request->all();

        $data['thumbnail'] = Post::uploadImage($request, $post->thumbnail);

        /*if ($request->hasFile('thumbnail')) {
            //Storage::disk('public')->delete($post->thumbnail);
            Storage::delete($post->thumbnail);
            $folder = date('Y-m-d');
            $data['thumbnail'] = $request->file('thumbnail')->storeAs("images/{$folder}", $request->file('thumbnail')->getClientOriginalName());
        }*/

        //$category->slug = null; //если нужно изменить slug. Нежелательное поведение!!! для SEO
        $post->update($data);

        $post->tags()->sync($request->tags);

        $request->session()->flash('success', 'Статья успешно изменена');
        return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return RedirectResponse
     */
    public function destroy($id)
    {
        $post = Post::query()->find($id);
        $post->tags()->sync([]);
        Storage::delete($post->thumbnail);
        $post->delete(); // Первый вариант удаления
        /*Post::destroy($id); // Второй вариант удаления*/
        return redirect()->route('posts.index')->with('success', 'Статья удалена');
    }
}
