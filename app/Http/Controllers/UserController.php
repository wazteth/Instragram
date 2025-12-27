<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    public function search(Request $request)
{
    $query = $request->input('query');

    $users = User::where('username', 'LIKE', "%{$query}%")
                 ->orWhere('name', 'LIKE', "%{$query}%")
                 ->get();

    return view('search.results', compact('users', 'query'));
}
}
