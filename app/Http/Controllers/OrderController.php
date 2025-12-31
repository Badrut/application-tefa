<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Quotation;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    public function approve(Request $request , Quotation $quotation){
        if($quotation->status === 'approved') {
            return back()->with('error', 'Quotation sudah di-approve.');
        }

        DB::transaction(function () use ($quotation) {
            $quotation->update([
                'status' => 'approved'
            ]);

            $order = Order::create([
                'order_code'     => 'ORD-' . now()->format('Ymd') . '-' . Str::upper(Str::random(4)),
                'customer_id'    => $quotation->customer_id,
                'quotation_id'   => $quotation->id,
                'major_id'       => $quotation->createdBy->major_id ?? 1,
                'order_date'     => now(),
                'total_amount'   => $quotation->total_amount,
                'payment_status' => 'pending',
                'order_status'   => 'new',
            ]);

            foreach ($quotation->items as $item) {
                OrderItem::create([
                    'order_id'   => $order->id,
                    'item_type'  => $item->item_type,
                    'item_id'    => $item->item_id,
                    'quantity'   => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'discount'   => 0,
                    'subtotal'   => $item->subtotal,
                    'specifications' => null,
                ]);
            }

            Invoice::create([
                'invoice_number' => 'INV-' . now()->format('Ymd') . '-' . Str::upper(Str::random(4)),
                'order_id'       => $order->id,
                'invoice_date'   => now(),
                'due_date'       => now()->addDays(7),
                'subtotal'       => $quotation->total_amount,
                'tax_amount'     => 0,
                'total_amount'   => $quotation->total_amount,
                'payment_status' => 'pending',
            ]);

            return redirect()
                ->route('order.index')
                ->with('success' , 'Anda telah mengstujui proyek anda harap tunggu pesanan anda selesai Terimakasih :)');
        });
    }

    public function index(){
        return view('general.order.index');
    }
}
