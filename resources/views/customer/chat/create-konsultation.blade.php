@extends('layouts.general')
@section('title', 'Admin - Tambah Konsultasi')
@section('page', 'Tambah Konsultasi')

@section('content')
<div class="intro-y box col-span-12 lg:col-span-12 mt-5">
    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
        <h2 class="font-medium text-base mr-auto flex items-center">
            <i data-lucide="message-circle" class="w-4 h-4 mr-2"></i>
            Ajukan Pembuatan Proyek
        </h2>
    </div>

    <div class="border box border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
        <form method="POST" action="{{ route('customer.consultation.store') }}" class="mt-5">
            @csrf

            {{-- Subject --}}
            <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5">
                <div class="form-label xl:w-64 xl:!mr-10">
                    <div class="text-left">
                        <div class="font-medium">Subject</div>
                        <div class="leading-relaxed text-slate-500 text-xs mt-3">Deskripsikan secara singkat proyek yang ingin di buat</div>
                    </div>
                </div>
                <div class="w-full mt-3 xl:mt-0 flex-1">
                    <input
                        type="text"
                        name="subject"
                        class="form-control"
                        value="{{ old('subject') }}"
                        required
                    >
                    @error('subject')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>


            {{-- Assigned Teacher --}}
            <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5">
                <div class="form-label xl:w-64 xl:!mr-10">
                    <div class="text-left">
                        <div class="font-medium">Guru</div>
                        <div class="leading-relaxed text-slate-500 text-xs mt-3">Pilih guru yang merekomendasikan pengajuan proyek</div>
                    </div>
                </div>
                <div class="w-full mt-3 xl:mt-0 flex-1">
                    <select name="assigned_teacher_id" class="tom-select w-full" required>
                        <option value="">-- Pilih Teacher --</option>
                        @foreach ($teachers as $teacher)
                            <option value="{{ $teacher->id }}" {{ old('assigned_teacher_id') == $teacher->id ? 'selected' : '' }}>
                                {{ $teacher->user->name }}
                            </option>
                        @endforeach
                    </select>
                    @error('assigned_teacher_id')
                        <div class="text-danger mt-2">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="xl:ml-64 xl:pl-10 mt-8">
                <button type="submit" class="btn btn-primary">
                    Ajukan
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
