@extends('admin.layouts.layout')

@section('content')
    <section class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
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
        <div class="card card-primary">
            <div class="card-header">
                <h3 class="card-title">Редактирование статьи {{ $post->title }}</h3>
            </div>
            <form role="form" method="post" action="{{ route('posts.update', ['post' => $post->id]) }}"
                  enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="card-body">
                    <div class="form-group">
                        <label for="title" class="form-label">Название статьи</label>
                        <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                               name="title" value="{{ $post->title }}">
                    </div>
                    @foreach ($errors->get('title') as $message)
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @endforeach

                    <div class="form-group">
                        <label for="description" class="form-label">Цитата</label>
                        <textarea rows="2" class="form-control @error('description') is-invalid @enderror"
                                  id="description" name="description">{{ $post->description }}</textarea>
                    </div>
                    @foreach ($errors->get('description') as $message)
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @endforeach

                    <div class="form-group">
                        <label for="content" class="form-label">Текст статьи</label>
                        <textarea rows="5" class="form-control @error('content') is-invalid @enderror" id="content"
                                  name="content">{{ $post->content }}</textarea>
                    </div>
                    @foreach ($errors->get('content') as $message)
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @endforeach

                    <div class="form-group">
                        <label for="category_id">Категория</label>
                        <select class="form-control @error('category_id') is-invalid @enderror" id="category_id"
                                name="category_id">
                            <option selected>Выберите категорию</option>
                            @foreach($categories as $key => $value)
                                <option value="{{ $key }}"
                                        @if($key == $post->category_id) selected @endif >{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                    @foreach ($errors->get('category_id') as $message)
                        <div class="alert alert-danger">
                            {{ $message }}
                        </div>
                    @endforeach

                    <div class="form-group">
                        <label for="tags">Тэги</label>
                        <select class="select2" multiple="multiple" data-placeholder="Выберите тэги"
                                style="width: 100%;" id="tags" name="tags[]">
                            @foreach($tags as $key => $value)
                                <option value="{{ $key }}"
                                        @if(in_array($key, $post->tags->pluck('id')->all())) selected @endif>{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="exampleInputFile">Изображение</label>
                        <div class="input-group">
                            <div class="custom-file">
                                <input type="file" class="custom-file-input" id="thumbnail" name="thumbnail">
                                <label class="custom-file-label" for="exampleInputFile">Выберите картинку</label>
                            </div>
                        </div>
                        <div class="mt-3"><img src="{{ $post->image }}" height="150" alt=""></div>
                    </div>
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">Сохранить</button>
                </div>
            </form>
        </div>
    </section>
@endsection
