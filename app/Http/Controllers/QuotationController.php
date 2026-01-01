<?php

namespace App\Http\Controllers;

use App\Models\Consultation;
use App\Models\FileUpload;
use App\Models\Product;
use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\Service;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class QuotationController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->hasRole('customer')) {
            $quotations = Quotation::where('customer_id', auth()->id())
                ->latest()
                ->paginate();
        }
        else if ($user->hasRole('teacher')) {
            $quotations = Quotation::where('created_by', auth()->id())
                ->latest()
                ->paginate();
        }
        else {
            $quotations = Quotation::latest()->paginate();
        }

        return view('general.proyek.index', compact('quotations'));
    }


    public function create()
    {
        $user = auth()->user();
        if ($user->hasRole('teacher')) {
            $consultations = Consultation::where('assigned_teacher_id', $user->teacher->id)
                                        ->where('status', 'open')
                                        ->get();
        } else {
            $consultations = Consultation::where('status', 'open')->get();
        }

        $products = Product::all();
        $services = Service::all();

        return view('general.proyek.create', compact('consultations' , 'products' , 'services'));
    }

    public function store(Request $request)
{


    $validated = $request->validate([
        'consultation_id'      => 'required|exists:consultations,id',
        'valid_until'          => 'nullable|date',

        // items
        'items'                => 'required|array|min:1',
        'items.*.item_type'    => 'required|in:product,service,custom',
        'items.*.product_id' => 'required_if:items.*.item_type,product|nullable|exists:products,id',
        'items.*.service_id' => 'required_if:items.*.item_type,service|nullable|exists:services,id',
        'items.*.item_name'    => 'nullable|string|max:255',
        'items.*.quantity'     => 'required|integer|min:1',
        'items.*.unit_price'   => 'required|numeric|min:0',
        'items.*.notes'        => 'nullable|string|max:500',

        // photos
        'photos'               => 'nullable|array|max:5',
        'photos.*'             => 'image|mimes:jpg,jpeg,png|max:5120',
    ]);

    DB::beginTransaction();
    $storedPaths = [];

    try {

        $consultation = Consultation::findOrFail($validated['consultation_id']);
        $consultation->status = 'in_progress';
        $consultation->save();

        $today = now()->format('Ymd');
        $countToday = Quotation::whereDate('created_at', now())->count() + 1;
        $quotationCode = 'QT-' . $today . '-' . str_pad($countToday, 4, '0', STR_PAD_LEFT);

        // create quotation
        $quotation = Quotation::create([
            'quotation_code' => $quotationCode,
            'consultation_id'=> $consultation->id,
            'customer_id'    => $consultation->customer_id,
            'valid_until'    => $validated['valid_until'] ?? null,
            'status'         => 'draft',
            'created_by'     => Auth::id(),
            'total_amount'   => 0,
        ]);

        $total = 0;

        foreach ($validated['items'] as $item) {
            $subtotal = $item['quantity'] * $item['unit_price'];
            $total += $subtotal;

            $name = $item['item_name'] ?? null;
            if ($item['item_type'] === 'product') {
                $product = Product::findOrFail($item['product_id']);
                $itemId = $product->id;
                $itemName = $product->name;
            }

            if ($item['item_type'] === 'service') {
                $service = Service::findOrFail($item['service_id']);
                $itemId = $service->id;
                $itemName = $service->name;
            }

            if ($item['item_type'] === 'custom') {
                $itemName = $item['item_name'];
            }


            QuotationItem::create([
                'quotation_id' => $quotation->id,
                'item_type'    => $item['item_type'],
                'item_id'      => $itemId,
                'item_name'    => $itemName,
                'quantity'     => $item['quantity'],
                'unit_price'   => $item['unit_price'],
                'subtotal'     => $subtotal,
                'notes'        => $item['notes'] ?? null,
            ]);
        }

        $quotation->update(['total_amount' => $total]);

        // upload photos
        if ($request->hasFile('photos')) {
            $first = true;

            foreach ($request->file('photos') as $file) {
                $path = $file->store('quotations', 'public');
                $storedPaths[] = $path;

                FileUpload::create([
                    'reference_type' => Quotation::class,
                    'reference_id'   => $quotation->id,
                    'file_path'      => $path,
                    'file_name'      => $file->getClientOriginalName(),
                    'file_type'      => 'image',
                    'mime_type'      => $file->getClientMimeType(),
                    'size'           => $file->getSize(),
                    'is_primary'     => $first,
                ]);

                $first = false;
            }
        }

        DB::commit();

        return redirect()
            ->route('proyek.index')
            ->with('success', 'Quotation berhasil dibuat');

    } catch (\Throwable $e) {
        DB::rollBack();

        foreach ($storedPaths as $path) {
            try {
                Storage::disk('public')->delete($path);
            } catch (\Throwable $__e) {}
        }
        dd($e->getMessage());
        Log::error('Quotation store error: '.$e->getMessage());

        return back()
            ->withInput()
            ->with('message', 'Gagal menyimpan quotation: '.$e->getMessage());
    }
}


    public function show(Quotation $quotation)
    {
        $quotation->load(['customer', 'createdBy', 'items']);
        return view('general.proyek.detail', compact('quotation'));
    }

    public function edit(Quotation $quotation)
    {
        $quotation->load('items');
        $user = auth()->user();
        if ($user->hasRole('teacher')) {
            $consultations = Consultation::where('assigned_teacher_id', $user->teacher->id)
                                        ->where('status', 'open')
                                        ->get();
        } else {
            $consultations = Consultation::where('status', 'open')->get();
        }

        $products = Product::all();
        $services = Service::all();
        return view('general.proyek.edit', compact('quotation', 'products' , 'services' , 'consultations'));
    }

