@extends('layouts.layout', ['title' => $title])

@php
    use Illuminate\Support\Str;
@endphp

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Latest Blog Posts</h1>
    <div class="row g-4">
        @forelse($blogs as $blog)
            <div class="col-md-4">
                <div class="card h-100 shadow-sm">
                    @if($blog->image_url)
                        <img src="{{ asset('storage/' . $blog->image_url) }}" class="card-img-top" alt="{{ $blog->title }}">
                    @endif
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ $blog->title }}</h5>
                        <p class="text-muted mb-2">By {{ $blog->name }} @if($blog->category) • {{ $blog->category->name }} @endif</p>
                        <p class="card-text">{{ Str::limit(strip_tags($blog->content), 120) }}</p>
                        <a href="{{ route('blogs.show', $blog->id) }}" class="btn btn-outline-primary mt-auto">Read More</a>
                    </div>
                </div>
            </div>
        @empty
            <p>No blog posts available yet.</p>
        @endforelse
    </div>
</div>
@endsection
