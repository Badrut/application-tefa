@extends('layouts.general')
@section('title' , 'Admin Produksi')
@section('page', 'Produksi')

@section('content')
                <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
                <h2 class="text-lg font-medium mr-auto">
                    Service Details
                </h2>
                <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                    <button class="btn btn-primary shadow-md mr-2">Print</button>
                    <div class="dropdown ml-auto sm:ml-0">
                        <button class="dropdown-toggle btn px-2 box" aria-expanded="false" data-tw-toggle="dropdown">
                            <span class="w-5 h-5 flex items-center justify-center"> <i class="w-4 h-4" data-lucide="plus"></i> </span>
                        </button>
                        <div class="dropdown-menu w-40">
                            <ul class="dropdown-content">
                                <li>
                                    <a href="" class="dropdown-item"> <i data-lucide="file" class="w-4 h-4 mr-2"></i> Export Word </a>
                                </li>
                                <li>
                                    <a href="" class="dropdown-item"> <i data-lucide="file" class="w-4 h-4 mr-2"></i> Export PDF </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- BEGIN: Service Details -->
            <div class="intro-y grid grid-cols-11 gap-5 mt-5">
                <div class="col-span-12 lg:col-span-4 2xl:col-span-3">
                    <div class="box p-5 rounded-md mb-5">
                        <div class="h-40 image-fit rounded-md overflow-hidden
                            before:block before:absolute before:w-full before:h-full
                            before:top-0 before:left-0 before:z-10
                            before:bg-gradient-to-t before:from-black before:to-black/10">

                            <img
                                class="rounded-md absolute inset-0 w-full h-full object-cover"
                                src="{{ asset('storage/' . optional($service->primaryImage)->file_path ?? 'services/preview-10.jpg') }}"
                            >

                            <span class="absolute top-0 bg-success text-white text-xs m-5 px-2 py-1 rounded z-10">
                                {{ $service->is_active ? 'Active' : 'Inactive' }}
                            </span>

                            <div class="absolute bottom-0 text-white px-5 pb-6 z-10">
                                <div class="font-medium text-base">
                                    {{ $service->name }}
                                </div>
                                <div class="text-white/90 text-xs mt-1">
                                    {{ $service->major->name ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box p-5 rounded-md">

                        <div class="flex items-center">
                            <i data-lucide="clipboard" class="w-4 h-4 text-slate-500 mr-2"></i>
                            Satuan:
                            <span class="ml-auto font-medium">
                                {{ $service->unit ?? '-' }}
                            </span>
                        </div>

                        <div class="flex items-center mt-3">
                            <i data-lucide="wallet" class="w-4 h-4 text-slate-500 mr-2"></i>
                            Harga:
                            <span class="ml-auto font-medium">
                                Rp {{ number_format($service->base_price,0,',','.') }}
                            </span>
                        </div>

                        <div class="flex items-center mt-3">
                            <i data-lucide="clock" class="w-4 h-4 text-slate-500 mr-2"></i>
                            Estimasi Jam:
                            <span class="ml-auto font-medium">
                                {{ $service->estimated_hours ?? '-' }}
                            </span>
                        </div>

                        <div class="flex items-center mt-3">
                            <i data-lucide="award" class="w-4 h-4 text-slate-500 mr-2"></i>
                            Level Service:
                            <span class="ml-auto font-medium">
                                {{ $service->service_level ?? '-' }}
                            </span>
                        </div>

                        <div class="flex items-center mt-3">
                            <i data-lucide="activity" class="w-4 h-4 text-slate-500 mr-2"></i>
                            Status:
                            <span class="ml-auto px-2 py-1 text-xs rounded
                                {{ $service->is_active ? 'bg-success text-white' : 'bg-danger text-white' }}">
                                {{ $service->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 lg:col-span-8 2xl:col-span-8">
                    <div class="intro-y box p-5">
                        <div class="border box border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                            <form method="POST" action="{{ route('order.store') }}" class="mt-5">
                                @csrf
                                <input type="text" name="item_type" value="service" class="hidden">
                                <input type="text" name="item_id" value="{{ $service->id }}" class="hidden">

                                {{-- Quantity --}}
                                <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 border-t border-slate-200/60 dark:border-darkmode-400">
                                    <div class="form-label xl:w-64 xl:!mr-10">
                                        <div class="text-left">
                                            <div class="font-medium">Jumlah (Quantity)</div>
                                            <div class="leading-relaxed text-slate-500 text-xs mt-3">
                                                Masukkan jumlah pesanan (minimal 1).
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-full mt-3 xl:mt-0 flex-1">
                                        <input
                                            type="number"
                                            name="quantity"
                                            class="form-control @error('quantity') border-danger @enderror"
                                            value="{{ old('quantity', 1) }}"
                                            min="1"
                                            required
                                        >
                                        @error('quantity')
                                            <div class="text-danger mt-2 text-xs">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Delivery Address --}}
                                <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 border-t border-slate-200/60 dark:border-darkmode-400">
                                    <div class="form-label xl:w-64 xl:!mr-10">
                                        <div class="text-left">
                                            <div class="font-medium">Alamat Pengiriman</div>
                                            <div class="leading-relaxed text-slate-500 text-xs mt-3">
                                                Alamat tujuan pengiriman (opsional).
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-full mt-3 xl:mt-0 flex-1">
                                        <textarea
                                            name="delivery_address"
                                            class="form-control"
                                            rows="3"
                                            placeholder="Alamat lengkap..."
                                        >{{ old('delivery_address') }}</textarea>
                                        @error('delivery_address')
                                            <div class="text-danger mt-2 text-xs">{{ $message }}</div>
                                        @enderror
                                    </div>
                                </div>

                                {{-- Notes --}}
                                <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 border-t border-slate-200/60 dark:border-darkmode-400">
                                    <div class="form-label xl:w-64 xl:!mr-10">
                                        <div class="text-left">
                                            <div class="font-medium">Catatan Tambahan</div>
                                            <div class="leading-relaxed text-slate-500 text-xs mt-3">
                                                Instruksi khusus atau detail tambahan pesanan.
                                            </div>
                                        </div>
                                    </div>
                                    <div class="w-full mt-3 xl:mt-0 flex-1">
                                        <textarea
                                            name="notes"
                                            class="form-control"
                                            rows="2"
                                            placeholder="Contoh: Packing kayu, warna merah, dll."
                                        >{{ old('notes') }}</textarea>
                                    </div>
                                </div>

                                {{-- Action Buttons --}}
                                <div class="flex justify-end flex-col md:flex-row gap-2 mt-10">
                                    <button type="button" class="btn py-3 border-slate-300 dark:border-darkmode-400 text-slate-500 w-full md:w-52">Batal</button>
                                    <button type="submit" class="btn py-3 btn-primary w-full md:w-52">Buat Pesanan</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Service Details -->
@endsection
