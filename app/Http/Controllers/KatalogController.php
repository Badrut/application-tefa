<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Service;
use Illuminate\Http\Request;

class KatalogController extends Controller
{
    public function index(Request $request){
        $q = $request->input('q');
        $perPage = (int) $request->input('per_page', 12);

        $query = Product::with('category', 'major' , 'primaryImage' , 'files');

        if ($q) {
            $query->where(function($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        $products = $query->orderBy('created_at', 'desc')->paginate($perPage);

        $serviceQuery = Service::with('major', 'primaryImage', 'files');
        if ($q) {
            $serviceQuery->where(function($sub) use ($q) {
                $sub->where('name', 'like', "%{$q}%")
                    ->orWhere('description', 'like', "%{$q}%");
            });
        }

        $services = $serviceQuery->orderBy('created_at', 'desc')->paginate($perPage);

        return view('customer.katalog.index', compact('products', 'services'));
    }

    public function showService($id)
    {
        $service = Service::with('files', 'major')->findOrFail($id);
        return view('customer.katalog.detail-service', compact('service'));
    }

    public function showProduct($id){
        $product = Product::with('files', 'category', 'major')->findOrFail($id);
        return view('customer.katalog.detail-product' , compact('product'));
    }

}
