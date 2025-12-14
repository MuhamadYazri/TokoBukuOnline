<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::query();

        $totalBooks = Book::count();
        $totalStock = Book::sum('stock');
        $outOfStock = Book::where('stock', 0)->count();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('author', 'like', "%{$search}%");
            });
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        if ($request->filled('stock_status')) {
            if ($request->stock_status == 'available') {
                $query->where('stock', '>', 0);
            } elseif ($request->stock_status == 'unavailable') {
                $query->where('stock', '=', 0);
            }
        }

        if ($request->filled('filter')) {
            switch ($request->filter) {
                case 'tersedia':
                    $query->where('stock', '>', 0);
                    break;
                case 'tidak_tersedia':
                    $query->where('stock', '=', 0);
                    break;
                case 'stok_terbanyak':
                    $query->orderBy('stock', 'desc');
                    break;
                case 'stok_tersedikit':
                    $query->orderBy('stock', 'asc');
                    break;
            }
        }

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
        } elseif (!$request->filled('filter') || !in_array($request->filter, ['stok_terbanyak', 'stok_tersedikit'])) {
            $query->latest();
        }

        $books = $query->paginate(20);

        return view('admin.books.index', compact('books', 'totalBooks', 'totalStock', 'outOfStock'));
    }

    public function create()
    {
        return view('admin.books.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'category' => 'required|string',
            'new_category' => 'nullable|string|max:255',
            'price' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'cover' => 'nullable|image|mimes:jpeg,jpg,png,webp|max:2048',
            'description' => 'nullable|string',
            'penerbit' => 'nullable|string|max:255',
            'halaman' => 'nullable|integer|min:1',
            'bahasa' => 'nullable|string|max:100',
            'new_language' => 'nullable|string|max:100',
        ]);

        if ($request->category === 'custom' && $request->filled('new_category')) {
            $validated['category'] = $request->new_category;
        }

        if ($request->bahasa === 'custom' && $request->filled('new_language')) {
            $validated['language'] = $request->new_language;
        } elseif ($request->filled('bahasa')) {
            $validated['language'] = $request->bahasa;
        }

        $validated['publisher'] = $request->penerbit;
        $validated['pages'] = $request->halaman;

        if ($request->hasFile('cover')) {
            $validated['cover'] = $request->file('cover')->store('books/covers', 'public');
        }

        $book = Book::create($validated);

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil ditambahkan!');
    }

    public function show(book $book)
    {
        $book->load('reviews.user');
        return view('admin.books.show', compact('book'));
    }

    public function edit(book $book)
    {
        return view('admin.books.edit', compact('book'));
    }

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

        if ($request->hasFile('cover')) {
            if ($book->cover) {
                Storage::disk('public')->delete($book->cover);
            }
            $validated['cover'] = $request->file('cover')->store('books/covers', 'public');
        }

        $book->update($validated);

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil diupdate!');
    }

    public function destroy(book $book)
    {
        if ($book->cover) {
            Storage::disk('public')->delete($book->cover);
        }

        $bookTitle = $book->title;
        $book->delete();

        return redirect()->route('admin.books.index')
            ->with('success', 'Buku berhasil dihapus!');
    }
}
