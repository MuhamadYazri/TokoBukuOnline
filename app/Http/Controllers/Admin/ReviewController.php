<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BookReview;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function index(Request $request)
    {
        $query = BookReview::with(['user', 'book'])
            ->withCount(['likes', 'reports']);

        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('review', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q) use ($search) {
                        $q->where('name', 'like', "%{$search}%");
                    })
                    ->orWhereHas('book', function ($q) use ($search) {
                        $q->where('title', 'like', "%{$search}%");
                    });
            });
        }

        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'most_likes':
                $query->orderBy('likes_count', 'desc');
                break;
            case 'least_likes':
                $query->orderBy('likes_count', 'asc');
                break;
            case 'most_reports':
                $query->orderBy('reports_count', 'desc');
                break;
            case 'least_reports':
                $query->orderBy('reports_count', 'asc');
                break;
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $reviews = $query->paginate(20);

        $totalReviews = BookReview::count();
        $totalLikes = \App\Models\ReviewLike::count();
        $totalReports = \App\Models\ReviewReport::count();
        $reportedReviews = BookReview::has('reports')->count();

        return view('admin.reviews.index', compact(
            'reviews',
            'totalReviews',
            'totalLikes',
            'totalReports',
            'reportedReviews'
        ));
    }

    public function destroy(BookReview $review)
    {
        $review->delete();

        return back()->with('success', 'Review berhasil dihapus!');
    }
}
