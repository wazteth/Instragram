<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Story;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;    

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'recent');

         if ($filter === 'popular') {
            $posts = Post::with(['user', 'likes', 'comments'])
                        ->withCount('likes')
                        ->orderBy('likes_count', 'desc')
                        ->latest()
                        ->get();
        } else {
            $posts = Post::with(['user', 'likes', 'comments'])
                        ->latest()
                        ->paginate(10);
        }
        $stories = Story::where('expires_at', '>', now())->with('user')->latest()->get();

        return view('posts.index', compact('posts','stories'));
    }
    
    //will add this later
//     public function loadMorePosts(Request $request)
// {
//     $page = $request->input('page');
//     $posts = Post::with(['user', 'likes', 'comments'])->latest()->paginate(10, ['*'], 'page', $page);
//     return response()->json($posts);
// }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $stories = Story::where('expires_at', '>', now())->with('user')->latest()->get();

        return view('posts.create', compact('stories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'caption' => 'nullable|string|max:255',
        ]);
        $imagePath = $request->file('image')->store('posts', 'public');
        auth()->user()->posts()->create([
            'imagePath' => $imagePath,     
            'imageUrl' => Storage::disk('public')->url($imagePath),       
            'caption' => $data['caption'] ?? null,
        ]);
        
        // return redirect()->route('profile.show', ['user' => auth()->user()->username])->with('success', 'Post created successfully.');
        return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post)
    {
        if (auth()->id() !== $post->user_id) {
            abort('403', 'Unauthorized action.');
        }
        return view('posts.edit', compact('post'));
    }
 
    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Post $post)
    {
        if (auth()->id() !== $post->user_id) {
            abort('403', 'Unauthorized action.');
        }

        $data = $request->validate([    
            'caption' => 'nullable|string|max:255',
        ]);

        $post->update($data);

        return redirect()->route('posts.index')->with('success', 'Post updated successfully.');
    }
  

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post)
    {
        if (auth()->id() !== $post->user_id) {
            abort('403', 'Unauthorized action.');
        }

        // Delete the image file from storage
        
        Storage::disk('public')->delete($post->imagePath);
        // Delete the post
        $post->delete();

        return redirect()->route('posts.index')->with('success', 'Post deleted successfully.');
    }
    
}
