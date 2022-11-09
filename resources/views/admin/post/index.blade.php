@extends('adminlte::page')

@section('title', 'AdminLTE')

@section('content_header')
    <h1 class="m-0 text-dark">Post</h1>
@stop

@section('content')
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
    <div class="card">
        <div class="card-header">
            <div class="d-flex justify-content-between">
                <h5 class="">Tabel Postingan</h5>
                <a href="{{ url('/admin/posts/create') }}" class="btn btn-primary"><i class="fa-solid fa-plus fa-xs"></i>
                    Tambah</a>
            </div>
        </div>
        <div class="card-body">
            <table class="table table-hover">
                <thead class="thead-dark">
                    <tr>
                        <th scope="col">No</th>
                        <th scope="col">Title</th>
                        <th scope="col">Category</th>
                        <th scope="col">Writer</th>
                        <th scope="col">Date created</th>
                        <th scope="col">Last updated</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    @if ($posts->count() > 0)
                        @foreach ($posts as $post)
                            <tr>
                                <th scope="row">{{ $loop->iteration }}</th>
                                <td>{{ $post->title }}</td>
                                <td>{{ $post->category->name }}</td>
                                <td>{{ $post->user->name }}</td>
                                <td>{{ $post->created_at->format('d M Y') }}</td>
                                <td>{{ $post->updated_at->diffForHumans() }}</td>
                                <td>
                                    <a class="btn" href="{{ url('/admin/posts/' . $post->id . '/edit') }}"
                                        role="button"><i class="fa-solid fa-pen-to-square text-secondary"></i></a>
                                    <button class="btn" onclick="deleteConfirmation(this, {{ $post->id }})"><i
                                            class="fa-solid fa-trash text-secondary"></i></button>
                                </td>
                            </tr>
                        @endforeach
                    @else
                        <tr>
                            <td colspan="7" class="text-center">
                                <p>Belum ada postingan</p>
                            </td>
                        </tr>
                    @endif
                </tbody>
            </table>
        </div>
    </div>
@stop

@section('adminlte_js')
    <script>
        function deleteConfirmation(e, id) {
            Swal.fire({
                title: 'Are you sure?',
                text: "You want to delete this post",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.location.href = `/admin/posts/${id}/delete`
                    // Swal.fire(
                    //     'Deleted!',
                    //     'Your file has been deleted.',
                    //     'success'
                    // )
                } else {
                    return false
                }
            })
        }
    </script>
@endsection
