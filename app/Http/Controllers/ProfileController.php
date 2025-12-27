<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
   public function index(User $user)
{
    // Eager load posts and followers
    $user->load(['posts', 'followers']);

    // Check if current user is already following the profile user
    $alreadyFollowing = auth()->check()
        ? $user->followers->contains('follower_id', auth()->id())
        : false;

    return view('profiles.index', compact('user', 'alreadyFollowing'));
}

    public function edit(User $user)
    {
        if(auth()->id() !== $user->id) {
             abort(403, 'Unauthorized action.');
        }
        
        return view('profiles.edit', compact('user'));
    }
    public function update(Request $request, User $user)
    {
        if(auth()->id() !== $user->id) {
            abort(403, 'Unauthorized action.');
        }

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'bio' => 'nullable|string|max:255',
            'profile_picture' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('profile_picture')) {
            if ($user->profile_picture) {
                Storage::disk('public')->delete($user->profile_picture);
            }
            $imagePath = $request->file('profile_picture')->store('profile', 'public');
            $data['profile_picture'] = $imagePath;
        }

        $user->update($data);

        // return redirect()->route('profile.show', $user);

        // return redirect("/profile/{$user->id}");
        return redirect()->route('profile.show', ['user' => $user->username]);

    }
}
