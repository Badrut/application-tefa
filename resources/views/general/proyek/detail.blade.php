@extends('layouts.general')

@role('admin')
@section('title' , 'Admin Proyek')
@endrole

@role('teacher')
@section('title' , 'Teacher Proyek')
@endrole

@role('customer')
@section('title' , 'Customer Proyek')
@endrole

@section('content')

                    <div class="">
                    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
                        <h2 class="text-lg font-medium mr-auto">
                            Detail Proyek Anda
                            @if($quotation->status != 'approved')
                                <div class="text-slate-500 text-sm mt-0.5 whitespace-nowrap">detail pesanan anda tertera di bawah silakan hubungi guru jika ada data yang tidak sesuai dan jika sudah sesuai silakan setujui pesanan anda</div>
                            @endif
                        </h2>
                        @if($quotation->status != 'approved')
                                                <form action="{{ route('quotations.approve' , $quotation) }}" method="POST" class="w-full sm:w-auto flex mt-4 sm:mt-0">
                            @csrf
                            <button class="btn btn-primary shadow-md mr-2">Setuju</button>
                        </form>
                        @endif
                    </div>
                    <!-- BEGIN: Invoice -->
                    <div class="intro-y box overflow-hidden mt-5">
                        <div class="border-b border-slate-400/60 bg-primary dark:border-darkmode-400 text-center sm:text-left">
                            <div class="px-5 py-10 sm:px-20 sm:py-20">
                                <img src="{{ asset('dist/images/logo.png') }}" alt="" style="width: 200px">
                            </div>
                            <div class="flex flex-col lg:flex-row px-5 sm:px-20 pt-10 pb-10 sm:pb-20">
                                <div>
                                    <div class="text-base text-white">Detail Pelanggan</div>
                                    <div class="text-lg font-medium text-white mt-2">{{ $quotation->customer->name }}</div>
                                    <div class="mt-1 text-white">{{ $quotation->customer->email }}</div>
                                    <div class="mt-1 text-white">{{ $quotation->customer->profile->address }}</div>
                                </div>
                                <div class="lg:text-right mt-10 lg:mt-0 lg:ml-auto">
                                    <div class="text-base text-white">Guru pengawas</div>
                                    <div class="text-lg font-medium text-white mt-2">{{ $quotation->createdBy->name }}</div>
                                    <div class="mt-1 text-white">{{ $quotation->createdBy->teacher->major->name }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="px-5 sm:px-16 py-10 sm:py-20">
                            <div class="overflow-x-auto">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="border-b-2 dark:border-darkmode-400 whitespace-nowrap">NAMA</th>
                                            <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">QTY</th>
                                            <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">HARGA SATUAN</th>
                                            <th class="border-b-2 dark:border-darkmode-400 text-right whitespace-nowrap">SUBTOTAL</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($quotation->items as $item)
                                            <tr>
                                                <td class="border-b dark:border-darkmode-400">
                                                    <div class="font-medium whitespace-nowrap">{{ $item->item_name }}</div>
                                                    <div class="text-slate-500 text-sm mt-0.5 whitespace-nowrap">
                                                        @if($item->item_type === 'product') Produk
                                                        @elseif($item->item_type === 'service') Jasa
                                                        @else Kustom
                                                        @endif
                                                    </div>
                                                </td>
                                                <td class="text-right border-b dark:border-darkmode-400 w-32">{{ $item->quantity }}</td>
                                                <td class="text-right border-b dark:border-darkmode-400 w-32">Rp {{ number_format($item->unit_price, 0, ',', '.') }}</td>
                                                <td class="text-right border-b dark:border-darkmode-400 w-40 font-medium">Rp {{ number_format($item->quantity * $item->unit_price, 0, ',', '.') }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        @php
                            $subtotal = $quotation->items->sum(function($item) {
                                return $item->quantity * $item->unit_price;
                            });
                        @endphp

                        <div class="px-5 sm:px-20 pb-10 sm:pb-20 flex flex-col-reverse sm:flex-row">
                            <div class="text-center sm:text-right sm:ml-auto">
                                <div class="text-base text-slate-500">Total</div>
                                <div class="text-xl text-primary font-medium mt-2">Rp {{ number_format($subtotal, 0, ',', '.') }}</div>
                            </div>
                        </div>
                    </div>
                    <!-- END: Invoice -->
                </div>

@endsection
