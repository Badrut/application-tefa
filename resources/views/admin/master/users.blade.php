@extends('layouts.general')
@section('title' , 'Admin - Data Master')
@section('page', 'Data Master Pengguna')

@section('content')
                    <div class="">
                    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
                        <h2 class="text-lg font-medium mr-auto">
                                Manajemen Pengguna
                        </h2>
                        <div class="w-full sm:w-auto flex mt-4 sm:mt-0">
                                <a href="{{ route('admin.master-data.add-user') }}" class="btn btn-primary shadow-md mr-2">Tambah Pengguna Baru</a>
                        </div>
                    </div>
                    @if(session('success') || session('status') || session('message'))
                        <div class="mt-5 alert alert-primary show flex items-center mb-2" role="alert">
                            <i data-lucide="users" class="w-6 h-6 mr-2"></i>
                                {{ session('success') ?? session('status') ?? session('message') }}
                        </div>
                    @endif
                    <!-- BEGIN: HTML Table Data -->
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
                    <!-- END: HTML Table Data -->
                </div>
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

    const users = @json($users);

    const columns = [
        { title: "ID", field: "id", width: 80, filterable: false },

        {
            title: "Foto",
            field: "profile.picture",
            width: 100,
            hozAlign: "center",
            filterable: false,
            formatter: cell => {
                const img = cell.getValue() ?? '/dist/images/profile-1.jpg';
                return `
                    <img src="${img}"
                         class="w-10 h-10 rounded-full object-cover mx-auto">
                `;
            }
        },

        { title: "Nama", field: "name" },
        { title: "Email", field: "email" },
        { title: "Alamat", field: "profile.address" },
        { title: "Telepon", field: "profile.phone_number" },

        {
            title: "Peran",
            field: "roles",
            filterable: false,
            formatter: cell => {
                const roles = cell.getValue() || [];
                return roles
                    .map(role =>
                        `<span class="ml-1 px-2 py-0.5 bg-slate-200 text-slate-600 text-xs rounded-md">
                            ${role}
                        </span>`
                    )
                    .join('');
            }
        },
        {
            title: "Aksi",
            hozAlign: "center",
            headerHozAlign: "center",
            filterable: false,
            formatter: function (cell) {
                const userId = cell.getRow().getData().id;

                return `
                    <a href="/admin/master/users/show/${userId}"
                    class="btn btn-sm btn-primary p-1.5 inline-flex items-center justify-center mr-1"
                    title="Detail">
                        ${ICON_DETAIL}
                    </a>

                    <form method="POST"
                        action="/admin/master/users/${userId}"
                        onsubmit="return confirm('Hapus user ini?')"
                        style="display:inline;">

                        <input type="hidden" name="_token" value="${csrf}">
                        <input type="hidden" name="_method" value="DELETE">

                        <button type="submit" class="btn btn-sm btn-danger">
                            ${ICON_TRASH}
                        </button>

                    </form>


                    <a href="/admin/master/users/edit/${userId}"
                    class="btn btn-sm btn-warning ml-1">
                        ${ICON_EDIT}
                    </a>
                `;
            }

        }
    ];
    const table = new Tabulator("#tabulator", {
        data: users,
        layout: "fitColumns",
        pagination: "local",
        paginationSize: 10,
        responsiveLayout: "collapse",
        columns: columns,

        columnDefaults: {
            headerHozAlign: "left",
        },

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


