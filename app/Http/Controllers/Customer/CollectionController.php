<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller
{
    public function index()
    {
        $collections = Collection::with('book')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(12);

        return view('customer.collections.index', compact('collections'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id'
        ]);

        $exists = Collection::where('user_id', Auth::id())
            ->where('book_id', $validated['book_id'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'Buku sudah ada di koleksi Anda!');
        }

        Collection::create([
            'user_id' => Auth::id(),
            'book_id' => $validated['book_id'],
        ]);

        return back()->with('success', 'Buku berhasil ditambahkan ke koleksi!');
    }

    public function destroy(Request $request)
    {
        $count = count($request->book_ids);

        foreach ($request->book_ids as $book_id) {
            Collection::where('user_id', Auth::id())->where('book_id', $book_id)->delete();
        }

        return response()->json([
            'message' => 'success',
            'data' => $request->book_ids,
            'toast_message' => "{$count} buku berhasil dihapus dari koleksi!"
        ]);
    }
}
