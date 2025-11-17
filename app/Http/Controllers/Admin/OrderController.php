<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    /**
     * Tampilkan semua pesanan
     */
    public function index(Request $request)
    {
        $query = Order::with(['user', 'book']);

        // Filter by status
        if ($request->has('status') && $request->status != 'all') {
            $query->where('status', $request->status);
        }

        // Search by order number or user name
        if ($request->has('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                    ->orWhereHas('user', function ($q2) use ($search) {
                        $q2->where('name', 'like', "%{$search}%");
                    });
            });
        }

        $orders = $query->latest()->paginate(20);

        return view('admin.orders.index', compact('orders'));
    }

    /**
     * Tampilkan detail order
     */
    public function show(Order $order)
    {
        $order->load(['user', 'orderDetails.book', 'book']);
        return view('admin.orders.show', compact('order'));
    }

    /**
     * Update status order
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|in:pending,processing,completed,cancelled',
        ]);

        $oldStatus = $order->status;
        $order->update($validated);

        // Log activity
        ActivityLog::createLog(
            Auth::id(),
            'admin_update_order',
            "Admin mengubah status order #{$order->order_number} dari {$oldStatus} ke {$validated['status']}"
        );

        return back()->with('success', 'Status pesanan berhasil diupdate!');
    }
}
