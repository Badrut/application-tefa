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
@section('page', 'Proyek')

@section('content')

@if(session('success') || session('status') || session('message'))
    <div class="mt-5 alert alert-primary show flex items-center mb-2">
        <i data-lucide="check-circle" class="w-6 h-6 mr-2"></i>
        {{ session('success') ?? session('status') ?? session('message') }}
    </div>
@endif

    <div class="">
        <h2 class="intro-y text-lg font-medium mt-10">
            @role('admin')
            Manajemen Proyek
            @endrole
            @role('teacher')
            Proyek Anda
            @endrole
            @role('customer')
            Proyek Anda
            @endrole
        </h2>
        <div class="grid grid-cols-12 gap-6 mt-5">
                        <div class="intro-y col-span-12 flex flex-wrap sm:flex-nowrap items-center mt-2">
                                        @role('admin')
                            <a href="{{ route('proyek.create') }}" class="btn btn-primary shadow-md mr-2">Tambah Proyek</a>
                            @endrole
                            @role('teacher')
                            <a href="{{ route('proyek.create') }}" class="btn btn-primary shadow-md mr-2">Tambah Proyek</a>
                            @endrole

                            <div class="hidden md:block mx-auto text-slate-500">Showing 1 to 10 of 150 entries</div>
                            <div class="w-full sm:w-auto mt-3 sm:mt-0 sm:ml-auto md:ml-0">
                                <div class="w-56 relative text-slate-500">
                                    <input type="text" class="form-control w-56 box pr-10" placeholder="Search...">
                                    <i class="w-4 h-4 absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                                </div>
                            </div>
                        </div>
                        <!-- BEGIN: Users Layout -->
                        @foreach ($quotations as $project)

                        @php
                            $statusMap = [
                                'draft' => [
                                    'class' => 'bg-pending',
                                    'label' => 'Rancangan',
                                ],
                                'approved' => [
                                    'class' => 'bg-success',
                                    'label' => 'Disetujui',
                                ],
                                'rejected' => [
                                    'class' => 'bg-danger',
                                    'label' => 'Ditolak',
                                ],
                                'completed' => [
                                    'class' => 'bg-primary',
                                    'label' => 'Selesai',
                                ],
                            ];

                            $status = $statusMap[$project->status] ?? [
                                'class' => 'bg-slate-500/80',
                                'label' => ucfirst($project->status),
                            ];
                        @endphp

                        <div class="intro-y col-span-12 md:col-span-6 lg:col-span-4 xl:col-span-3">
                            <div class="box">
                                <div class="p-5">
                                    <div class="h-40 2xl:h-56 image-fit rounded-md overflow-hidden before:block before:absolute before:w-full before:h-full before:top-0 before:left-0 before:z-10 before:bg-gradient-to-t before:from-black before:to-black/10">
                                                        <img alt="Midone - HTML Admin Template" class="rounded-md"
                                                            src="{{ $project->primaryImage
                                                                ? asset('storage/' . $project->primaryImage->file_path)
                                                                : asset('storage/products/preview-10.jpg')
                                                            }}"
                                                        >
                                        <span class="absolute top-0 text-white text-xs m-5 px-2 py-1 rounded z-10 {{ $status['class'] }}">
                                            {{ $status['label'] }}
                                        </span>
                                    </div>
                                    <div class="text-slate-600 dark:text-slate-500 mt-5">
                                        <div class="flex items-center"> <i data-lucide="link" class="w-4 h-4 mr-2"></i> Total Anggaran: {{ number_format($project->total_amount, 0, ',', '.') }}</div>
                                        <div class="flex items-center mt-2"> <i data-lucide="layers" class="w-4 h-4 mr-2"></i> Estimasi Waktu: {{ $project->valid_until->diffForHumans() ?? 'Belum ditentukan'}}</div>
                                    </div>
                                </div>
                                <div class="flex justify-center lg:justify-end items-center p-5 border-t border-slate-200/60 dark:border-darkmode-400">
                                    <a class="flex items-center text-primary mr-auto" href="{{ route('proyek.show' , $project->id) }}"> <i data-lucide="eye" class="w-4 h-4 mr-1"></i> Detail </a>
                                    @role('teacher')
                                        <a class="flex items-center mr-3" href="{{ route('proyek.edit' , $project->id) }}"> <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                                    <a class="flex items-center text-danger" href="javascript:;" data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal"> <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                    @endrole
                                    @role('admin')
                                        <a class="flex items-center mr-3" href="{{ route('proyek.edit' , $project->id) }}"> <i data-lucide="check-square" class="w-4 h-4 mr-1"></i> Edit </a>
                                    <a class="flex items-center text-danger" href="javascript:;" data-tw-toggle="modal" data-tw-target="#delete-confirmation-modal"> <i data-lucide="trash-2" class="w-4 h-4 mr-1"></i> Delete </a>
                                    @endrole
                                </div>
                            </div>
                        </div>
                        @endforeach

                        </div>
                        <!-- END: Users Layout -->
                        <!-- BEGIN: Pagination -->
                        <div class="pt-5 intro-y col-span-12 flex flex-wrap sm:flex-row sm:flex-nowrap items-center">
                            <nav class="w-full sm:w-auto sm:mr-auto">
                                <ul class="pagination">
                                    <li class="page-item">
                                        <a class="page-link" href="#"> <i class="w-4 h-4" data-lucide="chevrons-left"></i> </a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#"> <i class="w-4 h-4" data-lucide="chevron-left"></i> </a>
                                    </li>
                                    <li class="page-item"> <a class="page-link" href="#">...</a> </li>
                                    <li class="page-item"> <a class="page-link" href="#">1</a> </li>
                                    <li class="page-item active"> <a class="page-link" href="#">2</a> </li>
                                    <li class="page-item"> <a class="page-link" href="#">3</a> </li>
                                    <li class="page-item"> <a class="page-link" href="#">...</a> </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#"> <i class="w-4 h-4" data-lucide="chevron-right"></i> </a>
                                    </li>
                                    <li class="page-item">
                                        <a class="page-link" href="#"> <i class="w-4 h-4" data-lucide="chevrons-right"></i> </a>
                                    </li>
                                </ul>
                            </nav>
                            <select class="w-20 form-select box mt-3 sm:mt-0">
                                <option>10</option>
                                <option>25</option>
                                <option>35</option>
                                <option>50</option>
                            </select>
                        </div>
                        <!-- END: Pagination -->
                    </div>
                </div>
@endsection

@push('scripts')
<script>
document.addEventListener('click', function(e){
    const btn = e.target.closest('.delete-project');
    if(!btn) return;

    if(!confirm('Hapus proyek ini?')) return;

    fetch(`/proyek/${btn.dataset.id}`,{
        method:'DELETE',
        headers:{
            'X-CSRF-TOKEN':document.querySelector('meta[name="csrf-token"]').content
        }
    }).then(()=>location.reload());
});

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
</script>
@endpush

