<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Author;
use Illuminate\Http\Request;

class AuthorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Author::with('books');

        if ($request->has('search')) {
            $search = $request->input('search');
            $query->whereHas('books', function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%");
            });
        }

        $authors = $query->paginate(10);
        return response()->json($authors);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $author = Author::with('books')->findOrFail($id);
        return response()->json($author);
    }
}
