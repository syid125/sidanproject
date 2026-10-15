<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    // GET /posts -> daftar artikel
    public function index(): View
    {
        $posts = Post::with('category')->latest()->get();

        return view('posts.index', compact('posts'));
    }

    // GET /posts/create -> form tambah
    public function create(): View
    {
        $categories = Category::orderBy('name')->get();

        return view('posts.create', compact('categories'));
    }

    // POST /posts -> simpan data baru
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        Post::create($validated);

        return redirect()->route('posts.index')
            ->with('success', 'Artikel berhasil ditambahkan.');
    }

    // GET /posts/{post} -> detail artikel
    public function show(Post $post): View
    {
        return view('posts.show', compact('post'));
    }

    // GET /posts/{post}/edit -> form edit
    public function edit(Post $post): View
    {
        $categories = Category::orderBy('name')->get();

        return view('posts.edit', compact('post', 'categories'));
    }

    // PUT/PATCH /posts/{post} -> simpan perubahan
    public function update(Request $request, Post $post): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'required|string',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $post->update($validated);

        return redirect()->route('posts.index')
            ->with('success', 'Artikel berhasil diperbarui.');
    }

    // DELETE /posts/{post} -> hapus
    public function destroy(Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()->route('posts.index')
            ->with('success', 'Artikel berhasil dihapus.');
   
   
   
   
   
            }
}