@extends('layouts.general')

@role('admin')
@section('title' , 'Admin Proyek')
@endrole

@role('teacher')
@section('title' , 'Teacher Proyek')
@endrole

@section('page', 'Proyek')

@section('content')
                                <div class="intro-y box col-span-12 lg:col-span-12 mt-5">
                                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                                        <h2 class="font-medium text-base mr-auto flex items-center">
                                            <i data-lucide="box" class="w-4 h-4 mr-2"></i>
                                            Tambah Proyek
                                        </h2>
                                        <div class="dropdown ml-auto sm:hidden">
                                            <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i> </a>
                                        </div>
                                    </div>
                                    <div class="border box border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                                        <form id="product-form" method="POST" action="{{ route('proyek.store') }}" class="mt-5" enctype="multipart/form-data">
                                            @csrf
                                            {{-- Nama --}}
                                            <input type="hidden" name="consultation_id" id="consultation_id">
                                            <div class="form-inline items-start flex-col xl:flex-row">
                                                <div class="form-label xl:w-64 xl:!mr-10">
                                                    <div class="text-left">
                                                        <div class="font-medium">Ajuan Konsultasi</div>
                                                        <div class="leading-relaxed text-slate-500 text-xs mt-3">
                                                            pilih salah satu ajuan konsultasi dari customer yang meminta anda untuk mengerjakan project nya
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="w-full mt-3 xl:mt-0 flex-1">
                                                    <div class="grid grid-cols-12 gap-6 mt-5">
                                                        @foreach ($consultations as $con)
                                                            <div class="box intro-y col-span-12 md:col-span-6 lg:col-span-4">
                                                                <div class="box">
                                                                    <div class="flex items-start px-5 pt-5">
                                                                        <div class="w-full flex flex-col lg:flex-row items-center">
                                                                            <div class="w-16 h-16 image-fit">
                                                                                <img alt="Midone - HTML Admin Template" class="rounded-full"src="{{ auth()->user()->profile?->profile_picture
                                            ? asset(auth()->user()->profile->profile_picture)
                                            : asset('dist/images/profile-15.jpg') }}">
                                                                            </div>
                                                                            <div class="lg:ml-4 text-center lg:text-left mt-3 lg:mt-0">
                                                                                <a href="" class="font-medium">{{ $con->customer->name }}</a>
                                                                            </div>
                                                                        </div>
                                                                        <div class="absolute right-0 top-0 mr-5 mt-3 dropdown">
                                                                            <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i> </a>
                                                                            <div class="dropdown-menu w-40">
                                                                                <div class="dropdown-content">
                                                                                    <a href="" class="dropdown-item"> <i data-lucide="edit-2" class="w-4 h-4 mr-2"></i> Edit </a>
                                                                                    <a href="" class="dropdown-item"> <i data-lucide="trash" class="w-4 h-4 mr-2"></i> Delete </a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="text-center lg:text-left p-5">
                                                                        <div>{{ $con->subject }}</div>
                                                                    </div>
                                                                    <div class="text-center  lg:text-right p-5 border-t border-slate-200/60 dark:border-darkmode-400">
                                                                        <button type="button" data-id="{{ $con->id }}" class="btn btn-kerjakan btn-primary text-white py-1 px-2 mr-2">Kerjakan</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-inline items-start flex-col xl:flex-row mt-10">
                                                <div class="form-label xl:w-64 xl:!mr-10">
                                                    <div class="text-left">
                                                        <div class="font-medium">Estimasi Waktu</div>
                                                        <div class="leading-relaxed text-slate-500 text-xs mt-3">
                                                            Berapa lama waktu yang anda butuhkan untuk melesaikan pekerjaan ini
                                                        </div>
                                                    </div>
                                                </div>
                                                    <div class="w-full mt-3 xl:mt-0 flex-1">
                                                    <div class="relative w-56">
                                                        <div
                                                            class="absolute rounded-l w-10 h-full flex items-center justify-center
                                                                bg-slate-100 border text-slate-500
                                                                dark:bg-darkmode-700 dark:border-darkmode-800 dark:text-slate-400">
                                                            <i data-lucide="calendar" class="w-4 h-4"></i>
                                                        </div>

                                                        <input
                                                            type="date"
                                                            name="valid_until"
                                                            value="{{ old('valid_until') }}"
                                                            class=" form-control pl-12 @error('valid_until') border-danger @enderror"
                                                            data-single-mode="true"
                                                            data-format="Y-m-d"
                                                        >
                                                    </div>

                                                    @error('valid_until')
                                                        <div class="text-danger text-xs mt-2">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>

                                            </div>
                                            <div class="form-inline items-start flex-col xl:flex-row mt-10">
                                                <div class="form-label w-full xl:w-64 xl:!mr-10">
                                                    <div class="text-left">
                                                        <div class="flex items-center">
                                                            <div class="font-medium">Foto Produk</div>
                                                            <div class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">Required</div>
                                                        </div>
                                                        <div class="leading-relaxed text-slate-500 text-xs mt-3">
                                                            <div>
                                                                Format gambar yang didukung: .jpg, .jpeg, .png dengan ukuran minimum 300 × 300 piksel
                                                                (untuk hasil terbaik, gunakan ukuran minimal 700 × 700 piksel).
                                                            </div>
                                                            <div class="mt-2">
                                                                Pilih foto produk atau seret dan lepas hingga 5 foto sekaligus di sini.
                                                                Sertakan minimal 3 foto yang menarik agar produk lebih menarik bagi pembeli.
                                                            </div>
                                                        </div>

                                                    </div>
                                                </div>
                                                <div class="w-full mt-3 xl:mt-0 flex-1 border-2 border-dashed dark:border-darkmode-400 rounded-md pt-4">
                                                    <div class="px-4 pb-4 mt-3">
                                                        <div id="photos-preview" class="flex flex-wrap gap-5 px-4">
                                                            @if(isset($project) && $project->images)
                                                                @foreach($project->images as $img)
                                                                    <div class="w-28 h-28 relative rounded-md zoom-in cursor-pointer">
                                                                        <img src="{{ asset($img->path) }}" class="w-full h-full object-cover rounded-md overflow-hidden">
                                                                        <div data-old="{{ $img->id }}"
                                                                            class="remove-image w-6 h-6 flex items-center justify-center absolute rounded-full
                                                                                    text-white bg-danger right-0 top-0 -mr-2 -mt-2 z-10 cursor-pointer">
                                                                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                                                                                stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                                                                <path d="M3 6h18"/>
                                                                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                                                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                                                                            </svg>
                                                                        </div>
                                                                    </div>
                                                                @endforeach
                                                            @endif
                                                        </div>
                                                    </div>
                                                    <div class="px-4 pb-4 mt-5 flex items-center justify-center cursor-pointer relative">
                                                        <i data-lucide="image" class="w-4 h-4 mr-2"></i> <span class="text-primary mr-1">Upload files</span> or drag and drop
                                                        <input id="photos" name="photos[]" type="file" multiple accept="image/*" class="w-full h-full top-0 left-0 absolute opacity-0">
                                                    </div>
                                                    <div class="px-4 pb-4 mt-3">
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="mt-5">
    <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5">
        <div class="form-label xl:w-64 xl:!mr-10">
            <div class="text-left">
                <div class="font-medium">Daftar Harga Penawaran</div>
                <div class="leading-relaxed text-slate-500 text-xs mt-3">
                    Tentukan jumlah minimum, maksimum, dan harga per item.
                </div>
            </div>
        </div>

