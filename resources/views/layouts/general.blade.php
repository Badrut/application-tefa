<!DOCTYPE html>
<html lang="en" class="light">
    <!-- BEGIN: Head -->
    <head>
        <meta charset="utf-8">
        <link href="{{ asset('dist/images/skandakra.png') }}" rel="shortcut icon">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="description" content="Icewall admin is super flexible, powerful, clean & modern responsive tailwind admin template with unlimited possibilities.">
        <meta name="keywords" content="admin template, Icewall Admin Template, dashboard template, flat admin template, responsive admin template, web app">
        <meta name="author" content="Badrut">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>Teaching Factory - @yield('title' , 'Dashboard')</title>
        <!-- BEGIN: CSS Assets-->
        <link rel="stylesheet" href="{{ asset('dist/css/app.css') }}" />
        <!-- END: CSS Assets-->
    </head>
    <!-- END: Head -->
    <body class="main">
        <!-- BEGIN: Mobile Menu -->
        <div class="mobile-menu md:hidden">
            <div class="mobile-menu-bar">
                <a href="" class="flex mr-auto">
                    <img alt="Midone - HTML Admin Template" class="w-6" style="width: 150px" src="{{ asset('dist/images/logo.png') }}">
                </a>
                <a href="javascript:;" class="mobile-menu-toggler"> <i data-lucide="bar-chart-2" class="w-8 h-8 text-white transform -rotate-90"></i> </a>
            </div>
            <div class="scrollable">
                <a href="javascript:;" class="mobile-menu-toggler"> <i data-lucide="x-circle" class="w-8 h-8 text-white transform -rotate-90"></i> </a>
                <ul class="scrollable__content py-2">
                    @role('admin')
                    <li>
                        <a href="{{ route('admin.dashboard') }}" class="menu">
                            <div class="menu__icon"><i data-lucide="home"></i></div>
                            <div class="menu__title">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.proyek') }}" class="menu">
                            <div class="menu__icon"><i data-lucide="folder"></i></div>
                            <div class="menu__title">Proyek</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.produksi') }}" class="menu">
                            <div class="menu__icon"><i data-lucide="settings"></i></div>
                            <div class="menu__title">Produksi</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.transaksi') }}" class="menu">
                            <div class="menu__icon"><i data-lucide="credit-card"></i></div>
                            <div class="menu__title">Transaksi</div>
                        </a>
                    </li>
                    <li>
                        <a href="#" class="menu">
                            <div class="menu__icon"><i data-lucide="database"></i></div>
                            <div class="menu__title">Master Data</div>
                        </a>
                        <ul class="">
                            <li>
                                <a href="{{ route('admin.master-data.users') }}" class="menu">
                                    <div class="menu__icon"> <i data-lucide="users"></i> </div>
                                    <div class="menu__title"> Users </div>
                                </a>
                            </li>
                            <li>
                                <a href="{{ route('admin.master-data.major') }}" class="menu">
                                    <div class="menu__icon"> <i data-lucide="graduation-cap"></i> </div>
                                    <div class="menu__title"> Major </div>
                                </a>
                            </li>
                        </ul>
                    </li>
                    <li>
                        <a href="{{ route('admin.laporan') }}" class="menu">
                            <div class="menu__icon"><i data-lucide="bar-chart-2"></i></div>
                            <div class="menu__title">Laporan</div>
                        </a>
                    </li>
                    @endrole

                    @role('student')
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"><i data-lucide="home"></i></div>
                            <div class="menu__title">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"><i data-lucide="folder"></i></div>
                            <div class="menu__title">Proyek</div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"><i data-lucide="clipboard-list"></i></div>
                            <div class="menu__title">Tugas</div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"><i data-lucide="activity"></i></div>
                            <div class="menu__title">Aktivitas</div>
                        </a>
                    </li>
                    @endrole

                    @role('teacher')
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"><i data-lucide="home"></i></div>
                            <div class="menu__title">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"><i data-lucide="folder"></i></div>
                            <div class="menu__title">Proyek</div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"><i data-lucide="users"></i></div>
                            <div class="menu__title">Manajemen Siswa</div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"><i data-lucide="bar-chart-2"></i></div>
                            <div class="menu__title">Laporan</div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"><i data-lucide="message-circle"></i></div>
                            <div class="menu__title">Chat</div>
                        </a>
                    </li>
                    @endrole

                    @role('customer')
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"><i data-lucide="home"></i></div>
                            <div class="menu__title">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"><i data-lucide="shopping-bag"></i></div>
                            <div class="menu__title">Katalog</div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"><i data-lucide="help-circle"></i></div>
                            <div class="menu__title">Konsultasi</div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"><i data-lucide="package"></i></div>
                            <div class="menu__title">Pesanan</div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"><i data-lucide="bar-chart-2"></i></div>
                            <div class="menu__title">Laporan</div>
                        </a>
                    </li>
                    @endrole
                    @role('supplier')
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"><i data-lucide="home"></i></div>
                            <div class="menu__title">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"><i data-lucide="box"></i></div>
                            <div class="menu__title">Produk</div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"><i data-lucide="package"></i></div>
                            <div class="menu__title">Pesanan</div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="menu">
                            <div class="menu__icon"><i data-lucide="file-text"></i></div>
                            <div class="menu__title">Tagihan</div>
                        </a>
                    </li>
                    @endrole

                </ul>
            </div>
        </div>
        <!-- END: Mobile Menu -->
        <!-- BEGIN: Top Bar -->
        <div class="top-bar-boxed h-[70px] z-[51] relative border-b border-white/[0.08] mt-12 md:-mt-5 -mx-3 sm:-mx-8 px-3 sm:px-8 md:pt-0 mb-12">
            <div class="h-full flex items-center">
                <!-- BEGIN: Logo -->
                <a href="" class="-intro-x hidden md:flex">
                    <img alt="Midone - HTML Admin Template" style="width: 200px;" src="{{ asset('dist/images/logo.png') }}">
                    <span class="text-white text-lg ml-3"> </span>
                </a>
                <!-- END: Logo -->
                <!-- BEGIN: Breadcrumb -->
                <nav aria-label="breadcrumb" class="-intro-x h-full mr-auto">
                    <ol class="breadcrumb breadcrumb-light">
                        <li class="breadcrumb-item"><a href="#">Application</a></li>
                        <li class="breadcrumb-item active" aria-current="page"> @yield('page')</li>
                    </ol>
                </nav>
                <!-- END: Breadcrumb -->
                <!-- BEGIN: Notifications -->
                <div class="intro-x dropdown mr-4 sm:mr-6">
                    <div class="dropdown-toggle notification notification--bullet cursor-pointer" role="button" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="bell" class="notification__icon dark:text-slate-500"></i> </div>
                    <div class="notification-content pt-2 dropdown-menu">
                        <div class="notification-content__box dropdown-content">
                            <div class="notification-content__title">Notifications</div>
                            <div class="cursor-pointer relative flex items-center ">
                                <div class="w-12 h-12 flex-none image-fit mr-1">
                                    <img alt="Midone - HTML Admin Template" class="rounded-full" src="{{ asset('dist/images/profile-5.jpg') }}">
                                    <div class="w-3 h-3 bg-success absolute right-0 bottom-0 rounded-full border-2 border-white"></div>
                                </div>
                                <div class="ml-2 overflow-hidden">
                                    <div class="flex items-center">
                                        <a href="javascript:;" class="font-medium truncate mr-5">Kevin Spacey</a>
                                        <div class="text-xs text-slate-400 ml-auto whitespace-nowrap">05:09 AM</div>
                                    </div>
                                    <div class="w-full truncate text-slate-500 mt-0.5">Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry&#039;s standard dummy text ever since the 1500</div>
                                </div>
                            </div>
                            <div class="cursor-pointer relative flex items-center mt-5">
                                <div class="w-12 h-12 flex-none image-fit mr-1">
                                    <img alt="Midone - HTML Admin Template" class="rounded-full" src="{{ asset('dist/images/profile-3.jpg') }}">
                                    <div class="w-3 h-3 bg-success absolute right-0 bottom-0 rounded-full border-2 border-white"></div>
                                </div>
                                <div class="ml-2 overflow-hidden">
                                    <div class="flex items-center">
                                        <a href="javascript:;" class="font-medium truncate mr-5">Russell Crowe</a>
                                        <div class="text-xs text-slate-400 ml-auto whitespace-nowrap">01:10 PM</div>
                                    </div>
                                    <div class="w-full truncate text-slate-500 mt-0.5">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 20</div>
                                </div>
                            </div>
                            <div class="cursor-pointer relative flex items-center mt-5">
                                <div class="w-12 h-12 flex-none image-fit mr-1">
                                    <img alt="Midone - HTML Admin Template" class="rounded-full" src="{{ asset('dist/images/profile-14.jpg') }}">
                                    <div class="w-3 h-3 bg-success absolute right-0 bottom-0 rounded-full border-2 border-white"></div>
                                </div>
                                <div class="ml-2 overflow-hidden">
                                    <div class="flex items-center">
                                        <a href="javascript:;" class="font-medium truncate mr-5">John Travolta</a>
                                        <div class="text-xs text-slate-400 ml-auto whitespace-nowrap">05:09 AM</div>
                                    </div>
                                    <div class="w-full truncate text-slate-500 mt-0.5">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout. The point of using Lorem </div>
                                </div>
                            </div>
                            <div class="cursor-pointer relative flex items-center mt-5">
                                <div class="w-12 h-12 flex-none image-fit mr-1">
                                    <img alt="Midone - HTML Admin Template" class="rounded-full" src="{{ asset('dist/images/profile-3.jpg') }}">
                                    <div class="w-3 h-3 bg-success absolute right-0 bottom-0 rounded-full border-2 border-white"></div>
                                </div>
                                <div class="ml-2 overflow-hidden">
                                    <div class="flex items-center">
                                        <a href="javascript:;" class="font-medium truncate mr-5">Johnny Depp</a>
                                        <div class="text-xs text-slate-400 ml-auto whitespace-nowrap">05:09 AM</div>
                                    </div>
                                    <div class="w-full truncate text-slate-500 mt-0.5">Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 20</div>
                                </div>
                            </div>
                            <div class="cursor-pointer relative flex items-center mt-5">
                                <div class="w-12 h-12 flex-none image-fit mr-1">
                                    <img alt="Midone - HTML Admin Template" class="rounded-full" src="{{ asset('dist/images/profile-6.jpg') }}">
                                    <div class="w-3 h-3 bg-success absolute right-0 bottom-0 rounded-full border-2 border-white"></div>
                                </div>
                                <div class="ml-2 overflow-hidden">
                                    <div class="flex items-center">
                                        <a href="javascript:;" class="font-medium truncate mr-5">Arnold Schwarzenegger</a>
                                        <div class="text-xs text-slate-400 ml-auto whitespace-nowrap">05:09 AM</div>
                                    </div>
                                    <div class="w-full truncate text-slate-500 mt-0.5">There are many variations of passages of Lorem Ipsum available, but the majority have suffered alteration in some form, by injected humour, or randomi</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- END: Notifications -->
                <!-- BEGIN: Account Menu -->
                <div class="intro-x dropdown w-8 h-8">
                    <div class="dropdown-toggle w-8 h-8 rounded-full overflow-hidden shadow-lg image-fit zoom-in scale-110" role="button" aria-expanded="false" data-tw-toggle="dropdown">
                        <img alt="Midone - HTML Admin Template" src="{{ auth()->user()->profile?->profile_picture
                                            ? asset(auth()->user()->profile->profile_picture)
                                            : asset('dist/images/profile-15.jpg') }}">
                    </div>
                    <div class="dropdown-menu w-56">
                        <ul class="dropdown-content bg-primary/80 before:block before:absolute before:bg-black before:inset-0 before:rounded-md before:z-[-1] text-white">
                            <li class="p-2">
                                <div class="font-medium">{{ auth()->user()->username }}</div>
                                <div class="text-xs text-white/60 mt-0.5 dark:text-slate-500">{{ auth()->user()->getRoleNames()->first() }}</div>
                            </li>
                            <li>
                                <hr class="dropdown-divider border-white/[0.08]">
                            </li>
                            <li>
                                <a href="{{ route('profile.view') }}" class="dropdown-item hover:bg-white/5"> <i data-lucide="user" class="w-4 h-4 mr-2"></i> Profile </a>
                            </li>
                            <li>
                                <a href="" class="dropdown-item hover:bg-white/5"> <i data-lucide="lock" class="w-4 h-4 mr-2"></i> Reset Password </a>
                            </li>
                            <li>
                                <a href="" class="dropdown-item hover:bg-white/5"> <i data-lucide="help-circle" class="w-4 h-4 mr-2"></i> Help </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider border-white/[0.08]">
                            </li>
                            <li>
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="dropdown-item hover:bg-white/5 w-full text-left"> <i data-lucide="toggle-right" class="w-4 h-4 mr-2"></i> Logout </button>
                                </form>
                            </li>
                        </ul>
                    </div>
                </div>
                <!-- END: Account Menu -->
            </div>
        </div>
        <!-- END: Top Bar -->
        <!-- BEGIN: Top Menu -->
        <nav class="top-nav">
            <ul>

            @role('admin')
            <li>
                <a href="{{ route('admin.dashboard') }}" @class(['top-menu' , 'top-menu--active' => request()->routeIs('admin.dashboard')])>
                    <div class="top-menu__icon"><i data-lucide="home"></i></div>
                    <div class="top-menu__title">Dashboard</div>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.proyek') }}" @class(['top-menu' , 'top-menu--active' => request()->routeIs('admin.proyek')])>
                    <div class="top-menu__icon"><i data-lucide="folder"></i></div>
                    <div class="top-menu__title">Proyek</div>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.produksi') }}" @class(['top-menu' , 'top-menu--active' => request()->routeIs('admin.produksi*')])>
                    <div class="top-menu__icon"><i data-lucide="settings"></i></div>
                    <div class="top-menu__title">Produksi</div>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.transaksi') }}" @class(['top-menu' , 'top-menu--active' => request()->routeIs('admin.transaksi')])>
                    <div class="top-menu__icon"><i data-lucide="credit-card"></i></div>
                    <div class="top-menu__title">Transaksi</div>
                </a>
            </li>
            <li>
                <a href="#" @class(['top-menu' , 'top-menu--active' => request()->routeIs('admin.master-data.*')])>
                    <div class="top-menu__icon"><i data-lucide="database"></i></div>
                    <div class="top-menu__title">Master Data  <i data-lucide="chevron-down" class="top-menu__sub-icon"></i></div>
                </a>
                <ul class="">
                        <li>
                            <a href="{{ route('admin.master-data.users') }}" class="top-menu">
                                <div class="top-menu__icon"> <i data-lucide="users"></i> </div>
                                <div class="top-menu__title"> Pengguna </div>
                            </a>
                        </li>
                        <li>
                            <a href="{{ route('admin.master-data.major') }}" class="top-menu">
                                <div class="top-menu__icon"> <i data-lucide="graduation-cap"></i> </div>
                                <div class="top-menu__title"> Jurusan </div>
                            </a>
                        </li>
                </ul>
            </li>
            <li>
                <a href="{{ route('admin.laporan') }}" @class(['top-menu' , 'top-menu--active' => request()->routeIs('admin.laporan')])>
                    <div class="top-menu__icon"><i data-lucide="bar-chart-2"></i></div>
                    <div class="top-menu__title">Laporan</div>
                </a>
            </li>
            @endrole
            @role('student')
            <li>
                <a href="javascript:;" class="top-menu top-menu--active">
                    <div class="top-menu__icon"><i data-lucide="home"></i></div>
                    <div class="top-menu__title">Dashboard</div>
                </a>
            </li>
            <li>
                <a href="javascript:;" class="top-menu">
                    <div class="top-menu__icon"><i data-lucide="folder"></i></div>
                    <div class="top-menu__title">Proyek</div>
                </a>
            </li>
            <li>
                <a href="javascript:;" class="top-menu">
                    <div class="top-menu__icon"><i data-lucide="clipboard-list"></i></div>
                    <div class="top-menu__title">Tugas</div>
                </a>
            </li>
            <li>
                <a href="javascript:;" class="top-menu">
                    <div class="top-menu__icon"><i data-lucide="activity"></i></div>
                    <div class="top-menu__title">Aktivitas</div>
                </a>
            </li>
            @endrole
            @role('teacher')
            <li>
                <a href="javascript:;" class="top-menu top-menu--active">
                    <div class="top-menu__icon"><i data-lucide="home"></i></div>
                    <div class="top-menu__title">Dashboard</div>
                </a>
            </li>
            <li>
                <a href="javascript:;" class="top-menu">
                    <div class="top-menu__icon"><i data-lucide="folder"></i></div>
                    <div class="top-menu__title">Proyek</div>
                </a>
            </li>
            <li>
                <a href="javascript:;" class="top-menu">
                    <div class="top-menu__icon"><i data-lucide="users"></i></div>
                    <div class="top-menu__title">Manajemen Siswa</div>
                </a>
            </li>
            <li>
                <a href="javascript:;" class="top-menu">
                    <div class="top-menu__icon"><i data-lucide="bar-chart-2"></i></div>
                    <div class="top-menu__title">Laporan</div>
                </a>
            </li>
            <li>
                <a href="javascript:;" class="top-menu">
                    <div class="top-menu__icon"><i data-lucide="message-circle"></i></div>
                    <div class="top-menu__title">Chat</div>
                </a>
            </li>
            @endrole
            @role('customer')
                    <li>
                        <a href="{{ route('customer.dashboard') }}" @class(['top-menu' , 'top-menu--active' => request()->routeIs('customer.dashboard*')])>
                            <div class="top-menu__icon"><i data-lucide="home"></i></div>
                            <div class="top-menu__title">Dashboard</div>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('customer.katalog') }}" @class(['top-menu' , 'top-menu--active' => request()->routeIs('customer.katalog*')])>
                            <div class="top-menu__icon"><i data-lucide="shopping-bag"></i></div>
                            <div class="top-menu__title">Katalog</div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="top-menu">
                            <div class="top-menu__icon"><i data-lucide="help-circle"></i></div>
                            <div class="top-menu__title">Konsultasi</div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="top-menu">
                            <div class="top-menu__icon"><i data-lucide="package"></i></div>
                            <div class="top-menu__title">Pesanan</div>
                        </a>
                    </li>
                    <li>
                        <a href="javascript:;" class="top-menu">
                            <div class="top-menu__icon"><i data-lucide="bar-chart-2"></i></div>
                            <div class="top-menu__title">Laporan</div>
                        </a>
                    </li>
            @endrole
            @role('supplier')
            <li>
                <a href="javascript:;" class="top-menu top-menu--active">
                    <div class="top-menu__icon"><i data-lucide="home"></i></div>
                    <div class="top-menu__title">Dashboard</div>
                </a>
            </li>
            <li>
                <a href="javascript:;" class="top-menu">
                    <div class="top-menu__icon"><i data-lucide="box"></i></div>
                    <div class="top-menu__title">Produk</div>
                </a>
            </li>
            <li>
                <a href="javascript:;" class="top-menu">
                    <div class="top-menu__icon"><i data-lucide="package"></i></div>
                    <div class="top-menu__title">Pesanan</div>
                </a>
            </li>
            <li>
                <a href="javascript:;" class="top-menu">
                    <div class="top-menu__icon"><i data-lucide="file-text"></i></div>
                    <div class="top-menu__title">Tagihan</div>
                </a>
            </li>
            @endrole
            </ul>
            </nav>

        <!-- END: Top Menu -->
        <!-- BEGIN: Content -->
        <div class="wrapper wrapper--top-nav">
            <div class="wrapper-box">
                <!-- BEGIN: Content -->
                <div class="content">
                    @yield('content')
                </div>
                <!-- END: Content -->
            </div>
        </div>
        <!-- END: Content -->

        <!-- BEGIN: JS Assets-->
        @stack('scripts')
        @vite(['resources/js/app.js'])

        <script src="{{ asset('dist/js/app.js') }}" defer></script>
        <!-- END: JS Assets-->
    </body>
</html>
