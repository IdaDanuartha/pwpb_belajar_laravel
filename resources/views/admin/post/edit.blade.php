@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Edit Post</h1>
@stop

@section('content')
    <div class="row pb-5">
        <div class="col-lg-6 col-12">
            @if (session()->has('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @elseif(session()->has('error'))
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    {{ session('error') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            @endif
            <form action="/admin/posts/{{ $post->id }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <div class="form-group mb-4">
                    <label for="title">Title</label>
                    <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                        name="title" value="{{ old('title', $post->title) }}" placeholder="Masukkan judul postingan">
                    @error('title')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group mb-4">
                    <label for="category_id">Select Category</label>
                    <select class="form-control" id="category_id" name="category_id">
                        @foreach ($categories as $category)
                            @if (old('category_id') == $category->id)
                                <option value="{{ $category->id }}" selected>{{ $category->name }}</option>
                            @else
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endif
                        @endforeach
                    </select>
                </div>
                <div class="form-group mb-4">
                    <label class="d-block">Upload Thumbnail</label>
                    <label for="thumbnail" class="my-4">
                        <img id="img-preview" src="{{ asset('storage/' . $post->thumbnail) }}" width="250"
                            alt="">
                    </label>
                    <input type="file" onchange="previewImg(this)"
                        class="form-control-file @error('thumbnail') is-invalid @enderror" id="thumbnail" name="thumbnail">
                    @error('thumbnail')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>
                <div class="form-group mb-4">
                    <label for="content">Content</label>
                    <textarea class="form-control @error('content') is-invalid @enderror" id="" name="content"
                        placeholder="Tulis konten disini" rows="10">{{ old('content', $post->content) }}</textarea>
                    @error('content')
                        <p class="text-danger">{{ $message }}</p>
                    @enderror
                </div>

                <div>
                    <a href="/admin/posts" class="btn btn-secondary mr-3">Back</a>
                    <button type="submit" class="btn btn-primary">Update Post</button>
                </div>
            </form>
        </div>
    </div>
@stop
