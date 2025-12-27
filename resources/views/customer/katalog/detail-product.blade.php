@extends('layouts.general')
@section('title' , 'Admin Produksi')
@section('page', 'Produksi')

@section('content')
                <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
                <h2 class="text-lg font-medium mr-auto">
                    Seller Details
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
            <!-- BEGIN: Seller Details -->
            <div class="intro-y grid grid-cols-11 gap-5 mt-5">
                <div class="col-span-12 lg:col-span-4 2xl:col-span-3">
                    <div class="box p-5 rounded-md mb-5">
                        <div class="h-40 image-fit rounded-md overflow-hidden
                            before:block before:absolute before:w-full before:h-full
                            before:top-0 before:left-0 before:z-10
                            before:bg-gradient-to-t before:from-black before:to-black/10">

                            <img
                                class="rounded-md absolute inset-0 w-full h-full object-cover"
                                src="{{ asset('storage/' . optional($product->primaryImage)->file_path ?? 'products/preview-10.jpg') }}"
                            >

                            <span class="absolute top-0 bg-success/80 text-white text-xs m-5 px-2 py-1 rounded z-10">
                                {{ $product->is_active ? 'Active' : 'Inactive' }}
                            </span>

                            <div class="absolute bottom-0 text-white px-5 pb-6 z-10">
                                <div class="font-medium text-base">
                                    {{ $product->name }}
                                </div>
                                <div class="text-white/90 text-xs mt-1">
                                    {{ $product->category->name ?? '-' }}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="box p-5 rounded-md">
                        <div class="flex items-center border-b border-slate-200/60 pb-5 mb-5">
                            <div class="font-medium text-base">Product Information</div>
                            <a href="{{ route('admin.produksi.edit', $product->id) }}"
                            class="flex items-center ml-auto text-primary">
                                <i data-lucide="edit" class="w-4 h-4 mr-2"></i> Edit
                            </a>
                        </div>

                        <div class="flex items-center">
                            <i data-lucide="clipboard" class="w-4 h-4 text-slate-500 mr-2"></i>
                            Satuan:
                            <span class="ml-auto font-medium">
                                {{ $product->unit ?? '-' }}
                            </span>
                        </div>

                        <div class="flex items-center mt-3">
                            <i data-lucide="wallet" class="w-4 h-4 text-slate-500 mr-2"></i>
                            Harga:
                            <span class="ml-auto font-medium">
                                Rp {{ number_format($product->base_price,0,',','.') }}
                            </span>
                        </div>

                        <div class="flex items-center mt-3">
                            <i data-lucide="layers" class="w-4 h-4 text-slate-500 mr-2"></i>
                            Stok:
                            <span class="ml-auto font-medium">
                                {{ $product->stock }}
                            </span>
                        </div>

                        <div class="flex items-center mt-3">
                            <i data-lucide="activity" class="w-4 h-4 text-slate-500 mr-2"></i>
                            Status:
                            <span class="ml-auto px-2 py-1 text-xs rounded
                                {{ $product->is_active ? 'bg-success text-white' : 'bg-danger text-white' }}">
                                {{ $product->is_active ? 'Aktif' : 'Nonaktif' }}
                            </span>
                        </div>
                    </div>
                    <div class="box p-5 rounded-md mt-5">
                        <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5 mb-5">
                            <div class="font-medium text-base truncate">Transaction Reports</div>
                            <a href="" class="flex items-center ml-auto text-primary"> <i data-lucide="edit" class="w-4 h-4 mr-2"></i> More Details </a>
                        </div>
                        <div class="flex items-center mt-3">
                            <i data-lucide="clipboard" class="w-4 h-4 text-slate-500 mr-2"></i> Avg. Daily Transactions:
                            <div class="ml-auto">$1,500.00</div>
                        </div>
                        <div class="flex items-center mt-3">
                            <i data-lucide="clipboard" class="w-4 h-4 text-slate-500 mr-2"></i> Avg. Monthly Transactions:
                            <div class="ml-auto">$42,500.00</div>
                        </div>
                        <div class="flex items-center mt-3">
                            <i data-lucide="clipboard" class="w-4 h-4 text-slate-500 mr-2"></i> Avg. Annually Transactions:
                            <div class="ml-auto">$1,012,500.00</div>
                        </div>
                        <div class="flex items-center mt-3">
                            <i data-lucide="star" class="w-4 h-4 text-slate-500 mr-2"></i> Average Rating:
                            <div class="ml-auto">4.9+</div>
                        </div>
                        <div class="flex items-center mt-3">
                            <i data-lucide="album" class="w-4 h-4 text-slate-500 mr-2"></i> Total Products:
                            <div class="ml-auto">7,120</div>
                        </div>
                        <div class="flex items-center mt-3">
                            <i data-lucide="archive" class="w-4 h-4 text-slate-500 mr-2"></i> Total Transactions:
                            <div class="ml-auto">1.512.001</div>
                        </div>
                        <div class="flex items-center mt-3">
                            <i data-lucide="monitor" class="w-4 h-4 text-slate-500 mr-2"></i> Active Disputes:
                            <div class="ml-auto">1</div>
                        </div>
                    </div>
                </div>
                <div class="col-span-12 lg:col-span-7 2xl:col-span-8">
                    <h2 class="text-lg font-medium mr-auto">
                        History Penjualan
                    </h2>
                    <div class="intro-y box p-5 mt-5">
                        <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                            <form id="tabulator-html-filter-form" class="xl:flex sm:mr-auto" >
                                <div class="sm:flex items-center sm:mr-4">
                                        <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Kolom</label>
                                    <select id="tabulator-html-filter-field" class="form-select w-full sm:w-32 2xl:w-full mt-2 sm:mt-0 sm:w-auto">
                                            <option value="name">Nama</option>
                                            <option value="category">Kategori</option>
                                            <option value="remaining_stock">Stok Tersisa</option>
                                    </select>
                                </div>
                                <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
                                        <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Tipe</label>
                                    <select id="tabulator-html-filter-type" class="form-select w-full mt-2 sm:mt-0 sm:w-auto" >
                                        <option value="like" selected>like</option>
                                        <option value="=">=</option>
                                        <option value="<">&lt;</option>
                                        <option value="<=">&lt;=</option>
                                        <option value=">">></option>
                                        <option value=">=">>=</option>
                                        <option value="!=">!=</option>
                                    </select>
                                </div>
                                <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
                                        <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Nilai</label>
                                        <input id="tabulator-html-filter-value" type="text" class="form-control sm:w-40 2xl:w-full mt-2 sm:mt-0" placeholder="Cari...">
                                </div>
                                <div class="mt-2 xl:mt-0">
                                        <button id="tabulator-html-filter-go" type="button" class="btn btn-primary w-full sm:w-16" >Cari</button>
                                        <button id="tabulator-html-filter-reset" type="button" class="btn btn-secondary w-full sm:w-16 mt-2 sm:mt-0 sm:ml-1" >Reset</button>
                                </div>
                            </form>
                            <div class="flex mt-5 sm:mt-0">
                                    <button id="tabulator-print" class="btn btn-outline-secondary w-1/2 sm:w-auto mr-2"> <i data-lucide="printer" class="w-4 h-4 mr-2"></i> Cetak </button>
                                <div class="dropdown w-1/2 sm:w-auto">
                                    <button class="dropdown-toggle btn btn-outline-secondary w-full sm:w-auto" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Export <i data-lucide="chevron-down" class="w-4 h-4 ml-auto sm:ml-2"></i> </button>
                                    <div class="dropdown-menu w-40">
                                        <ul class="dropdown-content">
                                            <li>
                                                    <a id="tabulator-export-csv" href="javascript:;" class="dropdown-item"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Ekspor CSV </a>
                                            </li>
                                            <li>
                                                    <a id="tabulator-export-json" href="javascript:;" class="dropdown-item"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Ekspor JSON </a>
                                            </li>
                                            <li>
                                                    <a id="tabulator-export-xlsx" href="javascript:;" class="dropdown-item"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Ekspor XLSX </a>
                                            </li>
                                            <li>
                                                    <a id="tabulator-export-html" href="javascript:;" class="dropdown-item"> <i data-lucide="file-text" class="w-4 h-4 mr-2"></i> Ekspor HTML </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="overflow-x-auto scrollbar-hidden">
                            <div id="tabulator" class="mt-5 table-report table-report--tabulator"></div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- END: Seller Details -->
