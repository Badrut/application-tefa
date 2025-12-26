@extends('layouts.general')
@section('title' , 'Admin - Data Master')
@section('page', 'Data Master Jurusan')

@section('content')

                                <div class="intro-y box col-span-12 lg:col-span-12 mt-5">
                                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                                        <h2 class="font-medium text-base mr-auto flex items-center">
                                            <i data-lucide="graduation-cap" class="w-4 h-4 mr-2"></i>
                                            Tambah Jurusan
                                        </h2>
                                        <div class="dropdown ml-auto sm:hidden">
                                            <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i> </a>
                                        </div>
                                    </div>
                                    <div class="border box border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                                        <form method="POST" action="{{ route('admin.master-data.major-store') }}" class="mt-5">
                                            @csrf

                                            {{-- Email --}}
                                            <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5">
                                                <div class="form-label xl:w-64 xl:!mr-10">
                                                    <div class="text-left">
                                                        <div class="font-medium">Kode</div>
                                                        <div class="leading-relaxed text-slate-500 text-xs mt-3">
                                                            Kode Program Keahlihan baru
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="w-full mt-3 xl:mt-0 flex-1">
                                                    @error('code')
                                                        <div class="mt-3">
                                                            <label for="input-code" class="form-label">Kode</label>
                                                            <input id="input-code" type="code" name="code" class="form-control border-danger" placeholder="Input code" value="{{ old('code') }}">
                                                            <div class="text-danger mt-2">{{ $message }}</div>
                                                        </div>
                                                    @else
                                                        <input
                                                            type="text"
                                                            name="code"
                                                            class="form-control"
                                                            value="{{ old('code') }}"
                                                            required
                                                        >
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- Alamat --}}
                                            <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5">
                                                <div class="form-label xl:w-64 xl:!mr-10">
                                                <div class="text-left">
                                                    <div class="flex items-center">
                                                        <div class="font-medium">Nama</div>
                                                        {{-- <div class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">Required</div> --}}
                                                    </div>
                                                     <div class="leading-relaxed text-slate-500 text-xs mt-3"> Nama Program keahliahan baru </div>
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
                                                        >
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5">
                                                <div class="form-label xl:w-64 xl:!mr-10">
                                                <div class="text-left">
                                                    <div class="flex items-center">
                                                        <div class="font-medium">Deskripsi</div>
                                                        {{-- <div class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">Required</div> --}}
                                                    </div>
                                                     <div class="leading-relaxed text-slate-500 text-xs mt-3"> Deskripsikan secara singkat perogram keahlian baru</div>
                                                </div>
                                            </div>
                                                <div class="w-full mt-3 xl:mt-0 flex-1">
                                                    @error('description')
                                                        <div class="mt-3">
                                                            <input id="input-phone" type="text" name="description" class="form-control border-danger" placeholder="Input text" value="{{ old('description') }}">
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

                                            {{-- Head Teacher Id --}}
                                            <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5">
                                                <div class="form-label xl:w-64 xl:!mr-10">
                                                    <div class="text-left">
                                                        <div class="font-medium">KAPERODI</div>
                                                        <div class="leading-relaxed text-slate-500 text-xs mt-3">
                                                                Kepala Program Studi.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="w-full mt-3 xl:mt-0 flex-1">
                                                     <div class="">
                                                            <select
                                                            id="role"
                                                            name="head_teacher_id"
                                                            data-placeholder="Select your favorite actors"
                                                            class="tom-select w-full">
                                                                    @foreach ($users as $user)
                                                                        <option value="{{ $user->teacher->id }}">{{ $user->name }}</option>
                                                                    @endforeach
                                                            </select>
                                                        </div>
                                                </div>
                                            </div>

                                                <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
                                                    <div class="form-label xl:w-64 xl:!mr-10">
                                                        <div class="text-left">
                                                            <div class="flex items-center">
                                                                <div class="font-medium">Status Jurusan</div>
                                                            </div>
                                                            <div class="leading-relaxed text-slate-500 text-xs mt-3">  </div>
                                                        </div>
                                                    </div>
                                                    <div class="w-full mt-3 xl:mt-0 flex-1">
                                                        <div class="form-check form-switch">
                                                            <input id="product-status-active" name="is_active" class="form-check-input" type="checkbox">
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
