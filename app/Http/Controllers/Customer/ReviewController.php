<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookReview;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    /**
     * Store review baru
     */
    public function store(Request $request, Book $book)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        // Cek apakah user sudah review buku ini
        $existingReview = BookReview::where('user_id', Auth::id())
            ->where('book_id', $book->id)
            ->first();

        if ($existingReview) {
            return back()->with('error', 'Anda sudah memberikan review untuk buku ini!');
        }

        BookReview::create([
            'user_id' => Auth::id(),
            'book_id' => $book->id,
            'rating' => $validated['rating'],
            'review' => $validated['review'],
        ]);

        return back()->with('success', 'Review berhasil ditambahkan!');
    }

    /**
     * Update review
     */
    public function update(Request $request, BookReview $review)
    {
        // Pastikan yang update adalah pemilik review
        if ($review->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }

        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

        $review->update($validated);

        return back()->with('success', 'Review berhasil diupdate!');
    }

    /**
     * Delete review
     */
    public function destroy(BookReview $review)
    {
        // Pastikan yang hapus adalah pemilik review atau admin
        if ($review->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $review->delete();

        return back()->with('success', 'Review berhasil dihapus!');
    }
}
