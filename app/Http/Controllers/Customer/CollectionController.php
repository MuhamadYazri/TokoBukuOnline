<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Collection;
use App\Models\Book;
// use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller
{
    /**
     * Tampilkan koleksi buku user
     */
    public function index()
    {
        $collections = Collection::with('book')
            ->where('user_id', Auth::id())
            ->latest()
            ->paginate(12);

        return view('customer.collections.index', compact('collections'));
    }

    /**
     * Tambah buku ke koleksi
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'book_id' => 'required|exists:books,id',
        ]);

        // Cek apakah sudah ada di koleksi
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

        $book = Book::find($validated['book_id']);

        // Log activity
        // ActivityLog::createLog(
        //     Auth::id(),
        //     'add_to_collection',
        //     "Menambahkan buku '{$book->title}' ke koleksi"
        // );

        return back()->with('success', 'Buku berhasil ditambahkan ke koleksi!');
    }

    /**
     * Hapus buku dari koleksi
     */
    public function destroy(collection $collection)
    {
        // Pastikan collection milik user yang login
        if ($collection->user_id !== Auth::id()) {
            abort(403);
        }

        $collection->delete();

        return back()->with('success', 'Buku berhasil dihapus dari koleksi!');
    }
}
