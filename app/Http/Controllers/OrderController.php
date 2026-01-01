<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Quotation;
use App\Models\Service;
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

                if ($item->item_type === 'custom') {
                    $type = 'custom';
                    $itemId = null;
                    $specs = [
                        'name'  => $item->item_name,
                        'notes' => $item->notes,
                        'source' => 'custom_quotation'
                    ];
                } else {
                    $type = $item->item_type;
                    $itemId = $item->item_id;
                    $specs = null;
                }


                OrderItem::create([
                    'order_id'   => $order->id,
                    'item_type'  => $type,
                    'item_id'    => $itemId,
                    'quantity'   => $item->quantity,
                    'unit_price' => $item->unit_price,
                    'discount'   => 0,
                    'subtotal'   => $item->subtotal,
                    'specifications' => $specs,
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

        });

        return redirect()
            ->route('order.index')
            ->with('success' , 'Anda telah mengstujui proyek anda harap tunggu pesanan anda selesai Terimakasih :)');
    }

    public function show(Order $order){
        $order->load('items', 'customer');
        return view('general.order.detail' , compact('order'));
    }

    public function index()
    {
        $user = auth()->user();

        if($user->hasRole('customer'))
                    $orders = Order::with([
                'items.product.primaryImage',
                'items.service.primaryImage'
            ])
            ->where('customer_id', $user->id)
            ->latest()
            ->get();
        else {
            $orders = Order::with([
                'items.product.primaryImage',
                'items.service.primaryImage'
            ])
            ->latest()
            ->get();

        }
        $ordersJson = $orders->map(function ($order) {
            return [
                'id'             => $order->id,
                'order_code'     => $order->order_code,
                'total_amount'   => $order->total_amount,
                'order_status'   => $order->order_status,
                'payment_status' => $order->payment_status,
                'items' => $order->items->map(function ($item) {

                    $imagePath = null;

                    if ($item->item_type === 'product') {
                        $imagePath = $item->product?->primaryImage?->file_path;
                    } elseif ($item->item_type === 'service') {
                        $imagePath = $item->service?->primaryImage?->file_path;
                    }

                    return [
                        'id'           => $item->id,
                        'item_type'    => $item->item_type,
                        'item_name'    => $item->item_name,
                        'primaryImage' => $imagePath
                            ? asset('storage/' . $imagePath)
                            : asset('dist/images/profile-15.jpg'),
                    ];
                }),
            ];
        });

        return view('general.order.index', compact('ordersJson'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'item_type'   => 'required|string|in:product,service',
            'item_id'     => 'required|integer',
            'quantity'    => 'required|numeric|min:1',
            'delivery_date'    => 'nullable|date',
            'notes'            => 'nullable|string',
        ]);

        DB::transaction(function () use ($request) {

            if ($request->item_type === 'product') {
                $item = Product::findOrFail($request->item_id);
            } else {
                $item = Service::findOrFail($request->item_id);
            }

            $unitPrice = $item->base_price;
            $majorId   = $item->major_id ?? 1;
            $itemName  = $item->name;

            $subtotal = $unitPrice * $request->quantity;

            // buat order
            $order = Order::create([
                'order_code'       => 'ORD-' . now()->format('Ymd') . '-' . Str::upper(Str::random(4)),
                'customer_id'      => auth()->id(),
                'quotation_id'     => null,
                'major_id'         => $majorId,
                'order_date'       => now(),
                'total_amount'     => $subtotal,
                'payment_status'   => 'pending',
                'order_status'     => 'new',
                'delivery_date'    => $request->delivery_date,
                'notes'            => $request->notes,
            ]);

            OrderItem::create([
                'order_id'       => $order->id,
                'item_type'      => $request->item_type,
                'item_id'        => $request->item_id,
                'quantity'       => $request->quantity,
                'unit_price'     => $unitPrice,
                'discount'       => 0,
                'subtotal'       => $subtotal,
                'specifications' => ['name' => $itemName, 'source' => $request->item_type],
            ]);

            Invoice::create([
                'invoice_number' => 'INV-' . now()->format('Ymd') . '-' . Str::upper(Str::random(4)),
                'order_id'       => $order->id,
                'invoice_date'   => now(),
                'due_date'       => now()->addDays(7),
                'subtotal'       => $subtotal,
                'tax_amount'     => 0,
                'total_amount'   => $subtotal,
                'payment_status' => 'pending',
            ]);
        });

        return redirect()
                ->route('order.index')
                ->with('success', 'Order berhasil dibuat!');
    }

    public function destroy(Order $order)
    {
        if ($order->customer_id !== auth()->id()) {
            abort(403);
        }

        if ($order->order_status !== 'new') {
            return response()->json([
                'message' => 'Pesanan tidak bisa dihapus'
            ], 422);
        }

        $order->delete();

        return response()->json(['success' => true]);
    }


}
