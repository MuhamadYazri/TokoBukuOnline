<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\book;
use Illuminate\Http\Request;

class BookController extends Controller
{
    /**
     * Tampilkan daftar buku untuk customer
     */
    public function index(Request $request)
    {
        $query = Book::where('stock', '>', 0);

        // Search
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sort = $request->input('sort', 'latest');
        switch ($sort) {
            case 'price_low':
                $query->orderBy('price', 'asc');
                break;
            case 'price_high':
                $query->orderBy('price', 'desc');
                break;
            case 'title':
                $query->orderBy('title', 'asc');
                break;
            default:
                $query->latest();
        }

        $books = $query->paginate(12);

        return view('customer.books.index', compact('books'));
    }

    /**
     * Tampilkan detail buku
     */
    public function show(book $book)
    {
        // Load reviews dengan user
        $book->load(['reviews' => function ($query) {
            $query->latest()->limit(10);
        }, 'reviews.user']);

        // Buku terkait (same author)
        $relatedBooks = Book::where('author', $book->author)
            ->where('id', '!=', $book->id)
            ->where('stock', '>', 0)
            ->limit(4)
            ->get();

        return view('customer.books.show', compact('book', 'relatedBooks'));
    }
}
