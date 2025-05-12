<?php

namespace App\Exports;

use App\Models\Order;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrdersExport implements FromCollection, WithHeadings, WithMapping
{
    protected $format;

    public function __construct($format = 'xlsx')
    {
        $this->format = $format;
    }

    public function collection()
    {
        return Order::with(['user', 'items'])->get();
    }

    public function headings(): array
    {
        return [
            'Order ID',
            'Date',
            'Customer Name',
            'Email',
            'Phone',
            'Address',
            'Total Amount',
            'Status',
            'Items',
        ];
    }

    public function map($order): array
    {
        return [
            $order->id,
            $order->created_at->format('Y-m-d H:i:s'),
            $order->user->name,
            $order->user->email,
            $order->user->phone,
            $order->user->address,
            '₱' . number_format($order->total_amount, 2),
            ucfirst($order->status),
            $order->items->map(function($item) {
                return $item->product->title . ' (x' . $item->quantity . ')';
            })->implode(', '),
        ];
    }
} 