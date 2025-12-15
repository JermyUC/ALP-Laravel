@extends('layouts.admin')

@section('title', 'Blogs')

@section('content')
<a href="{{ route('blogs.create') }}" class="btn btn-primary mb-3">Add Blog</a>

<div class="table-responsive">
    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Title</th>
                <th>Author</th>
                <th>Category</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach($blogs as $blog)
            <tr>
                <td>{{ $blog->id }}</td>
                <td>{{ $blog->title }}</td>
                <td>{{ $blog->name }}</td>
                <td>{{ $blog->category->name ?? 'Uncategorized' }}</td>
                <td>{{ $blog->created_at?->format('M d, Y') }}</td>
                <td>
                    <a href="{{ route('blogs.show', $blog->id) }}" class="btn btn-info btn-sm mb-1">View</a>
                    <a href="{{ route('blogs.edit', $blog->id) }}" class="btn btn-warning btn-sm mb-1">Edit</a>
                    <form action="{{ route('blogs.destroy', $blog->id) }}" method="POST" style="display:inline-block;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm mb-1" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
