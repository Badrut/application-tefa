@extends('layouts.general')
@section('title' , 'Admin - Data Master')
@section('page', 'Data Master Pengguna')

@section('content')

                                <div class="intro-y box col-span-12 lg:col-span-12 mt-5">
                                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                                        <h2 class="font-medium text-base mr-auto flex items-center">
                                            <i data-lucide="user" class="w-4 h-4 mr-2"></i>
                                            Edit Pengguna
                                        </h2>
                                        <div class="dropdown ml-auto sm:hidden">
                                            <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i> </a>
                                        </div>
                                    </div>
                                    <div class="border box border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                                        <form method="POST" action="{{ route('admin.master-data.user-update' , $user->id) }}" class="mt-5">
                                            @csrf
                                            @method('PUT')
                                            {{-- Nama --}}
                                            <div class="form-inline items-start flex-col xl:flex-row">
                                                <div class="form-label xl:w-64 xl:!mr-10">
                                                    <div class="text-left">
                                                        <div class="font-medium">Nama Lengkap</div>
                                                        <div class="leading-relaxed text-slate-500 text-xs mt-3">
                                                            Nama lengkap sesuai dengan identitas resmi.
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
                                                            value="{{ old('name', $user->name) }}"
                                                            required
                                                        >
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- Username --}}
                                            <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5">
                                                <div class="form-label xl:w-64 xl:!mr-10">
                                                    <div class="text-left">
                                                        <div class="font-medium">Username</div>
                                                        <div class="leading-relaxed text-slate-500 text-xs mt-3">
                                                            Username unik untuk login ke sistem.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="w-full mt-3 xl:mt-0 flex-1">
                                                    @error('username')
                                                        <div class="mt-3">
                                                            <input id="input-username" type="text" name="username" class="form-control border-danger" placeholder="Input text" value="{{ old('username') }}">
                                                            <div class="text-danger mt-2">{{ $message }}</div>
                                                        </div>
                                                    @else
                                                        <input
                                                            type="text"
                                                            name="username"
                                                            class="form-control"
                                                            value="{{ old('username', $user->username) }}"
                                                            required
                                                        >
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- Email --}}
                                            <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5">
                                                <div class="form-label xl:w-64 xl:!mr-10">
                                                    <div class="text-left">
                                                        <div class="font-medium">Email</div>
                                                        <div class="leading-relaxed text-slate-500 text-xs mt-3">
                                                            Email digunakan untuk notifikasi penting.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="w-full mt-3 xl:mt-0 flex-1">
                                                    @error('email')
                                                        <div class="mt-3">
                                                            <label for="input-email" class="form-label">Email</label>
                                                            <input id="input-email" type="email" name="email" class="form-control border-danger" placeholder="Input email" value="{{ old('email') }}">
                                                            <div class="text-danger mt-2">{{ $message }}</div>
                                                        </div>
                                                    @else
                                                        <input
                                                            type="email"
                                                            name="email"
                                                            class="form-control"
                                                            value="{{ old('email', $user->email) }}"
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
                                                        <div class="font-medium">Alamat</div>
                                                        {{-- <div class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">Required</div> --}}
                                                    </div>
                                                     <div class="leading-relaxed text-slate-500 text-xs mt-3"> Digunakan untuk data administrasi. </div>
                                                </div>
                                            </div>
                                                <div class="w-full mt-3 xl:mt-0 flex-1">
                                                    @error('address')
                                                        <div class="mt-3">
                                                            <input id="input-address" type="text" name="address" class="form-control border-danger" placeholder="Input text" value="{{ old('address') }}">
                                                            <div class="text-danger mt-2">{{ $message }}</div>
                                                        </div>
                                                    @else
                                                        <input
                                                            type="text"
                                                            name="address"
                                                            class="form-control"
                                                            value="{{ old('address', $user->profile->address ?? '') }}"
                                                        >
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5">
                                                <div class="form-label xl:w-64 xl:!mr-10">
                                                <div class="text-left">
                                                    <div class="flex items-center">
                                                        <div class="font-medium">No Telepon</div>
                                                        {{-- <div class="ml-2 px-2 py-0.5 bg-slate-200 text-slate-600 dark:bg-darkmode-300 dark:text-slate-400 text-xs rounded-md">Required</div> --}}
                                                    </div>
                                                     <div class="leading-relaxed text-slate-500 text-xs mt-3"> Nomor aktif untuk keperluan komunikasi. </div>
                                                </div>
                                            </div>
                                                <div class="w-full mt-3 xl:mt-0 flex-1">
                                                    @error('phone_number')
                                                        <div class="mt-3">
                                                            <label for="input-phone" class="form-label">No Telepon</label>
                                                            <input id="input-phone" type="text" name="phone_number" class="form-control border-danger" placeholder="Input text" value="{{ old('phone_number') }}">
                                                            <div class="text-danger mt-2">{{ $message }}</div>
                                                        </div>
                                                    @else
                                                        <input
                                                            type="text"
                                                            name="phone_number"
                                                            class="form-control"
                                                            value="{{ old('phone_number', $user->profile->phone_number ?? '') }}"
                                                        >
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- Role --}}
                                            <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5">
                                                <div class="form-label xl:w-64 xl:!mr-10">
                                                    <div class="text-left">
                                                        <div class="font-medium">Hak Akses</div>
                                                        <div class="leading-relaxed text-slate-500 text-xs mt-3">
                                                                Hak akses pengguna.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="w-full mt-3 xl:mt-0 flex-1">
                                                     <div class="">
                                                            <select
                                                            id="role"
                                                            name="role"
                                                            data-placeholder="Select your favorite actors"
                                                            class="tom-select w-full">
                                                                    <option value="admin" {{ old('role', $user->roles->first()->name ?? '') == 'admin' ? 'selected' : '' }}>Admin</option>
                                                                    <option value="teacher" {{ old('role', $user->roles->first()->name ?? '') == 'teacher' ? 'selected' : '' }}>Guru</option>
                                                                    <option value="student" {{ old('role', $user->roles->first()->name ?? '') == 'student' ? 'selected' : '' }}>Siswa</option>
                                                                    <option value="customer" {{ old('role', $user->roles->first()->name ?? '') == 'customer' ? 'selected' : '' }}>Pelanggan</option>
                                                                    <option value="supplier" {{ old('role', $user->roles->first()->name ?? '') == 'supplier' ? 'selected' : '' }}>Pemasok</option>
                                                            </select>
                                                        </div>
                                                </div>
                                            </div>

                                            <div id="other-fields" class="hidden mt-5">
                                                {{-- Password --}}
                                                <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5">
                                                    <div class="form-label xl:w-64 xl:!mr-10">
                                                        <div class="text-left">
                                                            <div class="font-medium">Password</div>
                                                            <div class="leading-relaxed text-slate-500 text-xs mt-3">
                                                                    Password untuk login ke sistem.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="w-full mt-3 xl:mt-0 flex-1">
                                                        @error('password')
                                                            <div class="mt-3">
                                                                <input id="input-password" type="password" name="password" class="form-control border-danger" placeholder="Input password" value="{{ old('password') }}">
                                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                            </div>
                                                        @else
                                                            <input
                                                                type="password"
                                                                name="password"
                                                                class="form-control"
                                                                value="{{ old('password' ) }}"
                                                            >
                                                        @enderror
                                                    </div>
                                                </div>
                                                {{-- Password Confirmation --}}
                                                <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5">
                                                    <div class="form-label xl:w-64 xl:!mr-10">
                                                        <div class="text-left">
                                                            <div class="font-medium">Password Confirmation</div>
                                                            <div class="leading-relaxed text-slate-500 text-xs mt-3">
                                                                    Konfirmasi ulang password untuk verifikasi.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="w-full mt-3 xl:mt-0 flex-1">
                                                        @error('password_confirmation')
                                                            <div class="mt-3">
                                                                <input id="input-password" type="password" name="password_confirmation" class="form-control border-danger" placeholder="Input password confirmation" value="{{ old('password_confirmation') }}">
                                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                            </div>
                                                        @else
                                                            <input
                                                                type="password"
                                                                name="password_confirmation"
                                                                class="form-control"
                                                                value="{{ old('password_confirmation') }}"
                                                            >
                                                        @enderror
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="teacher-fields" class="hidden mt-5">
                                                <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5">
                                                    <div class="form-label xl:w-64 xl:!mr-10">
                                                        <div class="text-left">
                                                            <div class="font-medium">NIP</div>
                                                            <div class="leading-relaxed text-slate-500 text-xs mt-3">
                                                                    Nomor Induk Pegawai.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="w-full mt-3 xl:mt-0 flex-1">
                                                        @error('nip')
                                                            <div class="mt-3">
                                                                <input id="input-nip" type="text" name="nip" class="form-control border-danger" placeholder="Input text" >
                                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                            </div>
                                                        @else
                                                            <input
                                                                type="text"
                                                                name="nip"
                                                                class="form-control"
                                                                value="{{ old('nip' , $user->teacher->nip ?? '') }}"
                                                            >
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5">
                                                    <div class="form-label xl:w-64 xl:!mr-10">
                                                        <div class="text-left">
                                                            <div class="font-medium">Jurusan</div>
                                                            <div class="leading-relaxed text-slate-500 text-xs mt-3">
                                                                    Guru Jurusan.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="w-full mt-3 xl:mt-0 flex-1">
                                                         <div class="">
                                                            <select
                                                            id="major-select"
                                                            name="grade"
                                                            data-placeholder="Select your favorite actors"
                                                            class="tom-select w-full">
                                                                    @foreach ($majors as $major)
                                                                        <option value="{{ $major->id }}" {{ old('major_id', $user->teacher->major_id ?? '') == $major->id ? 'selected' : '' }}>{{ $major->name }}</option>
                                                                    @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5">
                                                    <div class="form-label xl:w-64 xl:!mr-10">
                                                        <div class="text-left">
                                                            <div class="font-medium">Keahlihan</div>
                                                            <div class="leading-relaxed text-slate-500 text-xs mt-3">
                                                                    Keahlian guru.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="w-full mt-3 xl:mt-0 flex-1">
                                                        @error('specialization')
                                                            <div class="mt-3">
                                                                <input id="input-specialization" type="text" name="specialization" class="form-control border-danger" placeholder="Input text" >
                                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                            </div>
                                                        @else
                                                            <input
                                                                type="text"
                                                                name="specialization"
                                                                class="form-control"
                                                                value="{{ old('specialization', $user->teacher->specialization ?? '') }}"
                                                            >
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5 first:mt-0 first:pt-0">
                                                    <div class="form-label xl:w-64 xl:!mr-10">
                                                        <div class="text-left">
                                                            <div class="flex items-center">
                                                                <div class="font-medium">Guru Status</div>
                                                            </div>
                                                            <div class="leading-relaxed text-slate-500 text-xs mt-3"> jika guru sudah purna status off </div>
                                                        </div>
                                                    </div>
                                                    <div class="w-full mt-3 xl:mt-0 flex-1">
                                                        <div class="form-check form-switch">
                                                            <input id="product-status-active" name="is_active" class="form-check-input" type="checkbox" {{ old('is_active', $user->teacher->is_active ?? false) ? 'checked' : '' }}>
                                                            <label class="form-check-label" for="product-status-active">Aktif</label>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div id="student-fields" class="hidden mt-5">
                                                {{-- NIS --}}
                                                <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5">
                                                    <div class="form-label xl:w-64 xl:!mr-10">
                                                        <div class="text-left">
                                                            <div class="font-medium">NIS</div>
                                                            <div class="leading-relaxed text-slate-500 text-xs mt-3">
                                                                    Nomor Induk Siswa.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="w-full mt-3 xl:mt-0 flex-1">
                                                        @error('nis')
                                                            <div class="mt-3">
                                                                <input id="input-nis" type="text" name="nis" class="form-control border-danger" placeholder="Input text" >
                                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                            </div>
                                                        @else
                                                            <input
                                                                type="text"
                                                                name="nis"
                                                                class="form-control"
                                                                value="{{ old('nis') , $user->student->nis ?? ''}}"
                                                            >
                                                        @enderror
                                                    </div>
                                                </div>
                                                <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5">
                                                    <div class="form-label xl:w-64 xl:!mr-10">
                                                        <div class="text-left">
                                                            <div class="font-medium">Jurusan</div>
                                                            <div class="leading-relaxed text-slate-500 text-xs mt-3">
                                                                    Jurusan siswa.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="w-full mt-3 xl:mt-0 flex-1">
                                                         <div class="">
                                                            <select
                                                            id="major-select"
                                                            name="grade"
                                                            data-placeholder="Select your favorite actors"
                                                            class="tom-select w-full">
                                                                    @foreach ($majors as $major)
                                                                        <option value="{{ $major->id }}" {{ old('major_id', $user->student->major_id ?? '') == $major->id ? 'selected' : '' }}>{{ $major->name }}</option>
                                                                    @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5">
                                                    <div class="form-label xl:w-64 xl:!mr-10">
                                                        <div class="text-left">
                                                            <div class="font-medium">Tingkatan</div>
                                                            <div class="leading-relaxed text-slate-500 text-xs mt-3">
                                                                    Tingkatan siswa (10, 11, atau 12).
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="w-full mt-3 xl:mt-0 flex-1">
                                                            <select
                                                                id="grade-select"
                                                                name="grade"
                                                                data-placeholder="Select your favorite actors"
                                                                class="tom-select w-full">
                                                                    <option value="10" {{ old('grade', $user->student->grade ?? '') == '10' ? 'selected' : '' }}>10</option>
                                                                    <option value="11" {{ old('grade', $user->student->grade ?? '') == '11' ? 'selected' : '' }}>11</option>
                                                                    <option value="12" {{ old('grade', $user->student->grade ?? '') == '12' ? 'selected' : '' }}>12</option>
                                                            </select>
                                                    </div>
                                                </div>
                                                <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5">
                                                    <div class="form-label xl:w-64 xl:!mr-10">
                                                        <div class="text-left">
                                                            <div class="font-medium">Kelas</div>
                                                            <div class="leading-relaxed text-slate-500 text-xs mt-3">
                                                                    Kelas siswa (M , T , O , R).
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="w-full mt-3 xl:mt-0 flex-1">
                                                            <select
                                                                id="class-select"
                                                                name="class"
                                                                data-placeholder="Select your favorite actors"
                                                                class="tom-select w-full">
                                                                    <option value="MA" {{ old('class', $user->student->class ?? '') == 'MA' ? 'selected' : '' }}>MA</option>
                                                                    <option value="MB" {{ old('class', $user->student->class ?? '') == 'MB' ? 'selected' : '' }}>MB</option>
                                                                    <option value="MC" {{ old('class', $user->student->class ?? '') == 'MC' ? 'selected' : '' }}>MC</option>
                                                                    <option value="TA" {{ old('class', $user->student->class ?? '') == 'TA' ? 'selected' : '' }}>TA</option>
                                                                    <option value="TB" {{ old('class', $user->student->class ?? '') == 'TB' ? 'selected' : '' }}>TB</option>
                                                                    <option value="TC" {{ old('class', $user->student->class ?? '') == 'TC' ? 'selected' : '' }}>TC</option>
                                                                    <option value="OA" {{ old('class', $user->student->class ?? '') == 'OA' ? 'selected' : '' }}>OA</option>
                                                                    <option value="OB" {{ old('class', $user->student->class ?? '') == 'OB' ? 'selected' : '' }}>OB</option>
                                                                    <option value="OC" {{ old('class', $user->student->class ?? '') == 'OC' ? 'selected' : '' }}>OC</option>
                                                                    <option value="RA" {{ old('class', $user->student->class ?? '') == 'RA' ? 'selected' : '' }}>RA</option>
                                                                    <option value="RB" {{ old('class', $user->student->class ?? '') == 'RB' ? 'selected' : '' }}>RB</option>
                                                                    <option value="RC" {{ old('class', $user->student->class ?? '') == 'RC' ? 'selected' : '' }}>RC</option>
                                                            </select>
                                                    </div>
                                                </div>
                                                <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5">
                                                    <div class="form-label xl:w-64 xl:!mr-10">
                                                        <div class="text-left">
                                                            <div class="font-medium">Angkatan</div>
                                                            <div class="leading-relaxed text-slate-500 text-xs mt-3">
                                                                    Tahun angkatan siswa.
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="w-full mt-3 xl:mt-0 flex-1">
                                                        @error('year_of_entry')
                                                            <div class="mt-3">
                                                                <input id="input-year_of_entry" type="text" name="year_of_entry" class="form-control border-danger" placeholder="Input text" >
                                                                <div class="text-danger mt-2">{{ $message }}</div>
                                                            </div>
                                                        @else
                                                            <input
                                                                type="text"
                                                                name="year_of_entry"
                                                                class="form-control"
                                                                value="{{ old('year_of_entry', $user->student->year_of_entry ?? '') }}"
                                                            >
                                                        @enderror
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
        document.addEventListener('DOMContentLoaded', function () {
            const roleSelect = document.getElementById('role');
            const teacherFields = document.getElementById('teacher-fields');
            const studentFields = document.getElementById('student-fields');
            const otherFields = document.getElementById('other-fields');
            function toggleFields() {
                const role = roleSelect ? roleSelect.value : null;

                if (teacherFields) {
                    teacherFields.style.display = (role === 'teacher') ? 'block' : 'none';
                }

                if (studentFields) {
                    studentFields.style.display = (role === 'student') ? 'block' : 'none';
                }

                if (otherFields) {
                    otherFields.style.display = (role === 'admin' || role === 'customer' || role === 'supplier') ? 'block' : 'none';
                }
            }

            if (roleSelect) {
                roleSelect.addEventListener('change', toggleFields);
                toggleFields();
            }
        });
    </script>
@endpush
