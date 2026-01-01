@extends('layouts.general')
@section('title', 'Admin - Data Master')
@section('page', 'History Orderan')

@section('content')
    <div class="">
        <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
            <h2 class="text-lg font-medium mr-auto">
                History Pesanan
            </h2>
        </div>
        @if (session('success') || session('status') || session('message'))
            <div class="mt-5 alert alert-primary show flex items-center mb-2" role="alert">
                <i data-lucide="users" class="w-6 h-6 mr-2"></i>
                {{ session('success') ?? (session('status') ?? session('message')) }}
            </div>
        @endif
        <!-- BEGIN: HTML Table Data -->
        <div class="intro-y box p-5 mt-5">
            <div class="flex flex-col sm:flex-row sm:items-end xl:items-start">
                <form id="tabulator-html-filter-form" class="xl:flex sm:mr-auto">
                    <div class="sm:flex items-center sm:mr-4">
                        <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Kolom</label>
                        <select id="tabulator-html-filter-field"
                            class="form-select w-full sm:w-32 2xl:w-full mt-2 sm:mt-0 sm:w-auto">
                            <option value="name">Nama</option>
                            <option value="category">Kategori</option>
                            <option value="remaining_stock">Stok Tersisa</option>
                        </select>
                    </div>
                    <div class="sm:flex items-center sm:mr-4 mt-2 xl:mt-0">
                        <label class="w-12 flex-none xl:w-auto xl:flex-initial mr-2">Tipe</label>
                        <select id="tabulator-html-filter-type" class="form-select w-full mt-2 sm:mt-0 sm:w-auto">
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
                        <input id="tabulator-html-filter-value" type="text"
                            class="form-control sm:w-40 2xl:w-full mt-2 sm:mt-0" placeholder="Cari...">
                    </div>
                    <div class="mt-2 xl:mt-0">
                        <button id="tabulator-html-filter-go" type="button"
                            class="btn btn-primary w-full sm:w-16">Cari</button>
                        <button id="tabulator-html-filter-reset" type="button"
                            class="btn btn-secondary w-full sm:w-16 mt-2 sm:mt-0 sm:ml-1">Reset</button>
                    </div>
                </form>
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
        const USER_ROLE = @json(auth()->user()->getRoleNames()->first());

        const csrf = document
            .querySelector('meta[name="csrf-token"]')
            .getAttribute('content');

        const ICON_TRASH =
            `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-trash"><path d="M3 6h18"></path><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"></path><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"></path></svg>`;
        const ICON_EDIT =
            `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"></path><path d="M18.5 2.5a2.121 2.121 0 1 1 3 3L12 15l-4 1 1-4 9.5-9.5z"></path></svg>`;
        const ICON_DETAIL =
            `<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-eye"><path d="M2 12s3-7 10-7 10 7 10 7-3 7-10 7-10-7-10-7Z"/><circle cx="12" cy="12" r="3"/></svg>`;
        document.addEventListener('DOMContentLoaded', function() {

            const orders = @json($ordersJson);
            const statusMap = {
                pending:    { class: 'bg-danger', label: 'Belum di bayar' },
                dp_paid: { class: 'bg-warning', label: 'DP' },
                paid:  { class: 'bg-success', label: 'Lunas' },
                refunded:  { class: 'bg-danger', label: 'Di kembalikan' }
            };

            const paymentMap = {
                new:    { class: 'bg-pending', label: 'Menunggu di Proses' },
                in_production: { class: 'bg-warning', label: 'Diproses' },
                completed:  { class: 'bg-success', label: 'Selesai' },
                cancelled:  { class: 'bg-danger', label: 'Dibatalkan' }
            };
            const columns = [{
                    title: "ID",
                    field: "id",
                    width: 80,
                    filterable: false
                },

                {
                    title: "Foto",
                    field: "items",
                    width: 120,
                    hozAlign: "center",
                    filterable: false,
                    formatter: cell => {
                        const items = cell.getValue();
                        if (!items || items.length === 0) {
                            return `<div class="intro-x flex justify-center">
                                        <div class="intro-x w-8 h-8 image-fit">
                                            <img src="/dist/images/profile-15.jpg" class="rounded-full border border-white zoom-in tooltip">
                                        </div>
                                    </div>`;
                        }

                        // Loop items, tampilkan max 3 misal
                        const maxItems = 3;
                        const imagesHtml = items.slice(0, maxItems).map((item, idx) => {
                            return `
                                <div class="intro-x w-8 h-8 image-fit ${idx === 0 ? '' : '-ml-4'}">
                                    <img src="${item.primaryImage}"
                                        alt="${item.item_name}"
                                        class="rounded-full border border-white zoom-in tooltip">
                                </div>
                            `;
                        }).join('');

                        return `<div class="intro-x flex justify-center">${imagesHtml}</div>`;
                    }
                },
                {
                    title: "Total Harga",
                    field: "total_amount",
                    formatter: function(cell) {
                        let value = cell.getValue();
                        return 'Rp ' + Number(value ?? 0).toLocaleString('id-ID');
                    }
                },
                {
                    title: "Status",
                    field: "order_status",
                    formatter: function(cell) {
                        let value = (cell.getValue() ?? '').toLowerCase();
                        let status = paymentMap[value] ?? { class: 'bg-slate-500/80', label: value };
                        return `<span class="px-2 py-1 rounded text-white ${status.class}">${status.label}</span>`;
                    },
                    hozAlign: "center",
                    width: 200,
                },
                {
                    title: "Status Pembayaran",
                    field: "payment_status",
                    formatter: function(cell) {
                        let value = (cell.getValue() ?? '').toLowerCase();
                        let status = statusMap[value] ?? { class: 'bg-slate-500/80', label: value };
                        return `<span class="px-2 py-1 rounded text-white ${status.class}">${status.label}</span>`;
                    },
                    hozAlign: "center",
                    width: 200,
                },
                {
                    title: "Tanggal Pengiriman",
                    field: "delivery_date",
                },
                {
                title: "Aksi",
                hozAlign: "center",
                headerHozAlign: "center",
                filterable: false,
                formatter: function(cell) {
                    const orderId = cell.getRow().getData().id;

                    let html = `
                        <a href="/order/${orderId}"
                        class="btn btn-sm btn-primary p-1.5 inline-flex items-center justify-center mr-1"
                        title="Detail">
                            ${ICON_DETAIL}
                        </a>
                    `;

                    if (USER_ROLE !== 'customer') {
                        html += `
                            <a href="/order/${orderId}/edit"
                            class="btn btn-sm btn-warning p-1.5">
                                ${ICON_EDIT}
                            </a>
                        `;
                    }

                    if (USER_ROLE === 'customer') {
                        html += `
                            <button
                                class="btn btn-sm btn-danger p-1.5"
                                title="Hapus"
                                onclick="deleteOrder(${orderId})">
                                ${ICON_DELETE}
                            </button>
                        `;
                    }
                    return html;
                }
            }
            ];
            const table = new Tabulator("#tabulator", {
                data: orders,
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
                    const type = document.getElementById('tabulator-html-filter-type').value;
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

        function deleteOrder(orderId) {
            if (!confirm('Yakin ingin menghapus pesanan ini?')) return;

            fetch(`/order/${orderId}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json'
                }
            })
            .then(res => {
                if (!res.ok) throw new Error('Gagal menghapus');
                return res.json();
            })
            .then(() => {
                alert('Pesanan berhasil dihapus');
                table.replaceData(); // reload tabulator
            })
            .catch(err => {
                alert(err.message);
            });
        }
    </script>
@endpush
