@extends('layouts.general')
@section('title' , 'Admin Produksi')
@section('page', 'Produksi')

@section('content')
                                <div class="intro-y box col-span-12 lg:col-span-12 mt-5">
                                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                                        <h2 class="font-medium text-base mr-auto flex items-center">
                                            <i data-lucide="box" class="w-4 h-4 mr-2"></i>
                                            Tambah Jasa
                                        </h2>
                                        <div class="dropdown ml-auto sm:hidden">
                                            <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i> </a>
                                        </div>
                                    </div>
                                    <div class="border box border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                                        <form id="service-form" method="POST" action="{{ route('admin.produksi.store-service') }}" class="mt-5" enctype="multipart/form-data">
                                            @csrf
                                            {{-- Nama --}}
                                            <div class="form-inline items-start flex-col xl:flex-row">
                                                <div class="form-label xl:w-64 xl:!mr-10">
                                                    <div class="text-left">
                                                        <div class="font-medium">Nama Jasa</div>
                                                        <div class="leading-relaxed text-slate-500 text-xs mt-3">
                                                            Nama jasa
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="w-full mt-3 xl:mt-0 flex-1">
                                                    @error('name')
                                                        <div class="mt-3">
                                                            <input id="input-name" type="text" name="name" class="form-control border-danger" placeholder="Input text" value="{{ old('name') }}">
                                                            <div class="text-danger mt-2">{{ $message }}</div>
                                                        </div>
                                                    @else
                                                        <input
                                                            type="text"
                                                            name="name"
                                                            class="form-control"
                                                            value="{{ old('name') }}"
                                                            required
                                                        >
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- Code --}}
                                            <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5">
                                                <div class="form-label xl:w-64 xl:!mr-10">
                                                    <div class="text-left">
                                                        <div class="font-medium">Kode</div>
                                                        <div class="leading-relaxed text-slate-500 text-xs mt-3">
                                                            Kode service
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="w-full mt-3 xl:mt-0 flex-1">
                                                    @error('code')
                                                        <div class="mt-3">
                                                            <input id="input-code" type="text" name="code" class="form-control border-danger" placeholder="Input text" value="{{ old('code') }}">
                                                            <div class="text-danger mt-2">{{ $message }}</div>
                                                        </div>
                                                    @else
                                                        <input
                                                            type="text"
                                                            name="code"
                                                            class="form-control"
                                                            value="{{ old('code') }}"
                                                        >
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- Description --}}
                                            <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5">
                                                <div class="form-label xl:w-64 xl:!mr-10">
                                                    <div class="text-left">
                                                        <div class="font-medium">Deskripsi</div>
                                                        <div class="leading-relaxed text-slate-500 text-xs mt-3">
                                                            Deskripsikan secara singkat tentang service yang ditawarkan
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="w-full mt-3 xl:mt-0 flex-1">
                                                    @error('description')
                                                        <div class="mt-3">
                                                            <input id="input-description" type="text" name="description" class="form-control border-danger" placeholder="Input description" value="{{ old('description') }}">
                                                            <div class="text-danger mt-2">{{ $message }}</div>
                                                        </div>
                                                    @else
                                                        <input
                                                            type="text"
                                                            name="description"
                                                            class="form-control"
                                                            value="{{ old('description') }}"
                                                        >
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- Base Price --}}
                                            <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5">
                                                <div class="form-label xl:w-64 xl:!mr-10">
                                                <div class="text-left">
                                                    <div class="flex items-center">
                                                        <div class="font-medium">Harga Jasa</div>
                                                        {{-- <div class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">Required</div> --}}
                                                    </div>
                                                     <div class="leading-relaxed text-slate-500 text-xs mt-3"> Harga Jasa per paket atau per satuan sesuai kebutuhan.</div>
                                                </div>
                                            </div>
                                                <div class="w-full mt-3 xl:mt-0 flex-1">
                                                    @error('base_price')
                                                        <div class="mt-3">
                                                            <input id="input-base_price" type="text" name="base_price" class="form-control border-danger" placeholder="Input text" value="{{ old('base_price') }}">
                                                            <div class="text-danger mt-2">{{ $message }}</div>
                                                        </div>
                                                    @else
                                                        <input
                                                            type="text"
                                                            name="base_price"
                                                            class="form-control"
                                                            value="{{ old('base_price') }}"
                                                        >
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5">
                                                <div class="form-label xl:w-64 xl:!mr-10">
                                                <div class="text-left">
                                                    <div class="flex items-center">
                                                        <div class="font-medium">Satuan</div>
                                                        {{-- <div class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">Required</div> --}}
                                                    </div>
                                                     <div class="leading-relaxed text-slate-500 text-xs mt-3"> Satuan layanan, mis. per jam, per paket, per item.</div>
                                                </div>
                                            </div>
                                                <div class="w-full mt-3 xl:mt-0 flex-1">
                                                    @error('unit')
                                                        <div class="mt-3">
                                                            <input id="input-phone" type="text" name="unit" class="form-control border-danger" placeholder="Input text" value="{{ old('unit') }}">
                                                            <div class="text-danger mt-2">{{ $message }}</div>
                                                        </div>
                                                    @else
                                                        <input
                                                            type="text"
                                                            name="unit"
                                                            class="form-control"
                                                            value="{{ old('unit') }}"
                                                        >
                                                    @enderror
                                                </div>
                                            </div>
                                            {{-- Jasa Level --}}
                                            <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5">
                                                <div class="form-label xl:w-64 xl:!mr-10">
                                                    <div class="text-left">
                                                        <div class="font-medium">Tingkat Kesuliatan</div>
                                                        <div class="leading-relaxed text-slate-500 text-xs mt-3">Contoh: Basic / Standard / Premium</div>
                                                    </div>
                                                </div>
                                                <div class="w-full mt-3 xl:mt-0 flex-1">
                                                                                                                <select
                                                            id="role"
                                                            name="category_id"
                                                            data-placeholder="Select your favorite actors"
                                                            class="tom-select w-full">
                                                                  <option value="diagnosa">Pengecheckan</option>
                                                                  <option value="ringan">Ringan</option>
                                                                  <option value="sedang">Sedang</option>
                                                                  <option value="Berat">Berat</option>
                                                            </select>
                                                </div>
                                            </div>

                                            {{-- Estimated Hours --}}
                                            <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5">
                                                <div class="form-label xl:w-64 xl:!mr-10">
                                                    <div class="text-left">
                                                        <div class="font-medium">Estimasi Jam</div>
                                                        <div class="leading-relaxed text-slate-500 text-xs mt-3">Estimasi jam pengerjaan (opsional)</div>
                                                    </div>
                                                </div>
                                                <div class="w-full mt-3 xl:mt-0 flex-1">
                                                    <input type="number" name="estimated_hours" class="form-control" value="{{ old('estimated_hours') }}">
                                                </div>
                                            </div>
                                            <div class="form-inline items-start flex-col xl:flex-row mt-10">
                                                <div class="form-label w-full xl:w-64 xl:!mr-10">
                                                    <div class="text-left">
                                                        <div class="flex items-center">
                                                            <div class="font-medium">Foto Service</div>
                                                            <div class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">Required</div>
                                                        </div>
                                                        <div class="leading-relaxed text-slate-500 text-xs mt-3">
                                                            <div>The image format is .jpg .jpeg .png and a minimum size of 300 x 300 pixels (For optimal images use a minimum size of 700 x 700 pixels).</div>
                                                            <div class="mt-2">Select service photos or drag and drop up to 5 photos at once here. Include min. 3 attractive photos to make the listing more attractive.</div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="w-full mt-3 xl:mt-0 flex-1 border-2 border-dashed dark:border-darkmode-400 rounded-md pt-4">
                                                    <div class="px-4 pb-4 mt-3">
                                                        <div
                                                            id="photos-preview"
                                                            class="flex flex-wrap gap-5 px-4">
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
                                            {{-- Major --}}
                                            <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5">
                                                <div class="form-label xl:w-64 xl:!mr-10">
                                                    <div class="text-left">
                                                        <div class="font-medium">Jurusan</div>
                                                        <div class="leading-relaxed text-slate-500 text-xs mt-3">
                                                                jasa ini dibuat oleh jurusan apa
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="w-full mt-3 xl:mt-0 flex-1">
                                                     <div class="">
                                                            <select
                                                            id="role"
                                                            name="major_id"
                                                            data-placeholder="Select your favorite actors"
                                                            class="tom-select w-full">
                                                                    @foreach ($majors as $major)
                                                                        <option value="{{ $major->id }}">{{ $major->name }}</option>
                                                                    @endforeach
                                                            </select>
                                                        </div>
                                                </div>
                                            </div>
                                            <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
                                                    <div class="form-label xl:w-64 xl:!mr-10">
                                                        <div class="text-left">
                                                            <div class="flex items-center">
                                                                <div class="font-medium">Status Jasa</div>
                                                            </div>
                                                            <div class="leading-relaxed text-slate-500 text-xs mt-3"> Status jasa </div>
                                                        </div>
                                                    </div>
                                                    <div class="w-full mt-3 xl:mt-0 flex-1">
                                                        <div class="form-check form-switch">
                                                            <input
                                                                id="product-status-active"
                                                                name="is_active"
                                                                class="form-check-input"
                                                                type="checkbox"
                                                                value="1"
                                                            >
                                                            <label class="form-check-label" for="product-status-active">Aktif</label>
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
    </script>
@endpush

