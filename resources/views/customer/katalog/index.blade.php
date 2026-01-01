@extends('layouts.general')
@section('title' , 'Customer Produksi')
@section('page', 'Produksi')

@section('content')

                    <h2 class="intro-y text-lg font-medium mt-10">
                        Katalog Produk & Jasa
                    </h2>
                                <div class="intro-y flex justify-center mt-6">
                        <ul class=" pricing-tabs nav nav-pills w-auto box rounded-full mx-auto overflow-hidden " role="tablist" >
                            <li id="layout-1-monthly-fees-tab" class="nav-item flex-1" role="presentation">
                                <button class="nav-link w-32 lg:w-40 py-2 lg:py-3 active" data-tw-toggle="pill" data-tw-target="#layout-1-monthly-fees" type="button" role="tab" aria-controls="layout-1-monthly-fees" aria-selected="true" > Produk </button>
                            </li>
                            <li id="layout-1-annual-fees-tab" class="nav-item flex-1" role="presentation">
                                <button class="nav-link w-32 lg:w-40 py-2 lg:py-3" data-tw-toggle="pill" data-tw-target="#layout-1-annual-fees" type="button" role="tab" aria-controls="layout-1-annual-fees" aria-selected="false" > Jasa </button>
                            </li>
                        </ul>
                    </div>
                        @if(session('success') || session('status') || session('message'))
                            <div class="mt-5 alert alert-primary show flex items-center mb-2" role="alert">
                                <i data-lucide="settings" class="w-6 h-6 mr-2"></i>
                                    {{ session('success') ?? session('status') ?? session('message') }}
                            </div>
                        @endif
                        <div class="tab-content">
                            <div id="layout-1-monthly-fees" class="tab-pane active" role="tabpanel" aria-labelledby="layout-1-monthly-fees-tab">
                                <div class="grid grid-cols-12 gap-6 mt-5">
                                    <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                                        <form method="GET" action="{{ route('produksi') }}" class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                                            <div class="flex items-center">
                                                <div class="w-56 relative text-slate-500">
                                                    <input type="text" name="q" value="{{ request('q') }}" class="form-control w-56 box pr-10" placeholder="Search...">
                                                    <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                                                </div>
                                                <div class="ml-3">
                                                    <select name="per_page" onchange="this.form.submit()" class="w-20 form-select box">
                                                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                                        <option value="35" {{ request('per_page') == 35 ? 'selected' : '' }}>35</option>
                                                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- BEGIN: Users Layout -->
                                    @foreach ($products as $product)
                                        <div class="intro-y col-span-12 md:col-span-6 lg:col-span-4 xl:col-span-3">
                                            <div class="box">
                                                <div class="p-5">
                                                    <div class="h-40 2xl:h-56 image-fit rounded-md overflow-hidden before:block before:absolute before:w-full before:h-full before:top-0 before:left-0 before:z-10 before:bg-gradient-to-t before:from-black before:to-black/10">
                                                        <img alt="Midone - HTML Admin Template" class="rounded-md"
                                                            src="{{ $product->primaryImage
                                                                ? asset('storage/' . $product->primaryImage->file_path)
                                                                : asset('storage/products/preview-10.jpg')
                                                            }}"
                                                        >
                                                        <span @class([
                                                            'absolute top-0 text-white text-xs m-5 px-2 py-1 rounded z-10',
                                                            'bg-primary' => $product->major->code === 'M',
                                                            'bg-pending' => $product->major->code === 'T',
                                                            'bg-danger' => $product->major->code === 'O',
                                                            'bg-success' => $product->major->code === 'R',
                                                        ])>{{ $product->major->name ?? '' }}</span>
                                                        <div class="absolute bottom-0 text-white px-5 pb-6 z-10"> <a href="" class="block font-medium text-base">{{ $product->name }}</a> <span class="text-white/90 text-xs mt-3"> {{ $product->description }} </div>
                                                    </div>
                                                    <div class="text-slate-600 dark:text-slate-500 mt-5">
                                                        <div class="flex items-center"> <i data-lucide="link" class="w-4 h-4 mr-2"></i> Harga: Rp {{ number_format($product->base_price, 0, ',', '.') }}</div>
                                                        <div class="flex items-center mt-2"> <i data-lucide="check-square" class="w-4 h-4 mr-2"></i> Status: <span class="ml-2 px-2 py-0.5 text-xs rounded-md
                                                                {{ $product->is_active ?
                                                                    'bg-success text-white/90' :
                                                                    'bg-danger text-white/90' }}">
                                                                {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex justify-center lg:justify-end items-center p-5 border-t border-slate-200/60 dark:border-darkmode-400">
                                                    <a class="flex items-center text-white mr-auto btn btn-primary" href="{{ route('customer.katalog.detail-product' , $product->id) }}"> <i data-lucide="shopping-bag" class="w-4 h-4 mr-1"></i> Pesan </a>
                                                </div>
                                            </div>
                                    </div>
                                    @endforeach
                                    <!-- END: Users Layout -->
                                    <!-- BEGIN: Pagination -->
                                    <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
                                        <nav class="w-full sm:w-auto sm:mr-auto">
                                            {{ $products->withQueryString()->links() }}
                                        </nav>
                                    </div>
                                    <!-- END: Pagination -->
                                </div>
                            </div>
                            <div id="layout-1-annual-fees" class="tab-pane" role="tabpanel" aria-labelledby="layout-1-annual-fees-tab">
                                <div class="grid grid-cols-12 gap-6 mt-5">
                                    <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                                        <form method="GET" action="{{ route('produksi') }}" class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                                            <div class="flex items-center">
                                                <div class="w-56 relative text-slate-500">
                                                    <input type="text" name="q" value="{{ request('q') }}" class="form-control w-56 box pr-10" placeholder="Search...">
                                                    <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                                                </div>
                                                <div class="ml-3">
                                                    <select name="per_page" onchange="this.form.submit()" class="w-20 form-select box">
                                                        <option value="10" {{ request('per_page') == 10 ? 'selected' : '' }}>10</option>
                                                        <option value="25" {{ request('per_page') == 25 ? 'selected' : '' }}>25</option>
                                                        <option value="35" {{ request('per_page') == 35 ? 'selected' : '' }}>35</option>
                                                        <option value="50" {{ request('per_page') == 50 ? 'selected' : '' }}>50</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                    <!-- BEGIN: Users Layout -->
                                    @foreach ($services as $service)
                                        <div class="intro-y col-span-12 md:col-span-6 lg:col-span-4 xl:col-span-3">
                                            <div class="box">
                                                <div class="p-5">
                                                    <div class="h-40 2xl:h-56 image-fit rounded-md overflow-hidden before:block before:absolute before:w-full before:h-full before:top-0 before:left-0 before:z-10 before:bg-gradient-to-t before:from-black before:to-black/10">
                                                        <img alt="Midone - HTML Admin Template" class="rounded-md"
                                                            src="{{ $service->primaryImage
                                                                ? asset('storage/' . $service->primaryImage->file_path)
                                                                : asset('storage/services/preview-10.jpg')
                                                            }}"
                                                        >
                                                        <span @class([
                                                            'absolute top-0 text-white text-xs m-5 px-2 py-1 rounded z-10',
                                                            'bg-primary' => $service->major->code === 'M',
                                                            'bg-pending' => $service->major->code === 'T',
                                                            'bg-danger' => $service->major->code === 'O',
                                                            'bg-success' => $service->major->code === 'R',
                                                        ])>{{ $service->major->name ?? '' }}</span>
                                                        <div class="absolute bottom-0 text-white px-5 pb-6 z-10"> <a href="" class="block font-medium text-base">{{ $service->name }}</a> <span class="text-white/90 text-xs mt-3"> {{ $service->description }} </div>
                                                    </div>
                                                    <div class="text-slate-600 dark:text-slate-500 mt-5">
                                                        <div class="flex items-center"> <i data-lucide="link" class="w-4 h-4 mr-2"></i> Harga: Rp {{ number_format($service->base_price, 0, ',', '.') }}</div>
                                                        <div class="flex items-center mt-2"> <i data-lucide="layers" class="w-4 h-4 mr-2"></i> Remaining Stock: 51 </div>
                                                        <div class="flex items-center mt-2"> <i data-lucide="check-square" class="w-4 h-4 mr-2"></i> Status: <span class="ml-2 px-2 py-0.5 text-xs rounded-md
                                                                {{ $service->is_active ?
                                                                    'bg-success text-white/90' :
                                                                    'bg-danger text-white/90' }}">
                                                                {{ $service->is_active ? 'Aktif' : 'Nonaktif' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="flex justify-center lg:justify-end items-center p-5 border-t border-slate-200/60 dark:border-darkmode-400">
                                                    <a class="flex items-center text-white btn btn-primary mr-auto" href="{{ route('customer.katalog.detail-service' , $service->id) }}"> <i data-lucide="shopping-bag" class="w-4 h-4 mr-1"></i> Pesan </a>

                                                </div>
                                            </div>
                                    </div>
                                    @endforeach
                                    <!-- END: Users Layout -->
                                    <!-- BEGIN: Pagination -->
                                    <div class="intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
                                        <nav class="w-full sm:w-auto sm:mr-auto">
                                            {{ $services->withQueryString()->links() }}
                                        </nav>
                                    </div>
                                    <!-- END: Pagination -->
                                </div>
                            </div>
                        </div>

@endsection
@push('scripts')
    <script>
        setTimeout(() => {
            const alerts = document.querySelectorAll('.alert');
            alerts.forEach(alert => {
                alert.style.transition = 'opacity 0.6s ease';
                alert.style.opacity = '0';
                setTimeout(() => {
                    if (alert.parentNode) alert.parentNode.removeChild(alert);
                }, 700);
            });
        }, 4000);


        (function(){
            document.addEventListener('click', function(e){
                const btn = e.target.closest('.delete-product, .delete-service');
                if (!btn) return;

                const isService = btn.classList.contains('delete-service');
                const id = btn.getAttribute('data-id');
                const confirmMsg = isService ? 'Hapus service ini?' : 'Hapus produk ini?';
                if (!confirm(confirmMsg)) return;

                const url = isService ? "{{ url('/admin/produksi/service') }}/" + id : "{{ url('/admin/produksi') }}/" + id;

                fetch(url, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                        'Accept': 'application/json'
                    }
                }).then(r => {
                    if (r.ok) return r.json();
                    throw new Error('network');
                }).then(() => {
                    const card = btn.closest('.intro-y');
                    if (card) card.remove();
                }).catch(() => alert('Gagal menghapus'));
            });
        })();
    </script>
@endpush
