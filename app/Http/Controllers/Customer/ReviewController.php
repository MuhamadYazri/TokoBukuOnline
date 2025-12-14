<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\BookReview;
use App\Models\ReviewLike;
use App\Models\ReviewReport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request, Book $book)
    {
        $validated = $request->validate([
            'rating' => 'required|integer|min:1|max:5',
            'review' => 'nullable|string|max:1000',
        ]);

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

    public function update(Request $request, BookReview $review)
    {
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

    public function destroy(BookReview $review)
    {
        if ($review->user_id !== Auth::id() && !Auth::user()->isAdmin()) {
            abort(403, 'Unauthorized');
        }

        $review->delete();

        return back()->with('success', 'Review berhasil dihapus!');
    }

    public function like(BookReview $review)
    {
        $existingLike = ReviewLike::where('user_id', Auth::id())
            ->where('book_review_id', $review->id)
            ->first();

        if ($existingLike) {
            return back()->with('info', 'Anda sudah menyukai review ini!');
        }

        ReviewLike::create([
            'user_id' => Auth::id(),
            'book_review_id' => $review->id,
        ]);

        return back()->with('success', 'Review berhasil disukai!');
    }

    public function unlike(BookReview $review)
    {
        $like = ReviewLike::where('user_id', Auth::id())
            ->where('book_review_id', $review->id)
            ->first();

        if (!$like) {
            return back()->with('info', 'Anda belum menyukai review ini!');
        }

        $like->delete();

        return back()->with('success', 'Like berhasil dibatalkan!');
    }

    public function report(Request $request, BookReview $review)
    {
        $validated = $request->validate([
            'reason' => 'nullable|string|max:500',
        ]);

        $existingReport = ReviewReport::where('user_id', Auth::id())
            ->where('book_review_id', $review->id)
            ->first();

        if ($existingReport) {
            return back()->with('info', 'Anda sudah melaporkan review ini!');
        }

        ReviewReport::create([
            'user_id' => Auth::id(),
            'book_review_id' => $review->id,
            'reason' => $validated['reason'] ?? null,
        ]);

        return back()->with('success', 'Review berhasil dilaporkan!');
    }
}
