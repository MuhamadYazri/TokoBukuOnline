<?php

namespace App\Http\Controllers;

use App\Models\Book;
use App\Models\Order;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $trendingBooks = Book::withSum('orderDetails as total_order', 'quantity')->get();

        $defaultCategories = Book::getCategories();

        $customCategories = Book::select('category')
            ->whereNotIn('category', array_keys($defaultCategories))
            ->groupBy('category')
            ->pluck('category')
            ->mapWithKeys(function ($category) {
                return [$category => ucwords(str_replace('-', ' ', $category))];
            })
            ->toArray();

        $categories = array_merge($defaultCategories, $customCategories);

        $totalBooks = Book::count();

        $totalBooksSold = Order::sum('total_quantity');

        return view('home', compact(['trendingBooks', 'categories', 'totalBooks', 'totalBooksSold']));
    }
}
