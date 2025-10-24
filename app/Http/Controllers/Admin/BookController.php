<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class BookController extends Controller
{
    public function index()
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        return view('admin.books.index');
    }

    public function show($id)
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        return view('admin.books.show', compact('id'));
    }

    public function discussions($bookId, $chapterId)
    {
        // Check if user is admin
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Unauthorized access');
        }

        return view('admin.books.discussions', compact('bookId', 'chapterId'));
    }
}
