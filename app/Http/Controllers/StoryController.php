<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Story;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Storage;


class StoryController extends Controller
{
    public function show($id) {
        $story = Story::with('user')
                ->where('expires_at', '>', now())
                ->findOrFail($id);
        return view('stories.show', compact('story'));
    }

    public function store(Request $request) {
        $request->validate(['image' => 'required|image',
                        ]);

        $path = $request->file('image')->store('stories', 'public');

        Story::create([
            'user_id' => auth()->id(),
            'image_path' => $path,
            'expires_at' => now()->addHours(24),
        ]);

        return redirect()->route('home')->with('success', 'Story uploaded successfully!');
    }
}
