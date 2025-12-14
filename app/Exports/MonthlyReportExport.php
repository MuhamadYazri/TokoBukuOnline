<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class MonthlyReportExport implements FromCollection, WithHeadings, WithMapping, WithStyles, WithTitle
{
    protected $month;
    protected $year;

    public function __construct($month, $year)
    {
        $this->month = $month;
        $this->year = $year;
    }

    public function collection()
    {
        return Order::with(['user', 'orderDetails.book'])
            ->whereYear('created_at', $this->year)
            ->whereMonth('created_at', $this->month)
            ->where('status', 'completed')
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function headings(): array
    {
        return [
            'Order ID',
            'Tanggal',
            'Nama Customer',
            'Email Customer',
            'Total Items',
            'Total Harga',
            'Metode Pembayaran',
            'Status',
        ];
    }

    public function map($order): array
    {
        return [
            $order->order_number,
            $order->created_at->format('Y-m-d H:i'),
            $order->user->name ?? 'Unknown',
            $order->user->email ?? '-',
            $order->orderDetails->sum('quantity'),
            'Rp ' . number_format($order->total_price, 0, ',', '.'),
            ucwords(str_replace('_', ' ', $order->payment_method)),
            ucfirst($order->status),
        ];
    }

    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true, 'size' => 12]],
        ];
    }

    public function title(): string
    {
        return 'Laporan ' . date('F Y', mktime(0, 0, 0, $this->month, 1, $this->year));
    }
}