<div class="w-full mt-3 xl:mt-0 flex-1">
    <div id="items-wrapper" class="space-y-5">

        @for ($i = 0; $i < 1; $i++)
        <div class="relative xl:pr-10 py-6 bg-slate-50 dark:bg-transparent dark:border rounded-md item-card">

                    <!-- remove -->
        <button type="button"
            class="remove-item text-slate-500 absolute top-0 right-0 pb-5">
            <svg
  xmlns="http://www.w3.org/2000/svg"
  width="20"
  height="20"
  viewBox="0 0 24 24"
  fill="none"
  stroke="currentColor"
  stroke-width="2"
  stroke-linecap="round"
  stroke-linejoin="round"
  class="lucide lucide-x">
  <path d="M18 6 6 18"/>
  <path d="m6 6 12 12"/>
</svg>
        </button>

            <!-- Tipe -->
            <div class="form-inline mt-3">
                <label class="form-label sm:w-32">Tipe</label>
                <div class="flex-1">
                    <select
                        name="items[{{ $i }}][item_type]"
                        class="form-control">
                        <option value="product">Produk</option>
                        <option value="service">Jasa</option>
                        <option value="custom">Kustom</option>
                    </select>
                </div>
            </div>


                <!-- Product -->
                <div class="form-inline mt-3 product-field hidden">
                    <label class="form-label sm:w-32">Produk</label>
                    <div class="flex-1">
                        <select name="items[{{ $i }}][item_id]" class="form-control">
                            <option value="">-- Pilih Produk --</option>
                            @foreach ($products as $p)
                                <option value="{{ $p->id }}">{{ $p->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <!-- Service -->
                <div class="form-inline mt-3 service-field hidden">
                    <label class="form-label sm:w-32">Jasa</label>
                    <div class="flex-1">
                        <select name="items[{{ $i }}][item_id]" class="form-control">
                            <option value="">-- Pilih Jasa --</option>
                            @foreach ($services as $s)
                                <option value="{{ $s->id }}">{{ $s->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>


            <!-- Nama -->
            <div class="form-inline mt-5">
                <label class="form-label sm:w-32">Nama</label>
                <div class="flex-1">
                    <input
                        type="text"
                        name="items[{{ $i }}][item_name]"
                        class="form-control"
                        placeholder="Nama item">
                </div>
            </div>

            <!-- Quantity -->
            <div class="form-inline mt-5">
                <label class="form-label sm:w-32">Quantity</label>
                <div class="flex-1">
                    <input
                        type="number"
                        name="items[{{ $i }}][quantity]"
                        class="form-control"
                        placeholder="Qty">
                </div>
            </div>

            <!-- Harga -->
            <div class="form-inline mt-5">
                <label class="form-label sm:w-32">Harga</label>
                <div class="flex-1">
                    <div class="input-group">
                        <div class="input-group-text">Rp</div>
                        <input
                            type="number"
                            name="items[{{ $i }}][unit_price]"
                            class="form-control"
                            placeholder="Harga satuan">
                    </div>
                </div>
            </div>

            <!-- Notes -->
            <div class="form-inline mt-5">
                <label class="form-label sm:w-32">Catatan</label>
                <div class="flex-1">
                    <input
                        type="text"
                        name="items[{{ $i }}][notes]"
                        class="form-control"
                        placeholder="Catatan">
                </div>
            </div>

        </div>
        @endfor
    </div>

    <!-- ADD ITEM -->
    <button
        type="button"
        id="add-item"
        class="btn btn-outline-primary border-dashed w-full mt-4">
        <i data-lucide="plus" class="w-4 h-4 mr-2"></i>
        Tambah Item
    </button>
</div>

    </div>
</div>

                                            <div class="xl:ml-64 xl:pl-10 mt-8">
                                                <button type="submit" class="btn btn-primary">
                                                    Simpan Perubahan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
@endsection

@push('scripts')
    <script>
        (function(){
            const input = document.getElementById('photos');
            const preview = document.getElementById('photos-preview');
            let files = [];

            function renderPreviews(){
                preview.innerHTML = '';
                files.forEach((file, idx) => {
                const url = URL.createObjectURL(file);
                const col = document.createElement('div');
                col.className = 'w-28 h-28 relative rounded-md zoom-in cursor-pointer';

                    col.innerHTML = `
                        <img class="w-full h-full object-cover rounded-md overflow-hidden" src="${url}">
                        <div data-idx="${idx}"
                            class="remove-image w-6 h-6 flex items-center justify-center absolute rounded-full
                                    text-white bg-danger right-0 top-0 -mr-2 -mt-2 z-10 cursor-pointer">
                            <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none"
                                stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M3 6h18"/>
                                <path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/>
                                <path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/>
                            </svg>
                        </div>
                    `;
                    preview.appendChild(col);
                }
                );

                // re-initialize lucide icons if used
                if (window.lucide && window.lucide.replace) window.lucide.replace();
            }

            function syncInputFiles(){
                const dt = new DataTransfer();
                files.forEach(f => dt.items.add(f));
                input.files = dt.files;
            }

            input.addEventListener('change', (e) => {
                const selected = Array.from(e.target.files);
                // merge but prevent >5
                files = files.concat(selected).slice(0,5);
                renderPreviews();
                syncInputFiles();
            });

            preview.addEventListener('click', (e) => {
                const btn = e.target.closest('.remove-image');
                if (!btn) return;
                const idx = Number(btn.getAttribute('data-idx'));
                files.splice(idx, 1);
                renderPreviews();
                syncInputFiles();
            });
        })();

        let index = 3;

        document.getElementById('add-item').addEventListener('click', function () {
            const wrapper = document.getElementById('items-wrapper');

            const row = document.createElement('div');
row.classList.add('item-card');
row.innerHTML = `
    <div class="relative pl-5 xl:pr-10 py-6 bg-slate-50 dark:bg-transparent dark:border rounded-md">

        <!-- remove -->
        <button type="button"
            class="remove-item text-slate-500 absolute top-0 right-0 pb-5">
            <svg
  xmlns="http://www.w3.org/2000/svg"
  width="20"
  height="20"
  viewBox="0 0 24 24"
  fill="none"
  stroke="currentColor"
  stroke-width="2"
  stroke-linecap="round"
  stroke-linejoin="round"
  class="lucide lucide-x">
  <path d="M18 6 6 18"/>
  <path d="m6 6 12 12"/>
</svg>
        </button>

        <!-- Tipe -->
        <div class="form-inline mt-3">
            <label class="form-label sm:w-32">Tipe</label>
            <div class="flex-1">
                <select name="items[${index}][item_type]" class="form-control">
                    <option value="product">Produk</option>
                    <option value="service">Jasa</option>
                    <option value="custom">Kastem</option>
                </select>
            </div>
        </div>

        <!-- Product -->
        <div class="form-inline mt-3 product-field hidden">
            <label class="form-label sm:w-32">Produk</label>
            <div class="flex-1">
                <select name="items[${index}][item_id]" class="form-control">
                    <option value="">-- Pilih Produk --</option>
                    @foreach ($products as $p)
                        <option value="{{ $p->id }}">{{ $p->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Service -->
        <div class="form-inline mt-3 service-field hidden">
            <label class="form-label sm:w-32">Jasa</label>
            <div class="flex-1">
                <select name="items[${index}][item_id]" class="form-control">
                    <option value="">-- Pilih Jasa --</option>
                    @foreach ($services as $s)
                        <option value="{{ $s->id }}">{{ $s->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>


        <!-- Nama -->
        <div class="form-inline mt-5">
            <label class="form-label sm:w-32">Nama</label>
            <div class="flex-1">
                <input
                    type="text"
                    name="items[${index}][item_name]"
                    class="form-control"
                    placeholder="Nama item">
            </div>
        </div>

        <!-- Quantity -->
        <div class="form-inline mt-5">
            <label class="form-label sm:w-32">Quantity</label>
            <div class="flex-1">
                <input
                    type="number"
                    name="items[${index}][quantity]"
                    class="form-control"
                    placeholder="Qty">
            </div>
        </div>

        <!-- Harga -->
        <div class="form-inline mt-5">
            <label class="form-label sm:w-32">Harga Satuan</label>
            <div class="flex-1">
                <div class="input-group">
                    <div class="input-group-text">Rp</div>
                    <input
                        type="number"
                        name="items[${index}][unit_price]"
                        class="form-control"
                        placeholder="Harga per tipe">
                </div>
            </div>
        </div>

        <!-- Catatan -->
        <div class="form-inline mt-5">
            <label class="form-label sm:w-32">Catatan</label>
            <div class="flex-1">
                <input
                    type="text"
                    name="items[${index}][notes]"
                    class="form-control"
                    placeholder="Catatan">
            </div>
        </div>

    </div>
`;


            wrapper.appendChild(row);
            index++;
        });

        document.addEventListener('click', function (e) {
            if (e.target.closest('.remove-item')) {
                e.target.closest('tr').remove();
            }
        });

            document.addEventListener('click', function (e) {
        const btn = e.target.closest('.btn-kerjakan');
        if (!btn) return;

        document.querySelectorAll('.btn-kerjakan').forEach(el => {
            el.classList.remove('btn-success');
            el.classList.add('btn-primary');
        });

        btn.classList.remove('btn-primary');
        btn.classList.add('btn-success');


        document.getElementById('consultation_id').value = btn.dataset.id;

        });

        document.addEventListener('click', function (e) {
            if (e.target.closest('.remove-item')) {
                e.target.closest('.item-card').remove();
            }
        });

        document.addEventListener('change', function (e) {
            const typeSelect = e.target.closest('select[name*="[item_type]"]');
            if (!typeSelect) return;

            const card = typeSelect.closest('.item-card');
            const product = card.querySelector('.product-field');
            const service = card.querySelector('.service-field');

            // hide all first
            product.classList.add('hidden');
            service.classList.add('hidden');

            // reset value biar ga ke-submit
            product.querySelector('select').value = '';
            service.querySelector('select').value = '';

            if (typeSelect.value === 'product') {
                product.classList.remove('hidden');
            }

            if (typeSelect.value === 'service') {
                service.classList.remove('hidden');
            }
        });

        document.getElementById('photos-preview').addEventListener('click', function(e){
            const btn = e.target.closest('.remove-image');
            if(!btn) return;

            // Jika old image
            if(btn.dataset.old){
                const oldId = btn.dataset.old;
                // bisa simpan di hidden input untuk dihapus saat submit
                const input = document.createElement('input');
                input.type = 'hidden';
                input.name = 'delete_images[]';
                input.value = oldId;
                document.getElementById('product-form').appendChild(input);
            }

            // remove preview
            btn.closest('div').remove();
        });
    </script>
@endpush
