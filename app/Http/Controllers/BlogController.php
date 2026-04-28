<?php

namespace App\Http\Controllers;

use App\Models\BlogComment;
use App\Models\BlogPost;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BlogController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $user = Auth::user();
        $query = BlogPost::with(['author', 'comments.author']);

        // Students see only published posts
        // Admin and formateur see all posts
        if ($user->role === 'student') {
            $query->where('status', 'published');
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('q')) {
            $query->where(function ($sub) use ($request) {
                $sub->where('title', 'like', '%' . $request->q . '%')
                    ->orWhere('excerpt', 'like', '%' . $request->q . '%')
                    ->orWhere('body', 'like', '%' . $request->q . '%');
            });
        }

        $posts = $query->latest()->get();

        // Calculate metrics based on role
        if ($user->role === 'student') {
            $metrics = [
                'posts' => BlogPost::where('status', 'published')->count(),
                'drafts' => 0,
                'published' => BlogPost::where('status', 'published')->count(),
                'comments' => BlogComment::count(),
            ];
        } else {
            $metrics = [
                'posts' => BlogPost::count(),
                'drafts' => BlogPost::where('status', 'draft')->count(),
                'published' => BlogPost::where('status', 'published')->count(),
                'comments' => BlogComment::count(),
            ];
        }

        $categories = ['education' => 'Education', 'product' => 'Product Updates', 'campus' => 'Student Life'];

        return view('blog-dashboard', [
            'posts' => $posts,
            'metrics' => $metrics,
            'categories' => $categories,
            'selectedCategory' => $request->category,
            'query' => $request->q,
        ]);
    }

    public function create()
    {
        $this->authorize('create', BlogPost::class);

        return view('blog-dashboard-form', [
            'post' => new BlogPost(),
            'categories' => ['education' => 'Education', 'product' => 'Product Updates', 'campus' => 'Student Life'],
        ]);
    }

    public function store(Request $request)
    {
        $this->authorize('create', BlogPost::class);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'body' => 'required|string',
            'category' => 'required|string|in:education,product,campus',
            'status' => 'required|in:draft,published',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            $data['cover_image_path'] = $request->file('cover_image')->store('blog-covers', 'public');
        }

        $data['user_id'] = Auth::id();
        $data['published_at'] = $data['status'] === 'published' ? now() : null;

        BlogPost::create($data);

        return redirect()->route('dashboard.blog.index')->with('success', 'Article enregistré avec succès.');
    }

    public function show(BlogPost $post)
    {
        $user = Auth::user();

        // Students can only view published posts
        if ($user->role === 'student' && $post->status !== 'published') {
            abort(403, 'Unauthorized action.');
        }

        $post->load(['author', 'comments.author']);

        return view('blog-post', ['post' => $post]);
    }

    public function edit(BlogPost $post)
    {
        $this->authorize('update', $post);

        return view('blog-dashboard-form', [
            'post' => $post,
            'categories' => ['education' => 'Education', 'product' => 'Product Updates', 'campus' => 'Student Life'],
        ]);
    }

    public function update(Request $request, BlogPost $post)
    {
        $this->authorize('update', $post);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'required|string|max:500',
            'body' => 'required|string',
            'category' => 'required|string|in:education,product,campus',
            'status' => 'required|in:draft,published',
            'cover_image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('cover_image')) {
            if ($post->cover_image_path) {
                Storage::disk('public')->delete($post->cover_image_path);
            }
            $data['cover_image_path'] = $request->file('cover_image')->store('blog-covers', 'public');
        }

        $data['published_at'] = $data['status'] === 'published' ? now() : null;

        $post->update($data);

        return redirect()->route('dashboard.blog.index')->with('success', 'Article mis à jour avec succès.');
    }

    public function destroy(BlogPost $post)
    {
        $this->authorize('delete', $post);

        if ($post->cover_image_path) {
            Storage::disk('public')->delete($post->cover_image_path);
        }

        $post->delete();

        return redirect()->route('dashboard.blog.index')->with('success', 'Article supprimé.');
    }

    public function storeComment(Request $request, BlogPost $post)
    {
        $user = Auth::user();

        // Students can comment on published posts, admin/formateur on all posts
        if ($user->role === 'student' && $post->status !== 'published') {
            abort(403, 'Unauthorized action.');
        }

        $request->validate([
            'body' => 'required|string|max:1000',
        ]);

        BlogComment::create([
            'blog_post_id' => $post->id,
            'user_id' => $user->id,
            'body' => $request->body,
        ]);

        return redirect()->route('dashboard.blog.show', $post)->with('success', 'Commentaire ajouté.');
    }
}