public function update(Request $request, Quotation $quotation)
{

    $validated = $request->validate([
        'valid_until'          => 'nullable|date',

        // items
        'items'                => 'required|array|min:1',
        'items.*.item_type'    => 'required|in:product,service,custom',
        'items.*.product_id' => 'required_if:items.*.item_type,product|nullable|exists:products,id',
        'items.*.service_id' => 'required_if:items.*.item_type,service|nullable|exists:services,id',
        'items.*.item_name' => 'required_if:items.*.item_type,custom|nullable|string|max:255',

        'items.*.quantity'     => 'required|integer|min:1',
        'items.*.unit_price'   => 'required|numeric|min:0',
        'items.*.notes'        => 'nullable|string|max:500',

        'photos'               => 'nullable|array|max:5',
        'photos.*'             => 'image|mimes:jpg,jpeg,png|max:5120',

        'delete_images'        => 'nullable|array',
        'delete_images.*'      => 'integer|exists:file_uploads,id',
    ]);
    DB::beginTransaction();
    $storedPaths = [];

    try {
        $quotation->update([
            'valid_until' => $validated['valid_until'] ?? null,
        ]);

        $total = 0;
        $existingItemIds = $quotation->items()->pluck('id')->toArray();
        $incomingItems = $validated['items'];

        QuotationItem::where('quotation_id', $quotation->id)->delete();

        foreach ($incomingItems as $item) {
            $subtotal = $item['quantity'] * $item['unit_price'];
            $total += $subtotal;
            $itemId = null;
            $itemName = null;
            if ($item['item_type'] === 'product') {
                $product = Product::findOrFail($item['product_id']);
                $itemId = $product->id;
                $itemName = $product->name;
            }

            if ($item['item_type'] === 'service') {
                $service = Service::findOrFail($item['service_id']);
                $itemId = $service->id;
                $itemName = $service->name;
            }

            if ($item['item_type'] === 'custom') {
                $itemName = $item['item_name'];
            }

            QuotationItem::create([
                'quotation_id' => $quotation->id,
                'item_type'    => $item['item_type'],
                'item_id'      => $itemId,
                'item_name'    => $itemName,
                'quantity'     => $item['quantity'],
                'unit_price'   => $item['unit_price'],
                'subtotal'     => $subtotal,
                'notes'        => $item['notes'] ?? null,
            ]);

        }

        $quotation->update(['total_amount' => $total]);

        // hapus foto lama jika ada
        if (!empty($validated['delete_images'])) {
            $toDelete = FileUpload::whereIn('id', $validated['delete_images'])->get();
            foreach ($toDelete as $file) {
                Storage::disk('public')->delete($file->file_path);
                $file->delete();
            }
        }

        // upload foto baru
        if ($request->hasFile('photos')) {
            $first = $quotation->files()->count() === 0; // kalau belum ada foto, set primary

            foreach ($request->file('photos') as $file) {
                $path = $file->store('quotations', 'public');
                $storedPaths[] = $path;

                FileUpload::create([
                    'reference_type' => Quotation::class,
                    'reference_id'   => $quotation->id,
                    'file_path'      => $path,
                    'file_name'      => $file->getClientOriginalName(),
                    'file_type'      => 'image',
                    'mime_type'      => $file->getClientMimeType(),
                    'size'           => $file->getSize(),
                    'is_primary'     => $first,
                ]);

                $first = false;
            }
        }

        DB::commit();

        return redirect()
            ->route('proyek.index')
            ->with('success', 'Quotation berhasil diperbarui');

    } catch (\Throwable $e) {
        DB::rollBack();

        foreach ($storedPaths as $path) {
            try {
                Storage::disk('public')->delete($path);
            } catch (\Throwable $__e) {}
        }

        Log::error('Quotation update error: '.$e->getMessage());

        return back()
            ->withInput()
            ->with('message', 'Gagal memperbarui quotation: '.$e->getMessage());
    }
}


    public function destroy(Quotation $quotation)
    {
        $quotation->delete();

        return redirect()
            ->route('proyek.index')
            ->with('success', 'Quotation berhasil dihapus');
    }
}

