@extends('admin.layouts.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1>Страница постов</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="#">Home</a></li>
                        <li class="breadcrumb-item active">Blank Page</li>
                    </ol>
                </div>
            </div>
        </div>
    </section>

    <section class="content">

        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Title</h3>

                <div class="card-tools">
                    <button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">
                        <i class="fas fa-minus"></i>
                    </button>
                    <button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">
                        <i class="fas fa-times"></i>
                    </button>
                </div>
            </div>
            <div class="card-body">
                <a href="{{ route('posts.create') }}" class="btn btn-primary mb-3">Добавить статью</a>
                @if(count($posts))
                    <table class="table table-bordered">
                        <thead>
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Наименование</th>
                            <th width="50">Изображение</th>
                            <th>Категория</th>
                            <th>Тэги</th>
                            <th>Дата</th>
                            <th style="width: 40px">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($posts as $post)
                            <tr>
                                <td>{{ $post->id }}</td>
                                <td>{{ $post->title }}</td>
                                <td><img src="{{ asset( 'uploads/' . $post->thumbnail ) }}" style="height: 30px" alt=""></td>
                                <td>{{ $post->category ? $post->category->title : '-'}}</td>
                                <td>{{ $post->tags->pluck('title')->join(', ') }}</td>
                                <td>{{ $post->created_at }}</td>
                                <td style="width: 100px">
                                    <a href="{{ route('posts.edit', $post) }}"
                                       class="btn btn-info btn-sm float-left mr-1"><i class="fas fa-pencil-alt"></i></a>
                                    <form action="{{ route('posts.destroy', $post) }}"
                                          method="post" class="float-left">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm"
                                                onclick="return confirm('Подтвердите удаление')"><i
                                                    class="fas fa-trash-alt"></i></button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                @else
                    <p>Статей пока нет</p>
                @endif
            </div>
            <div class="card-footer">
                {{ $posts->links('vendor.pagination.bootstrap-4') }}
            </div>
        </div>
    </section>
@endsection
