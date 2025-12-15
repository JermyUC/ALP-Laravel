<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'admin'])->except(['publicIndex', 'show']);
    }

    public function index()
    {
        $blogs = Blog::with('category', 'user')->orderByDesc('created_at')->get();
        return view('blogs.index', compact('blogs'));
    }

    public function publicIndex()
    {
        $blogs = Blog::with('category', 'user')->orderByDesc('created_at')->get();

        return view('blog', [
            'title' => 'Blog',
            'blogs' => $blogs,
        ]);
    }

    public function create()
    {
        $categories = Category::all();
        return view('blogs.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
        ]);

        $imagePath = $request->file('image')->store('blogs', 'public');

        Blog::create([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'image_url' => $imagePath,
            'user_id' => $request->user()->id,
            'name' => $validated['name'],
            'category_id' => $validated['category_id'],
        ]);

        return redirect()->route('blogs.index')->with('success', 'Blog created successfully.');
    }

    public function edit(Blog $blog)
    {
        $categories = Category::all();
        return view('blogs.edit', compact('blog', 'categories'));
    }

    public function update(Request $request, Blog $blog)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'content' => 'required|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('blogs', 'public');

            if ($blog->image_url && Storage::disk('public')->exists($blog->image_url)) {
                Storage::disk('public')->delete($blog->image_url);
            }

            $blog->image_url = $imagePath;
        }

        $blog->title = $validated['title'];
        $blog->name = $validated['name'];
        $blog->category_id = $validated['category_id'];
        $blog->content = $validated['content'];
        $blog->save();

        return redirect()->route('blogs.index')->with('success', 'Blog updated successfully.');
    }

    public function destroy(Blog $blog)
    {
        if ($blog->image_url && Storage::disk('public')->exists($blog->image_url)) {
            Storage::disk('public')->delete($blog->image_url);
        }

        $blog->delete();

        return redirect()->route('blogs.index')->with('success', 'Blog deleted successfully.');
    }

    public function show(Blog $blog)
    {
        $contentPreview = Str::words(strip_tags($blog->content), 30, '...');

        return view('blogs.show', [
            'blog' => $blog,
            'title' => $blog->title,
            'description' => $contentPreview,
        ]);
    }
}
