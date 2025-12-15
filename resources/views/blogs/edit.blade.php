@extends('layouts.admin')

@section('title', 'Edit Blog')

@section('content')
<form action="{{ route('blogs.update', $blog->id) }}" method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')
    <div class="mb-3">
        <label for="title" class="form-label">Title</label>
        <input type="text" class="form-control" id="title" name="title" value="{{ old('title', $blog->title) }}" required>
    </div>

    <div class="mb-3">
        <label for="name" class="form-label">Author Name</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $blog->name) }}" required>
    </div>

    <div class="mb-3">
        <label for="category_id" class="form-label">Category</label>
        <select name="category_id" id="category_id" class="form-select" required>
            @foreach($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $blog->category_id) == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>

    <div class="mb-3">
        <label for="image" class="form-label">Cover Image</label>
        <input type="file" class="form-control" id="image" name="image" accept="image/*">
        @if($blog->image_url)
            <img src="{{ asset('storage/' . $blog->image_url) }}" alt="{{ $blog->title }}" class="img-thumbnail mt-2" style="max-width: 200px;">
        @endif
    </div>

    <div class="mb-3">
        <label for="content" class="form-label">Content</label>
        <textarea class="form-control" id="content" name="content" rows="8" required>{{ old('content', $blog->content) }}</textarea>
    </div>

    <button type="submit" class="btn btn-success">Update Blog</button>
</form>

@push('scripts')
<script src="https://cdn.tiny.cloud/1/no-api-key/tinymce/7/tinymce.min.js" referrerpolicy="origin"></script>
<script>
    tinymce.init({
        selector: '#content',
        plugins: 'link lists image code table media',
        toolbar: 'undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist | link image media | code',
        menubar: false,
        height: 400,
    });
</script>
@endpush
@endsection
