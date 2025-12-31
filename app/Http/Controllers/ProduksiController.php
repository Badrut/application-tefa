<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Major;
use App\Models\Product;
use App\Models\Service;
use App\Models\FileUpload;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ProduksiController extends Controller
{
    public function index(Request $request)
    {
        $user = auth()->user();
        $q = $request->input('q');
        $perPage = (int) $request->input('per_page', 12);

        $productQuery = Product::with('category', 'major', 'primaryImage', 'files');

        if ($user->hasRole('teacher')) {
            $productQuery->where('major_id', $user->teacher->major_id);
        }

        if ($q) {
            $productQuery->where(function($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        $products = $productQuery->orderBy('created_at', 'desc')->paginate($perPage);

        $serviceQuery = Service::with('major', 'primaryImage', 'files');

        if ($user->hasRole('teacher')) {
            $serviceQuery->where('major_id', $user->teacher->major_id);
        }

        if ($q) {
            $serviceQuery->where(function($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        $services = $serviceQuery->orderBy('created_at', 'desc')->paginate($perPage);

        return view('general.produksi.produksi', compact('products', 'services'));
    }

    public function create(){
        $categories = Category::all();
        $majors = Major::all();

        return view('general.produksi.add-product' , compact('categories' , 'majors'));
    }

    public function store(Request $request)
    {

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'base_price' => 'nullable|numeric',
            'unit' => 'nullable|string|max:50',
            'major_id' => 'nullable|exists:majors,id',
            'category_id' => 'nullable|exists:categories,id',
            'is_active' => 'nullable|boolean',
            'photos' => 'nullable|array|max:5',
            'photos.*' => 'image|mimes:jpg,jpeg,png|max:5120',
        ]);
        $data['is_active'] = $request->has('is_active');
        $user = auth()->user();
         if ($user->hasRole('teacher')) {
            $data['major_id'] = $user->teacher->major_id;
        }

        DB::beginTransaction();
        $storedPaths = [];
        try {
            $product = Product::create($data);

            if ($request->hasFile('photos')) {
                $files = $request->file('photos');
                $first = true;
                foreach ($files as $file) {
                    $path = $file->store('products', 'public');
                    $storedPaths[] = $path;

                    FileUpload::create([
                        'reference_type' => Product::class,
                        'reference_id' => $product->id,
                        'file_path' => $path,
                        'file_name' => $file->getClientOriginalName(),
                        'file_type' => 'image',
                        'mime_type' => $file->getClientMimeType(),
                        'size' => $file->getSize(),
                        'is_primary' => $first,
                    ]);

                    $first = false;
                }
            }

            DB::commit();
            return redirect()->route('produksi')->with('success', 'Produk berhasil dibuat');
        } catch (\Throwable $e) {
            DB::rollBack();
            foreach ($storedPaths as $p) {
                try { Storage::disk('public')->delete($p); } catch (\Throwable $__e) {}
            }
            Log::error('Produksi store error: ' . $e->getMessage());
            return back()->withInput()->with('message', 'Gagal menyimpan produk: ' . $e->getMessage());
        }
    }

    public function createService()
    {
        $majors = Major::all();

        return view('general.produksi.add-service', compact('majors'));
    }

    public function storeService(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'base_price' => 'nullable|numeric',
            'unit' => 'nullable|string|max:50',
            'major_id' => 'nullable|exists:majors,id',
            'service_level' => 'nullable|string|max:100',
            'estimated_hours' => 'nullable|numeric',
            'is_active' => 'nullable|boolean',
            'photos' => 'nullable|array|max:5',
            'photos.*' => 'image|mimes:jpg,jpeg,png|max:5120',
        ]);
        $data['is_active'] = $request->has('is_active');
        $user = auth()->user();
         if ($user->hasRole('teacher')) {
            $data['major_id'] = $user->teacher->major_id;
        }
        DB::beginTransaction();
        $storedPaths = [];
        try {
            $service = Service::create($data);

            if ($request->hasFile('photos')) {
                $files = $request->file('photos');
                $first = true;
                foreach ($files as $file) {
                    $path = $file->store('services', 'public');
                    $storedPaths[] = $path;

                    FileUpload::create([
                        'reference_type' => Service::class,
                        'reference_id' => $service->id,
                        'file_path' => $path,
                        'file_name' => $file->getClientOriginalName(),
                        'file_type' => 'image',
                        'mime_type' => $file->getClientMimeType(),
                        'size' => $file->getSize(),
                        'is_primary' => $first,
                    ]);

                    $first = false;
                }
            }

            DB::commit();
            return redirect()->route('produksi')->with('success', 'Jasa berhasil dibuat');
        } catch (\Throwable $e) {
            DB::rollBack();
            foreach ($storedPaths as $p) {
                try { Storage::disk('public')->delete($p); } catch (\Throwable $__e) {}
            }
            dd($e->getMessage());
            Log::error('Produksi storeService error: ' . $e->getMessage());
            return back()->withInput()->with('message', 'Gagal menyimpan service: ' . $e->getMessage());
        }
    }

    public function showService($id)
    {
        $service = Service::with('files', 'major')->findOrFail($id);
        return view('general.produksi.detail-service', compact('service'));
    }

    public function editService($id)
    {
        $service = Service::with('files', 'major')->findOrFail($id);
        $majors = Major::all();

        return view('general.produksi.edit-service', compact('service', 'majors'));
    }

    public function updateService(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'base_price' => 'nullable|numeric',
            'unit' => 'nullable|string|max:50',
            'major_id' => 'nullable|exists:majors,id',
            'service_level' => 'nullable|string|max:100',
            'estimated_hours' => 'nullable|numeric',
            'is_active' => 'nullable|boolean',
            'photos' => 'nullable|array|max:5',
            'photos.*' => 'image|mimes:jpg,jpeg,png|max:5120',
        ]);

        $service = Service::findOrFail($id);
        $data['is_active'] = $request->has('is_active');
        $user = auth()->user();
         if ($user->hasRole('teacher')) {
            $data['major_id'] = $user->teacher->major_id;
        }
        DB::beginTransaction();
        $storedPaths = [];
        try {
            $service->update($data);

            if ($request->hasFile('photos')) {
                $files = $request->file('photos');
                $existingCount = $service->files()->count();
                $hasPrimary = $service->files()
                    ->where('is_primary', true)
                    ->exists();

                foreach ($files as $idx => $file) {
                    if ($existingCount + $idx >= 5) break;

                    $path = $file->store('services', 'public');
                    $storedPaths[] = $path;

                    FileUpload::create([
                        'reference_type' => Service::class,
                        'reference_id'   => $service->id,
                        'file_path'      => $path,
                        'file_name'      => $file->getClientOriginalName(),
                        'file_type'      => 'image',
                        'mime_type'      => $file->getClientMimeType(),
                        'size'           => $file->getSize(),
                        'is_primary'     => !$hasPrimary && $idx === 0,
                    ]);
                    $hasPrimary = true;
                }
            }

            DB::commit();
            return redirect()->route('produksi')->with('success', 'Service berhasil diperbarui');
        } catch (\Throwable $e) {
            DB::rollBack();
            foreach ($storedPaths as $p) {
                try { Storage::disk('public')->delete($p); } catch (\Throwable $__e) {}
            }
            Log::error('Produksi updateService error: ' . $e->getMessage());
            return back()->withInput()->with('message', 'Gagal memperbarui service: ' . $e->getMessage());
        }
    }

    public function destroyService($id)
    {
        $service = Service::with('files')->findOrFail($id);

        DB::beginTransaction();
        try {
            foreach ($service->files as $f) {
                if ($f->file_path) {
                    Storage::disk('public')->delete($f->file_path);
                }
                $f->delete();
            }

            $service->delete();

            DB::commit();
            return response()->json(['message' => 'Service dihapus'], 200);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Produksi destroyService error: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal menghapus service'], 500);
        }
    }

    public function show($id){
        $product = Product::with('files', 'category', 'major')->findOrFail($id);
        return view('general.produksi.detail-product' , compact('product'));
    }

    public function edit($id)
    {
        $product = Product::with('files', 'category', 'major')->findOrFail($id);
        $categories = Category::all();
        $majors = Major::all();

        return view('general.produksi.edit-product', compact('product', 'categories', 'majors'));
    }

    public function update(Request $request, $id)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'code' => 'nullable|string|max:100',
            'description' => 'nullable|string',
            'base_price' => 'nullable|numeric',
            'unit' => 'nullable|string|max:50',
            'major_id' => 'nullable|exists:majors,id',
            'category_id' => 'nullable|exists:categories,id',
            'is_active' => 'nullable|boolean',
            'photos' => 'nullable|array|max:5',
            'photos.*' => 'image|mimes:jpg,jpeg,png|max:5120',
        ]);
        $product = Product::findOrFail($id);
        $data['is_active'] = $request->has('is_active');
        $user = auth()->user();
         if ($user->hasRole('teacher')) {
            $data['major_id'] = $user->teacher->major_id;
        }
        DB::beginTransaction();
        $storedPaths = [];
        try {
            $product->update($data);

            if ($request->hasFile('photos')) {
                $files = $request->file('photos');
                $existingCount = $product->files()->count();
                $hasPrimary = $product->files()
                    ->where('is_primary', true)
                    ->exists();

                foreach ($files as $idx => $file) {
                    if ($existingCount + $idx >= 5) break;

                    $path = $file->store('products', 'public');
                    $storedPaths[] = $path;

                    FileUpload::create([
                        'reference_type' => Product::class,
                        'reference_id'   => $product->id,
                        'file_path'      => $path,
                        'file_name'      => $file->getClientOriginalName(),
                        'file_type'      => 'image',
                        'mime_type'      => $file->getClientMimeType(),
                        'size'           => $file->getSize(),
                        'is_primary'     => !$hasPrimary && $idx === 0,
                    ]);
                    $hasPrimary = true;
                }
            }

            DB::commit();
            return redirect()->route('produksi')->with('success', 'Produk berhasil diperbarui');
        } catch (\Throwable $e) {
            DB::rollBack();
            foreach ($storedPaths as $p) {
                try { Storage::disk('public')->delete($p); } catch (\Throwable $__e) {}
            }
            Log::error('Produksi update error: ' . $e->getMessage());
            return back()->withInput()->with('message', 'Gagal memperbarui produk: ' . $e->getMessage());
        }
    }

    public function destroyPhoto($id)
    {
        $upload = FileUpload::findOrFail($id);

        if ($upload->file_path) {
            Storage::disk('public')->delete($upload->file_path);
        }

        $upload->delete();

        return response()->json(['message' => 'Foto dihapus'], 200);
    }

    public function destroy($id)
    {
        $product = Product::with('files')->findOrFail($id);

        DB::beginTransaction();
        try {

            foreach ($product->files as $f) {
                if ($f->file_path) {
                    Storage::disk('public')->delete($f->file_path);
                }
                $f->delete();
            }

            $product->delete();

            DB::commit();
            return response()->json(['message' => 'Produk dihapus'], 200);
        } catch (\Throwable $e) {
            DB::rollBack();
            Log::error('Produksi destroy error: ' . $e->getMessage());
            return response()->json(['message' => 'Gagal menghapus produk'], 500);
        }
    }

}
