<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'book_id',
        'total_quantity',
        'total_price',
        'status',
        'payment_method',
        'payment_status',
        'snap_token',
        'transaction_id',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function book()
    {
        return $this->belongsTo(Book::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }

    public function isPending()
    {
        return $this->status === 'pending';
    }

    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    public function markAsCompleted()
    {
        $this->status = 'completed';
        $this->save();
    }

    public function getTotalAmount()
    {
        return $this->orderDetails()->sum('price');
    }

    /**
     * Check apakah order sudah dibayar
     * Digunakan untuk validasi sebelum redirect ke payment
     */
    public function isPaid()
    {
        return $this->payment_status === 'paid';
    }

    /**
     * Tandai order sebagai sudah dibayar
     * Dipanggil setelah payment berhasil (callback/webhook)
     */
    public function markAsPaid($transactionId = null)
    {
        $this->update([
            'payment_status' => 'paid',
            'status' => 'processing', // Status order berubah dari pending ke processing
            'transaction_id' => $transactionId, // ID transaksi dari Midtrans
            'paid_at' => now(), // Timestamp pembayaran
        ]);
    }

    /**
     * Cancel order dan kembalikan stok
     * Hanya bisa dicancel jika status masih pending
     */
    public function cancel()
    {
        $this->update([
            'status' => 'cancelled',
            'payment_status' => 'failed',
        ]);
    }
}
