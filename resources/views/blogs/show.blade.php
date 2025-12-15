@extends('layouts.layout', ['title' => $title])

@section('content')
<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-8">
            <h1 class="mb-3">{{ $blog->title }}</h1>
            <p class="text-muted">By {{ $blog->name }} @if($blog->category) • {{ $blog->category->name }} @endif • {{ $blog->created_at?->format('M d, Y') }}</p>
            @if($blog->image_url)
                <img src="{{ asset('storage/' . $blog->image_url) }}" alt="{{ $blog->title }}" class="img-fluid rounded mb-4">
            @endif
            <div class="blog-content">
                {!! $blog->content !!}
            </div>
        </div>
    </div>
</div>
@endsection