@endsection
@push('scripts')
<script>
const csrf = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute('content');

const ICON_TRASH = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path></svg>`;
const ICON_EDIT = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>`;
const ICON_DETAIL = `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>`;
document.addEventListener('DOMContentLoaded', function () {

    const majors = ;

    const columns = [
        { title: "ID", field: "id", width: 80, filterable: false },
        { title: "Kode", field: "code" , width: 120},
        { title: "Nama", field: "name" , width: 200},
        { title: "Kaprodi", field: "head_teacher" },
        { title: "Deskripsi", field: "description" },
        {
            title: "Aksi",
            hozAlign: "center",
            headerHozAlign: "center",
            filterable: false,
            formatter: function (cell) {
                const majorID = cell.getRow().getData().id;

                return `
                    <a href="/admin/master/majors/show/${majorID}"
                    class="btn btn-sm btn-primary p-1.5 inline-flex items-center justify-center mr-1"
                    title="Detail">
                        ${ICON_DETAIL}
                    </a>

                    <form method="POST"
                        action="/admin/master/majors/${majorID}"
                        onsubmit="return confirm('Hapus major ini?')"
                        style="display:inline;">

                        <input type="hidden" name="_token" value="${csrf}">
                        <input type="hidden" name="_method" value="DELETE">

                        <button type="submit" class="btn btn-sm btn-danger">
                            ${ICON_TRASH}
                        </button>

                    </form>


                    <a href="/admin/master/majors/edit/${majorID}"
                    class="btn btn-sm btn-warning ml-1">
                        ${ICON_EDIT}
                    </a>
                `;
            }
        },

    ];

    const table = new Tabulator("#tabulator", {
        data: majors,
        layout: "fitColumns",
        pagination: "local",
        paginationSize: 10,
        columnDefaults: {
            headerHozAlign: "left",
        },
        columns: columns,
    });

    const filterSelect = document.getElementById("tabulator-html-filter-field");
    filterSelect.innerHTML = "";

    columns.forEach(col => {
        if (!col.field) return;
        if (col.filterable === false) return;

        const option = document.createElement("option");
        option.value = col.field;
        option.textContent = col.title;
        filterSelect.appendChild(option);
    });

    document.getElementById('tabulator-html-filter-go')
        .addEventListener('click', () => {

            const field = filterSelect.value;
            const type  = document.getElementById('tabulator-html-filter-type').value;
            const value = document.getElementById('tabulator-html-filter-value').value;

            if (!field) return;

            table.setFilter(field, type, value);
        });

    document.getElementById("tabulator-html-filter-reset")
        .addEventListener("click", () => {

            table.clearFilter();

            filterSelect.selectedIndex = 0;
            document.getElementById("tabulator-html-filter-type").value = "like";
            document.getElementById("tabulator-html-filter-value").value = "";
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
});
</script>
@endpush

