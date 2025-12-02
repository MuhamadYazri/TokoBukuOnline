<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
// use App\Models\ActivityLog;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Book::query();

        // Search filter
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        // Stock status filter
        if ($request->filled('stock_status')) {
            if ($request->stock_status == 'available') {
                $query->where('stock', '>', 0);
            } elseif ($request->stock_status == 'unavailable') {
                $query->where('stock', '=', 0);
            }
        }

        // Sort filter
        if ($request->filled('sort')) {
            switch ($request->sort) {
                case 'newest':
                    $query->latest();
                    break;
                case 'oldest':
                    $query->oldest();
                    break;
                case 'price_low':
                    $query->orderBy('price', 'asc');
                    break;
                case 'price_high':
                    $query->orderBy('price', 'desc');
                    break;
                case 'most_sold':
                    $query->withCount('orderDetails')
                        ->orderBy('order_details_count', 'desc');
                    break;
                case 'least_sold':
                    $query->withCount('orderDetails')
                        ->orderBy('order_details_count', 'asc');
                    break;
                default:
                    $query->latest();
            }
        } else {
            $query->latest();
        }

        $books = $query->paginate(20);

        return view('admin.books.index', compact('books'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.books.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|in:pengembangan-diri,fiksi,filosofi,psikologi',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'cover' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'description' => 'nullable|string',
        ]);

        // Upload cover image
        if ($request->hasFile('cover')) {


            $validated['cover'] = $request->file('cover')->store('books/covers', 'public');
        }

        $book = Book::create($validated);

        // Log activity
        // ActivityLog::createLog(
        //     Auth::id(),
        //     'admin_create_book',
        //     "Admin membuat buku baru: {$book->title}"
        // );

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(book $book)
    {
        $book->load('reviews.user');
        return view('admin.books.show', compact('book'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(book $book)
    {
        return view('admin.books.edit', compact('book'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, book $book)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'cover' => 'nullable|image|mimes:jpeg,jpg,png|max:2048',
            'description' => 'nullable|string',
        ]);

        // Upload new cover if exists
        if ($request->hasFile('cover')) {
            // Delete old cover
            if ($book->cover) {
                Storage::disk('public')->delete($book->cover);
            }
            $validated['cover'] = $request->file('cover')->store('books/covers', 'public');
        }

        $book->update($validated);

        // Log activity
        // ActivityLog::createLog(
        //     Auth::id(),
        //     'admin_update_book',
        //     "Admin mengupdate buku: {$book->title}"
        // );

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(book $book)
    {
        // Delete cover image
        if ($book->cover) {
            Storage::disk('public')->delete($book->cover);
        }

        $bookTitle = $book->title;
        $book->delete();

        // Log activity
        // ActivityLog::createLog(
        //     Auth::id(),
        //     'admin_delete_book',
        //     "Admin menghapus buku: {$bookTitle}"
        // );

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil dihapus!');
    }
}
