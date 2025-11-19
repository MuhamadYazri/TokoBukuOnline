<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    /**
     * Tampilkan dashboard admin dengan statistik
     */
    public function index()
    {
        $stats = $this->getDashboardStats();
        $monthlyTransactions = $this->getMonthlyTransactions();
        $monthlyRevenue = $this->getMonthlyRevenue();
        $bestSellingBooks = $this->getBestSellingBooks(5);

        return view('admin.dashboard');
    }

    public function test()
    {
        return view('admin.dashboard');
    }

    /**
     * Statistik umum dashboard
     */
    private function getDashboardStats()
    {
        return [
            'total_books' => Book::count(),
            'total_customers' => User::where('role', 'customer')->count(),
            'total_orders' => Order::count(),
            'pending_orders' => Order::where('status', 'pending')->count(),
            'completed_orders' => Order::where('status', 'completed')->count(),
            'total_revenue' => Order::where('status', 'completed')->sum('total_price'),
            'revenue_this_month' => Order::where('status', 'completed')
                ->whereMonth('created_at', date('m'))
                ->whereYear('created_at', date('Y'))
                ->sum('total_price'),
        ];
    }

    /**
     * Grafik transaksi bulanan (12 bulan terakhir)
     */
    private function getMonthlyTransactions()
    {
        return Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('COUNT(*) as total_orders')
        )
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
    }

    /**
     * Grafik pendapatan bulanan (12 bulan terakhir)
     */
    private function getMonthlyRevenue()
    {
        return Order::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('YEAR(created_at) as year'),
            DB::raw('SUM(total_price) as revenue')
        )
            ->where('status', 'completed')
            ->where('created_at', '>=', now()->subMonths(12))
            ->groupBy('year', 'month')
            ->orderBy('year', 'asc')
            ->orderBy('month', 'asc')
            ->get();
    }

    /**
     * Buku terlaris
     */
    private function getBestSellingBooks($limit = 10)
    {
        return OrderDetail::select(
            'book_id',
            DB::raw('SUM(quantity) as total_sold'),
            DB::raw('SUM(quantity * price) as total_revenue')
        )
            ->with('book:id,title,author,cover,price') // Eager loading
            ->groupBy('book_id')
            ->orderBy('total_sold', 'DESC')
            ->limit($limit)
            ->get();
    }

    /**
     * API endpoint untuk grafik (AJAX request)
     */
    public function getChartData(Request $request)
    {
        $type = $request->input('type');

        switch ($type) {
            case 'transactions':
                return response()->json($this->getMonthlyTransactions());
            case 'revenue':
                return response()->json($this->getMonthlyRevenue());
            case 'bestsellers':
                return response()->json($this->getBestSellingBooks(10));
            default:
                return response()->json(['error' => 'Invalid type'], 400);
        }
    }
}
