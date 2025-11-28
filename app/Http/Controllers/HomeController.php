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

        $categories = Book::getCategories();

        $totalBooks = Book::count();

        $totalBooksSold = Order::sum('total_quantity');

        return view('home', compact(['trendingBooks', 'categories', 'totalBooks', 'totalBooksSold']));
    }
}
