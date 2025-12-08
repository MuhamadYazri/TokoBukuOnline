<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

        // Category Filter
        if ($request->has('category') && $request->category != '') {
            $query->where('category', $request->category);
        }

        // Rating Filter
        if ($request->has('rating') && $request->rating != '') {
            $rating = (float) $request->rating;
            $query->whereIn('id', function ($subquery) use ($rating) {
                $subquery->select('book_id')
                    ->from('book_reviews')
                    ->groupBy('book_id')
                    ->havingRaw('AVG(rating) >= ?', [$rating]);
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

        $books = $query->paginate(10);

        return view('customer.books.index', compact('books'));
    }

    /**
     * Tampilkan detail buku
     */
    public function show(Request $request, $id)
    {
        $book = Book::findOrFail($id);

        // Handle review sorting
        $reviewSort = $request->input('review_sort', 'latest');
        $reviewsQuery = $book->reviews()->with('user');

        switch ($reviewSort) {
            case 'oldest':
                $reviewsQuery->oldest();
                break;
            case 'rating_high':
                $reviewsQuery->orderBy('rating', 'desc');
                break;
            case 'rating_low':
                $reviewsQuery->orderBy('rating', 'asc');
                break;
            default: // latest
                $reviewsQuery->latest();
        }

        // Get paginated reviews
        $reviews = $reviewsQuery->paginate(5);

        return view('customer.books.show', compact('book', 'reviews'));
    }

    /**
     * Store a review for a book
     */
    public function storeReview(Request $request, $id)
    {
        $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'required|string|min:10|max:1000',
        ], [
            'rating.required' => 'Rating wajib dipilih',
            'rating.min' => 'Rating minimal 1 bintang',
            'rating.max' => 'Rating maksimal 5 bintang',
            'review.required' => 'Ulasan wajib diisi',
            'review.min' => 'Ulasan minimal 10 karakter',
            'review.max' => 'Ulasan maksimal 1000 karakter',
        ]);

        // Check if user already reviewed this book
        $existingReview = BookReview::where('user_id', Auth::id())
            ->where('book_id', $id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'Anda sudah memberikan ulasan untuk buku ini');
        }

        BookReview::create([
            'user_id' => Auth::id(),
            'book_id' => $id,
            'rating' => $request->rating,
            'review' => $request->review,
        ]);

        return back()->with('success', 'Ulasan berhasil ditambahkan!');
    }
}
