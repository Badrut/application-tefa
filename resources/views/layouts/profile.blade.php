@extends('layouts.general')

@section('title' , 'Profile'.' '.auth()->user()->name)
@section('page', 'Profile')
@section('content')
                    <div class="content">
                    <div class="intro-y flex items-center mt-8">
                        <h2 class="text-lg font-medium mr-auto">
                            Profile Layout
                        </h2>
                    </div>
                    <!-- BEGIN: Profile Info -->
                    @if(session('success') || session('status') || session('message'))
                        <div class="mt-5 alert alert-primary show flex items-center mb-2" role="alert">
                            <i data-lucide="alert-circle" class="w-6 h-6 mr-2"></i>
                                {{ session('success') ?? session('status') ?? session('message') }}
                        </div>
                    @endif
                    @error('profile_picture')
                        <div class="mt-5 alert alert-danger show flex items-center mb-2" role="alert">
                            <i data-lucide="alert-octagon" class="w-6 h-6 mr-2"></i>
                                {{ $message }}
                        </div>
                    @enderror
                    <div class="intro-y box px-5 pt-5 mt-5">
                        <div class="flex flex-col lg:flex-row border-b border-slate-200/60 dark:border-darkmode-400 pb-5 -mx-5">
                            <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
                                <div class="w-20 h-20 sm:w-24 sm:h-24 lg:w-32 lg:h-32 image-fit relative">
                                    <img
                                        alt="Avatar"
                                        class="rounded-full w-full h-full object-cover"
                                        src="{{ auth()->user()->profile?->profile_picture
                                            ? asset(auth()->user()->profile->profile_picture)
                                            : asset('dist/images/profile-15.jpg') }}"
                                                                        >

                                        <!-- tombol kamera -->
                                        <div class="absolute bottom-0 right-0 mb-1 mr-1 flex items-center justify-center bg-primary rounded-full p-2 cursor-pointer"
                                            onclick="document.getElementById('avatarInput').click()">
                                            <i class="w-4 h-4 text-white" data-lucide="camera"></i>
                                        </div>

                                        <!-- form upload -->
                                        <form action="{{ route('profile.updatePicture') }}" method="POST" enctype="multipart/form-data" id="avatarForm" >
                                            @csrf
                                            <input
                                                type="file"
                                                id="avatarInput"
                                                name="profile_picture"
                                                class="hidden"
                                                accept="image/*"
                                                onchange="document.getElementById('avatarForm').submit()"
                                            >
                                        </form>
                                    </div>
                                <div class="ml-5">
                                    <div class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg">{{ $user->username }}</div>
                                    <div class="text-slate-500">{{ $user->getRoleNames()->first() }}</div>
                                </div>
                            </div>
                            <div class="mt-6 lg:mt-0 flex-1 px-5 border-l border-r border-slate-200/60 dark:border-darkmode-400 border-t lg:border-t-0 pt-5 lg:pt-0">
                                <div class="font-medium text-center lg:text-left lg:mt-3">Contact Details</div>
                                <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                                    <div class="truncate sm:whitespace-normal flex items-center"> <i data-lucide="mail" class="w-4 h-4 mr-2"></i> {{ $user->name }} </div>
                                    <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-lucide="instagram" class="w-4 h-4 mr-2"></i> {{ $user->email }} </div>
                                        @role('student')
                                        <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-lucide="book" class="w-4 h-4 mr-2"></i>
                                            {{ $user->student?->grade ?? 'N/A' }}
                                        </div>
                                        @endrole

                                        @role('teacher')
                                        <div class="truncate sm:whitespace-normal flex items-center mt-3"> <i data-lucide="book" class="w-4 h-4 mr-2"></i>
                                            {{ $user->teacher?->subject ?? 'N/A' }}
                                        </div>
                                        @endrole
                                </div>
                            </div>
                            <div class="mt-6 lg:mt-0 flex-1 px-5 border-t lg:border-0 border-slate-200/60 dark:border-darkmode-400 pt-5 lg:pt-0">
                                <div class="font-medium text-center lg:text-left lg:mt-5">Sales Growth</div>
                                <div class="flex items-center justify-center lg:justify-start mt-2">
                                    <div class="mr-2 w-20 flex"> USP: <span class="ml-3 font-medium text-success">+23%</span> </div>
                                    <div class="w-3/4">
                                        <div class="h-[55px]">
                                            <canvas class="simple-line-chart-1 -mr-5"></canvas>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex items-center justify-center lg:justify-start">
                                    <div class="mr-2 w-20 flex"> STP: <span class="ml-3 font-medium text-danger">-2%</span> </div>
                                    <div class="w-3/4">
                                        <div class="h-[55px]">
                                            <canvas class="simple-line-chart-2 -mr-5"></canvas>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <ul class="nav nav-link-tabs flex-col sm:flex-row justify-center lg:justify-start text-center" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="javascript:;"
                                class="nav-link py-4 active"
                                data-tw-toggle="tab"
                                data-tw-target="#dashboard"
                                role="tab">
                                Dashboard
                                </a>
                            </li>

                            <li class="nav-item" role="presentation">
                                <a href="javascript:;"
                                class="nav-link py-4"
                                data-tw-toggle="tab"
                                data-tw-target="#account-and-profile"
                                role="tab">
                                Akun Settings
                                </a>
                            </li>

                            <li class="nav-item" role="presentation">
                                <a href="javascript:;"
                                class="nav-link py-4"
                                data-tw-toggle="tab"
                                data-tw-target="#activities"
                                role="tab">
                                Activities
                                </a>
                            </li>

                            <li class="nav-item" role="presentation">
                                <a href="javascript:;"
                                class="nav-link py-4"
                                data-tw-toggle="tab"
                                data-tw-target="#tasks"
                                role="tab">
                                Tasks
                                </a>
                            </li>
                        </ul>

                    </div>
                    <!-- END: Profile Info -->
                    <div class="intro-y tab-content mt-5">
                        <div id="dashboard" class="tab-pane active" role="tabpanel" aria-labelledby="dashboard-tab">
                            <div class="grid grid-cols-12 gap-6">
                                <!-- BEGIN: Top Categories -->
                                <div class="intro-y box col-span-12 lg:col-span-6">
                                    <div class="flex items-center p-5 border-b border-slate-200/60 dark:border-darkmode-400">
                                        <h2 class="font-medium text-base mr-auto">
                                            Top Categories
                                        </h2>
                                        <div class="dropdown ml-auto">
                                            <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i> </a>
                                            <div class="dropdown-menu w-40">
                                                <ul class="dropdown-content">
                                                    <li>
                                                        <a href="" class="dropdown-item"> <i data-lucide="plus" class="w-4 h-4 mr-2"></i> Add Category </a>
                                                    </li>
                                                    <li>
                                                        <a href="" class="dropdown-item"> <i data-lucide="settings" class="w-4 h-4 mr-2"></i> Settings </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="p-5">
                                        <div class="flex flex-col sm:flex-row">
                                            <div class="mr-auto">
                                                <a href="" class="font-medium">Wordpress Template</a>
                                                <div class="text-slate-500 mt-1">HTML, PHP, Mysql</div>
                                            </div>
                                            <div class="flex">
                                                <div class="w-32 -ml-2 sm:ml-0 mt-5 mr-auto sm:mr-5">
                                                    <div class="h-[30px]">
                                                        <canvas class="simple-line-chart-1" data-random="true"></canvas>
                                                    </div>
                                                </div>
                                                <div class="text-center">
                                                    <div class="font-medium">6.5k</div>
                                                    <div class="bg-success/20 text-success rounded px-2 mt-1.5">+150</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex flex-col sm:flex-row mt-5">
                                            <div class="mr-auto">
                                                <a href="" class="font-medium">Bootstrap HTML Template</a>
                                                <div class="text-slate-500 mt-1">HTML, PHP, Mysql</div>
                                            </div>
                                            <div class="flex">
                                                <div class="w-32 -ml-2 sm:ml-0 mt-5 mr-auto sm:mr-5">
                                                    <div class="h-[30px]">
                                                        <canvas class="simple-line-chart-1" data-random="true"></canvas>
                                                    </div>
                                                </div>
                                                <div class="text-center">
                                                    <div class="font-medium">2.5k</div>
                                                    <div class="bg-pending/10 text-pending rounded px-2 mt-1.5">+150</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="flex flex-col sm:flex-row mt-5">
                                            <div class="mr-auto">
                                                <a href="" class="font-medium">Tailwind HTML Template</a>
                                                <div class="text-slate-500 mt-1">HTML, PHP, Mysql</div>
                                            </div>
                                            <div class="flex">
                                                <div class="w-32 -ml-2 sm:ml-0 mt-5 mr-auto sm:mr-5">
                                                    <div class="h-[30px]">
                                                        <canvas class="simple-line-chart-1" data-random="true"></canvas>
                                                    </div>
                                                </div>
                                                <div class="text-center">
                                                    <div class="font-medium">3.4k</div>
                                                    <div class="bg-primary/10 text-primary rounded px-2 mt-1.5">+150</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END: Top Categories -->
                                <!-- BEGIN: Work In Progress -->
                                <div class="intro-y box col-span-12 lg:col-span-6">
                                    <div class="flex items-center px-5 py-5 sm:py-0 border-b border-slate-200/60 dark:border-darkmode-400">
                                        <h2 class="font-medium text-base mr-auto">
                                            Work In Progress
                                        </h2>
                                        <div class="dropdown ml-auto sm:hidden">
                                            <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i> </a>
                                            <div class="nav nav-tabs dropdown-menu w-40" role="tablist">
                                                <ul class="dropdown-content">
                                                    <li> <a id="work-in-progress-mobile-new-tab" href="javascript:;" data-tw-toggle="tab" data-tw-target="#work-in-progress-new" class="dropdown-item" role="tab" aria-controls="work-in-progress-new" aria-selected="true">New</a> </li>
                                                    <li> <a id="work-in-progress-mobile-last-week-tab" href="javascript:;" data-tw-toggle="tab" data-tw-target="#work-in-progress-last-week" class="dropdown-item" role="tab" aria-selected="false">Last Week</a> </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <ul class="nav nav-link-tabs w-auto ml-auto hidden sm:flex" role="tablist" >
                                            <li id="work-in-progress-new-tab" class="nav-item" role="presentation"> <a href="javascript:;" class="nav-link py-5 active" data-tw-target="#work-in-progress-new" aria-controls="work-in-progress-new" aria-selected="true" role="tab" > New </a> </li>
                                            <li id="work-in-progress-last-week-tab" class="nav-item" role="presentation"> <a href="javascript:;" class="nav-link py-5" data-tw-target="#work-in-progress-last-week" aria-selected="false" role="tab" > Last Week </a> </li>
                                        </ul>
                                    </div>
                                    <div class="p-5">
                                        <div class="tab-content">
                                            <div id="work-in-progress-new" class="tab-pane active" role="tabpanel" aria-labelledby="work-in-progress-new-tab">
                                                <div>
                                                    <div class="flex">
                                                        <div class="mr-auto">Pending Tasks</div>
                                                        <div>20%</div>
                                                    </div>
                                                    <div class="progress h-1 mt-2">
                                                        <div class="progress-bar w-1/2 bg-primary" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <div class="mt-5">
                                                    <div class="flex">
                                                        <div class="mr-auto">Completed Tasks</div>
                                                        <div>2 / 20</div>
                                                    </div>
                                                    <div class="progress h-1 mt-2">
                                                        <div class="progress-bar w-1/4 bg-primary" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <div class="mt-5">
                                                    <div class="flex">
                                                        <div class="mr-auto">Tasks In Progress</div>
                                                        <div>42</div>
                                                    </div>
                                                    <div class="progress h-1 mt-2">
                                                        <div class="progress-bar w-3/4 bg-primary" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100"></div>
                                                    </div>
                                                </div>
                                                <a href="" class="btn btn-secondary block w-40 mx-auto mt-5">View More Details</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END: Work In Progress -->
                                <!-- BEGIN: Daily Sales -->
                                <div class="intro-y box col-span-12 lg:col-span-6">
                                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                                        <h2 class="font-medium text-base mr-auto">
                                            Daily Sales
                                        </h2>
                                        <div class="dropdown ml-auto sm:hidden">
                                            <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i> </a>
                                            <div class="dropdown-menu w-40">
                                                <ul class="dropdown-content">
                                                    <li>
                                                        <a href="javascript:;" class="dropdown-item"> <i data-lucide="file" class="w-4 h-4 mr-2"></i> Download Excel </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <button class="btn btn-outline-secondary hidden sm:flex"> <i data-lucide="file" class="w-4 h-4 mr-2"></i> Download Excel </button>
                                    </div>
                                    <div class="p-5">
                                        <div class="relative flex items-center">
                                            <div class="w-12 h-12 flex-none image-fit">
                                                <img alt="Midone - HTML Admin Template" class="rounded-full" src="dist/images/profile-15.jpg">
                                            </div>
                                            <div class="ml-4 mr-auto">
                                                <a href="" class="font-medium">Denzel Washington</a>
                                                <div class="text-slate-500 mr-5 sm:mr-5">Bootstrap 4 HTML Admin Template</div>
                                            </div>
                                            <div class="font-medium text-slate-600 dark:text-slate-500">+$19</div>
                                        </div>
                                        <div class="relative flex items-center mt-5">
                                            <div class="w-12 h-12 flex-none image-fit">
                                                <img alt="Midone - HTML Admin Template" class="rounded-full" src="dist/images/profile-10.jpg">
                                            </div>
                                            <div class="ml-4 mr-auto">
                                                <a href="" class="font-medium">Kevin Spacey</a>
                                                <div class="text-slate-500 mr-5 sm:mr-5">Tailwind HTML Admin Template</div>
                                            </div>
                                            <div class="font-medium text-slate-600 dark:text-slate-500">+$25</div>
                                        </div>
                                        <div class="relative flex items-center mt-5">
                                            <div class="w-12 h-12 flex-none image-fit">
                                                <img alt="Midone - HTML Admin Template" class="rounded-full" src="dist/images/profile-4.jpg">
                                            </div>
                                            <div class="ml-4 mr-auto">
                                                <a href="" class="font-medium">Robert De Niro</a>
                                                <div class="text-slate-500 mr-5 sm:mr-5">Vuejs HTML Admin Template</div>
                                            </div>
                                            <div class="font-medium text-slate-600 dark:text-slate-500">+$21</div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END: Daily Sales -->
                                <!-- BEGIN: Latest Tasks -->
                                <div class="intro-y box col-span-12 lg:col-span-6">
                                    <div class="flex items-center px-5 py-5 sm:py-0 border-b border-slate-200/60 dark:border-darkmode-400">
                                        <h2 class="font-medium text-base mr-auto">
                                            Latest Tasks
                                        </h2>
                                        <div class="dropdown ml-auto sm:hidden">
                                            <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i> </a>
                                            <div class="nav nav-tabs dropdown-menu w-40" role="tablist">
                                                <ul class="dropdown-content">
                                                    <li> <a id="latest-tasks-mobile-new-tab" href="javascript:;" data-tw-toggle="tab" data-tw-target="#latest-tasks-new" class="dropdown-item" role="tab" aria-controls="latest-tasks-new" aria-selected="true">New</a> </li>
                                                    <li> <a id="latest-tasks-mobile-last-week-tab" href="javascript:;" data-tw-toggle="tab" data-tw-target="#latest-tasks-last-week" class="dropdown-item" role="tab" aria-selected="false">Last Week</a> </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <ul class="nav nav-link-tabs w-auto ml-auto hidden sm:flex" role="tablist" >
                                            <li id="latest-tasks-new-tab" class="nav-item" role="presentation"> <a href="javascript:;" class="nav-link py-5 active" data-tw-target="#latest-tasks-new" aria-controls="latest-tasks-new" aria-selected="true" role="tab" > New </a> </li>
                                            <li id="latest-tasks-last-week-tab" class="nav-item" role="presentation"> <a href="javascript:;" class="nav-link py-5" data-tw-target="#latest-tasks-last-week" aria-selected="false" role="tab" > Last Week </a> </li>
                                        </ul>
                                    </div>
                                    <div class="p-5">
                                        <div class="tab-content">
                                            <div id="latest-tasks-new" class="tab-pane active" role="tabpanel" aria-labelledby="latest-tasks-new-tab">
                                                <div class="flex items-center">
                                                    <div class="border-l-2 border-primary dark:border-primary pl-4">
                                                        <a href="" class="font-medium">Create New Campaign</a>
                                                        <div class="text-slate-500">10:00 AM</div>
                                                    </div>
                                                    <div class="form-check form-switch ml-auto">
                                                        <input class="form-check-input" type="checkbox">
                                                    </div>
                                                </div>
                                                <div class="flex items-center mt-5">
                                                    <div class="border-l-2 border-primary dark:border-primary pl-4">
                                                        <a href="" class="font-medium">Meeting With Client</a>
                                                        <div class="text-slate-500">02:00 PM</div>
                                                    </div>
                                                    <div class="form-check form-switch ml-auto">
                                                        <input class="form-check-input" type="checkbox">
                                                    </div>
                                                </div>
                                                <div class="flex items-center mt-5">
                                                    <div class="border-l-2 border-primary dark:border-primary pl-4">
                                                        <a href="" class="font-medium">Create New Repository</a>
                                                        <div class="text-slate-500">04:00 PM</div>
                                                    </div>
                                                    <div class="form-check form-switch ml-auto">
                                                        <input class="form-check-input" type="checkbox">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END: Latest Tasks -->
                                <!-- BEGIN: General Statistic -->
                                <div class="intro-y box col-span-12">
                                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                                        <h2 class="font-medium text-base mr-auto">
                                            General Statistics
                                        </h2>
                                        <div class="dropdown ml-auto sm:hidden">
                                            <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i> </a>
                                            <div class="dropdown-menu w-40">
                                                <ul class="dropdown-content">
                                                    <li>
                                                        <a href="javascript:;" class="dropdown-item"> <i data-lucide="file" class="w-4 h-4 mr-2"></i> Download XML </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </div>
                                        <button class="btn btn-outline-secondary hidden sm:flex"> <i data-lucide="file" class="w-4 h-4 mr-2"></i> Download XML </button>
                                    </div>
                                    <div class="grid grid-cols-1 2xl:grid-cols-7 gap-6 p-5">
                                        <div class="2xl:col-span-2">
                                            <div class="grid grid-cols-2 gap-6">
                                                <div class="col-span-2 sm:col-span-1 2xl:col-span-2 box dark:bg-darkmode-500 p-5">
                                                    <div class="font-medium">Net Worth</div>
                                                    <div class="flex items-center mt-1 sm:mt-0">
                                                        <div class="mr-4 w-20 flex"> USP: <span class="ml-3 font-medium text-success">+23%</span> </div>
                                                        <div class="w-5/6 overflow-auto">
                                                            <div class="h-[51px]">
                                                                <canvas class="simple-line-chart-1" data-random="true"></canvas>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-span-2 sm:col-span-1 2xl:col-span-2 box dark:bg-darkmode-500 p-5">
                                                    <div class="font-medium">Sales</div>
                                                    <div class="flex items-center mt-1 sm:mt-0">
                                                        <div class="mr-4 w-20 flex"> USP: <span class="ml-3 font-medium text-danger">-5%</span> </div>
                                                        <div class="w-5/6 overflow-auto">
                                                            <div class="h-[51px]">
                                                                <canvas class="simple-line-chart-1" data-random="true"></canvas>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-span-2 sm:col-span-1 2xl:col-span-2 box dark:bg-darkmode-500 p-5">
                                                    <div class="font-medium">Profit</div>
                                                    <div class="flex items-center mt-1 sm:mt-0">
                                                        <div class="mr-4 w-20 flex"> USP: <span class="ml-3 font-medium text-danger">-10%</span> </div>
                                                        <div class="w-5/6 overflow-auto">
                                                            <div class="h-[51px]">
                                                                <canvas class="simple-line-chart-1" data-random="true"></canvas>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-span-2 sm:col-span-1 2xl:col-span-2 box dark:bg-darkmode-500 p-5">
                                                    <div class="font-medium">Products</div>
                                                    <div class="flex items-center mt-1 sm:mt-0">
                                                        <div class="mr-4 w-20 flex"> USP: <span class="ml-3 font-medium text-success">+55%</span> </div>
                                                        <div class="w-5/6 overflow-auto">
                                                            <div class="h-[51px]">
                                                                <canvas class="simple-line-chart-1" data-random="true"></canvas>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="2xl:col-span-5 w-full">
                                            <div class="flex justify-center mt-8">
                                                <div class="flex items-center mr-5">
                                                    <div class="w-2 h-2 bg-primary rounded-full mr-3"></div>
                                                    <span>Product Profit</span>
                                                </div>
                                                <div class="flex items-center">
                                                    <div class="w-2 h-2 bg-slate-300 rounded-full mr-3"></div>
                                                    <span>Author Sales</span>
                                                </div>
                                            </div>
                                            <div class="mt-8">
                                                <div class="h-[420px]">
                                                    <canvas id="stacked-bar-chart-1"></canvas>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END: General Statistic -->
                            </div>
                        </div>
                        <div id="account-and-profile" class="tab-pane" role="tabpanel">
                            <div class="mt-5 grid grid-cols-12 gap-6">
                                <div class="intro-y box col-span-12 lg:col-span-12">
                                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                                        <h2 class="font-medium text-base mr-auto flex items-center">
                                            <i data-lucide="user" class="w-4 h-4 mr-2"></i>
                                            Ubah Profile
                                        </h2>
                                        <div class="dropdown ml-auto sm:hidden">
                                            <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i> </a>
                                        </div>
                                    </div>
                                    <div class="border box border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                                        <form method="POST" action="{{ route('profile.updateProfile') }}" class="mt-5">
                                            @csrf
                                            @method('PUT')
                                            {{-- Nama --}}
                                            <div class="form-inline items-start flex-col xl:flex-row">
                                                <div class="form-label xl:w-64 xl:!mr-10">
                                                    <div class="text-left">
                                                        <div class="font-medium">Nama Lengkap</div>
                                                        <div class="leading-relaxed text-slate-500 text-xs mt-3">
                                                            Nama lengkap sesuai dengan identitas resmi Anda.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="w-full mt-3 xl:mt-0 flex-1">
                                                    @error('name')
                                                        <div class="mt-3">
                                                            <label for="input-name" class="form-label">Nama Lengkap</label>
                                                            <input id="input-name" type="text" name="name" class="form-control border-danger" placeholder="Input text" value="{{ old('name', $user->name) }}">
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

                                            {{-- Email --}}
                                            <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5">
                                                <div class="form-label xl:w-64 xl:!mr-10">
                                                    <div class="text-left">
                                                        <div class="font-medium">Email</div>
                                                        <div class="leading-relaxed text-slate-500 text-xs mt-3">
                                                            Email digunakan untuk login dan notifikasi penting.
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="w-full mt-3 xl:mt-0 flex-1">
                                                    @error('email')
                                                        <div class="mt-3">
                                                            <label for="input-email" class="form-label">Email</label>
                                                            <input id="input-email" type="email" name="email" class="form-control border-danger" placeholder="Input email" value="{{ old('email', $user->email) }}">
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
                                                            <label for="input-address" class="form-label">Alamat</label>
                                                            <input id="input-address" type="text" name="address" class="form-control border-danger" placeholder="Input text" value="{{ old('address', $user->profile->address ?? '') }}">
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
                                                            <input id="input-phone" type="text" name="phone_number" class="form-control border-danger" placeholder="Input text" value="{{ old('phone_number', $user->profile->phone_number ?? '') }}">
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
                                            <div class="xl:ml-64 xl:pl-10 mt-8">
                                                <button type="submit" class="btn btn-primary">
                                                    Simpan Perubahan
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <div class="mt-5 grid grid-cols-12 gap-6">
                                <div class="intro-y box col-span-12 lg:col-span-8">
                                    <div class="flex items-center px-5 py-5 sm:py-3 border-b border-slate-200/60 dark:border-darkmode-400">
                                        <h2 class="font-medium text-base mr-auto flex items-center">
                                            <i data-lucide="lock" class="w-4 h-4 mr-2"></i>
                                            Ubah Password
                                        </h2>
                                        <div class="dropdown ml-auto sm:hidden">
                                            <a class="dropdown-toggle w-5 h-5 block" href="javascript:;" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i> </a>
                                        </div>
                                    </div>
                                    <div class="border box border-slate-200/60 dark:border-darkmode-400 rounded-md p-5">
                                        <form method="POST" action="{{ route('profile.updatePassword') }}">
                                            @csrf
                                            @method('PUT')

                                            {{-- Password Lama --}}
                                            <div class="form-inline items-start flex-col xl:flex-row mt-5">
                                                <div class="form-label xl:w-64 xl:!mr-10">
                                                    <div class="text-left">
                                                        <div class="font-medium">Password Lama</div>
                                                        <div class="text-slate-500 text-xs mt-3">
                                                            Masukkan password Anda saat ini
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="w-full mt-3 xl:mt-0 flex-1">
                                                    @error('current_password')
                                                        <div class="mt-3">
                                                            <input id="input-current-password" type="password" name="current_password" class="form-control border-danger" placeholder="Input password">
                                                            <div class="text-danger mt-2">{{ $message }}</div>
                                                        </div>
                                                    @else
                                                        <input
                                                            type="password"
                                                            name="current_password"
                                                            class="form-control"
                                                            required
                                                        >
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- Password Baru --}}
                                            <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5">
                                                <div class="form-label xl:w-64 xl:!mr-10">
                                                    <div class="text-left">
                                                        <div class="font-medium">Password Baru</div>
                                                        <div class="text-slate-500 text-xs mt-3">
                                                            Minimal 8 karakter
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="w-full mt-3 xl:mt-0 flex-1">
                                                    @error('password')
                                                        <div class="mt-3">
                                                            <input id="input-password" type="password" name="password" class="form-control border-danger" placeholder="Input password">
                                                            <div class="text-danger mt-2">{{ $message }}</div>
                                                        </div>
                                                    @else
                                                        <input
                                                            type="password"
                                                            name="password"
                                                            class="form-control"
                                                            required
                                                        >
                                                    @enderror
                                                </div>
                                            </div>

                                            {{-- Konfirmasi Password --}}
                                            <div class="form-inline items-start flex-col xl:flex-row mt-5 pt-5">
                                                <div class="form-label xl:w-64 xl:!mr-10">
                                                    <div class="text-left">
                                                        <div class="font-medium">Konfirmasi Password</div>
                                                    </div>
                                                </div>
                                                <div class="w-full mt-3 xl:mt-0 flex-1">
                                                    @error('password_confirmation')
                                                        <div class="mt-3">

                                                            <input id="input-password-confirmation" type="password" name="password_confirmation" class="form-control border-danger" placeholder="Input password">
                                                            <div class="text-danger mt-2">{{ $message }}</div>
                                                        </div>
                                                    @else
                                                        <input
                                                            type="password"
                                                            name="password_confirmation"
                                                            class="form-control"
                                                            required
                                                        >
                                                    @enderror
                                                </div>
                                            </div>

                                            <div class="xl:ml-64 xl:pl-10 mt-8">
                                                <button type="submit" class="btn btn-primary">
                                                    Ubah Password
                                                </button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <div class="intro-y col-span-12 lg:col-span-4">
                                    <div class=" bg-warning/20 dark:bg-darkmode-600 border border-warning dark:border-0 rounded-md relative p-5">
                                        <i data-lucide="lightbulb" class="w-12 h-12 text-warning/80 absolute top-0 right-0 mt-5 mr-3"></i>
                                        <h2 class="text-lg font-medium">
                                            Tips
                                        </h2>
                                        <div class="mt-5 font-medium">Password</div>
                                        <div class="leading-relaxed text-xs mt-2 text-slate-600 dark:text-slate-500">
                                            <div>        Jika Anda <strong>lupa password</strong> atau tidak dapat masuk ke akun,
        silakan <strong>menghubungi operator atau administrator sekolah</strong>
        untuk melakukan reset password. </div>
                                            <div class="mt-2">        Demi keamanan data, sistem tidak menyediakan fitur reset password
        otomatis melalui email.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
@endsection
