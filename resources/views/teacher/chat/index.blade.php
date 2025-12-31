@extends('layouts.general')
@section('title' , 'Admin Produksi')
@section('page', 'Produksi')
@section('content')
                    <div class="">
                    <div class="intro-y flex flex-col sm:flex-row items-center mt-8">
                        <h2 class="text-lg font-medium mr-auto">
                            Chat
                        </h2>
                    </div>
                    <div class="intro-y chat grid grid-cols-12 gap-5 mt-5">
                        <!-- BEGIN: Chat Side Menu -->
                        <div class="col-span-12 lg:col-span-4 2xl:col-span-3">
                            <div class="intro-y pr-1">
                                <div class="box p-2">
                                    <ul class="nav nav-pills" role="tablist">
                                        <li id="chats-tab" class="nav-item flex-1" role="presentation">
                                            <button class="nav-link w-full py-2 active" data-tw-toggle="pill" data-tw-target="#chats" type="button" role="tab" aria-controls="chats" aria-selected="true" > Chats </button>
                                        </li>
                                        <li id="friends-tab" class="nav-item flex-1" role="presentation">
                                            <button class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#friends" type="button" role="tab" aria-controls="friends" aria-selected="false" > Teman </button>
                                        </li>
                                        <li id="profile-tab" class="nav-item flex-1" role="presentation">
                                            <button class="nav-link w-full py-2" data-tw-toggle="pill" data-tw-target="#profile" type="button" role="tab" aria-controls="profile" aria-selected="false" > Profile </button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="tab-content">
                                <div id="chats" class="tab-pane active" role="tabpanel" aria-labelledby="chats-tab">
                                    <div class="chat__chat-list overflow-y-auto scrollbar-hidden pr-1 pt-1 mt-4">
                                        @php
                                            $groups = $consultations->groupBy(function($c) {
                                                return optional($c->customer)->id ?? $c->customer_id;
                                            });


                                            $customersList = $groups->map(function($group, $customerId) {
                                                $first = $group->sortByDesc('created_at')->first();
                                                return (object)[
                                                    'customer' => $first->customer ?? null,
                                                    'consultation_id' => $first->id,
                                                ];
                                            })->values();
                                        @endphp

                                        @forelse($groups as $customerId => $group)
                                            @php
                                                $firstConsult = $group->first();
                                                $customer = $firstConsult->customer;
                                                $messages = $group->pluck('messages')->flatten(1);
                                                $last = $messages->sortByDesc('created_at')->first();
                                                $unreadCount = $messages->where('is_read', false)->where('sender_id', '!=', auth()->id())->count();
                                                $openConsultation = $group->sortByDesc('created_at')->first();
                                            @endphp

                                            <div class="intro-x cursor-pointer box relative flex items-center p-5 mt-5" data-customer-id="{{ $customerId }}">
                                                <div class="w-12 h-12 flex-none image-fit mr-1">
                                                    <img alt="{{ optional($customer)->name }}" class="rounded-full" src="{{ optional($customer->profile)->avatar ?? asset('dist/images/profile-12.jpg') }}">
                                                    <div class="w-3 h-3 bg-success absolute right-0 bottom-0 rounded-full border-2 border-white dark:border-darkmode-600"></div>
                                                </div>
                                                <div class="ml-2 overflow-hidden">
                                                    <div class="flex items-center">
                                                        <a href="{{ route('teacher.konsultation.chat', ['id' => $openConsultation->id]) }}" class="font-medium load-chat">{{ optional($customer)->name ?? 'Unknown' }}</a>
                                                        <div class="text-xs text-slate-400 ml-2"><span class="chat-last-time">{{ $last ? $last->created_at->diffForHumans() : '' }}</span></div>
                                                    </div>
                                                    <div class="w-full truncate text-slate-500 mt-0.5"><span class="chat-last-text">{{ optional($last)->message_text ?? $firstConsult->subject }}</span></div>
                                                </div>

                                                @if($unreadCount > 0)
                                                    <div class="unread-badge w-5 h-5 flex items-center justify-center absolute top-0 right-0 text-xs text-white rounded-full bg-primary font-medium -mt-1 -mr-1">{{ $unreadCount }}</div>
                                                @else
                                                    <div class="unread-badge" style="display:none"></div>
                                                @endif
                                            </div>
                                        @empty
                                            <div class="text-slate-500 p-4">You have no chats yet. Start a chat with a customer.</div>
                                        @endforelse
                                    </div>
                                </div>
                                <div id="friends" class="tab-pane" role="tabpanel" aria-labelledby="friends-tab">
                                    <div class="pr-1">
                                        <div class="box p-5 mt-5">
                                            <div class="relative text-slate-500">
                                                <input type="text" class="form-control py-3 px-4 border-transparent bg-slate-100 pr-10" placeholder="Search for messages or users...">
                                                <i class="w-4 h-4 hidden sm:absolute my-auto inset-y-0 mr-3 right-0" data-lucide="search"></i>
                                            </div>
                                            <button type="button" class="btn btn-primary w-full mt-3">Invite Friends</button>
                                        </div>
                                    </div>
                                    <div class="chat__user-list overflow-y-auto scrollbar-hidden pr-1 pt-1">
                                        @foreach($customersList ?? [] as $item)
                                            @php $c = $item->customer; $consultationId = $item->consultation_id; @endphp
                                            @if($c)
                                            <div
                                                        onclick="loadChat('{{ route('teacher.konsultation.chat', ['id' => $consultationId]) }}')"
                                                        class="cursor-pointer box relative flex items-center p-5 mt-5 hover:bg-slate-100 transition"
                                                    >
                                                <div class="w-12 h-12 flex-none image-fit mr-1">
                                                    <img alt="{{ $c->name }}" class="rounded-full" src="{{ optional($c->profile)->avatar ?? asset('dist/images/profile-3.jpg') }}">
                                                    <div class="w-3 h-3 bg-success absolute right-0 bottom-0 rounded-full border-2 border-white dark:border-darkmode-600"></div>
                                                </div>
                                                <div class="ml-2 overflow-hidden">
                                                    <div class="flex items-center"> <a href="#" class="font-medium">{{ $c->name }}</a> </div>
                                                    <div class="w-full truncate text-slate-500 mt-0.5">{{ $c->email }}</div>
                                                </div>
                                                <div class="ml-auto flex items-center space-x-2">
                                                    <div class="dropdown">
                                                        <a class="dropdown-toggle w-5 h-5 block" href="#" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-horizontal" class="w-5 h-5 text-slate-500"></i> </a>
                                                    </div>
                                                </div>
                                            </div>
                                            @endif
                                        @endforeach
                                    </div>
                                </div>
                                <div id="profile" class="tab-pane" role="tabpanel" aria-labelledby="profile-tab">
                                    <div class="pr-1">
                                        <div class="box px-5 py-10 mt-5">
                                            <div class="w-20 h-20 flex-none image-fit rounded-full overflow-hidden mx-auto">
                                                <img alt="Midone - HTML Admin Template" src="{{ auth()->user()->profile?->profile_picture
                                            ? asset(auth()->user()->profile->profile_picture)
                                            : asset('dist/images/profile-15.jpg') }}">
                                            </div>
                                            <div class="text-center mt-3">
                                                <div class="font-medium text-lg">{{ auth()->user()->name }}</div>
                                                <div class="text-slate-500 mt-1">{{ auth()->user()->getRoleNames()->first() }}</div>
                                            </div>
                                        </div>
                                        <div class="box p-5 mt-5">
                                            <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 pb-5">
                                                <div>
                                                    <div class="text-slate-500">Alamat</div>
                                                    <div class="mt-1">{{ auth()->user()->profile?->address }}</div>
                                                </div>
                                                <i data-lucide="globe" class="w-4 h-4 text-slate-500 ml-auto"></i>
                                            </div>
                                            <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 py-5">
                                                <div>
                                                    <div class="text-slate-500">Nomor Telfon</div>
                                                    <div class="mt-1">{{ auth()->user()->profile?->phone_number }}</div>
                                                </div>
                                                <i data-lucide="mic" class="w-4 h-4 text-slate-500 ml-auto"></i>
                                            </div>
                                            <div class="flex items-center border-b border-slate-200/60 dark:border-darkmode-400 py-5">
                                                <div>
                                                    <div class="text-slate-500">Email</div>
                                                    <div class="mt-1">{{ auth()->user()->email }}</div>
                                                </div>
                                                <i data-lucide="mail" class="w-4 h-4 text-slate-500 ml-auto"></i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- END: Chat Side Menu -->
                        <!-- BEGIN: Chat Content -->
                        <div class="intro-y col-span-12 lg:col-span-8 2xl:col-span-9">
                            <div class="chat__box box">
                                <!-- BEGIN: Chat Active -->
                                <div class="hidden h-full flex flex-col">
                                    <div class="flex flex-col sm:flex-row border-b border-slate-200/60 dark:border-darkmode-400 px-5 py-4">
                                        <div class="flex items-center">
                                            <div class="w-10 h-10 sm:w-12 sm:h-12 flex-none image-fit relative">
                                                <img alt="Midone - HTML Admin Template" class="rounded-full" src="dist/images/profile-3.jpg">
                                            </div>
                                            <div class="ml-3 mr-auto">
                                                <div class="font-medium text-base">Tom Cruise</div>
                                                <div class="text-slate-500 text-xs sm:text-sm">Hey, I am using chat <span class="mx-1">•</span> Online</div>
                                            </div>
                                        </div>
                                        <div class="flex items-center sm:ml-auto mt-5 sm:mt-0 border-t sm:border-0 border-slate-200/60 pt-3 sm:pt-0 -mx-5 sm:mx-0 px-5 sm:px-0">
                                            <a href="javascript:;" class="w-5 h-5 text-slate-500"> <i data-lucide="search" class="w-5 h-5"></i> </a>
                                            <a href="javascript:;" class="w-5 h-5 text-slate-500 ml-5"> <i data-lucide="user-plus" class="w-5 h-5"></i> </a>
                                            <div class="dropdown ml-auto sm:ml-3">
                                                <a href="javascript:;" class="dropdown-toggle w-5 h-5 text-slate-500" aria-expanded="false" data-tw-toggle="dropdown"> <i data-lucide="more-vertical" class="w-5 h-5"></i> </a>
                                                <div class="dropdown-menu w-40">
                                                    <ul class="dropdown-content">
                                                        <li>
                                                            <a href="" class="dropdown-item"> <i data-lucide="share-2" class="w-4 h-4 mr-2"></i> Share Contact </a>
                                                        </li>
                                                        <li>
                                                            <a href="" class="dropdown-item"> <i data-lucide="settings" class="w-4 h-4 mr-2"></i> Settings </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                                <!-- END: Chat Active -->
                                <!-- BEGIN: Chat Default -->
                                <div class="h-full flex items-center">
                                    <div class="mx-auto text-center">
                                        <div class="w-16 h-16 flex-none image-fit rounded-full overflow-hidden mx-auto">
                                            <img alt="Midone - HTML Admin Template" src="{{ auth()->user()->profile?->profile_picture
                                            ? asset(auth()->user()->profile->profile_picture)
                                            : asset('dist/images/profile-15.jpg') }}">
                                        </div>
                                        <div class="mt-3">
                                            <div class="font-medium">Hallo , {{ auth()->user()->name }}</div>
                                            <div class="text-slate-500 mt-1">Silakan pilih obrolan untuk mulai berkirim pesan.</div>
                                        </div>
                                    </div>
                                </div>
                                <!-- END: Chat Default -->
                            </div>
                        </div>
                        <!-- END: Chat Content -->
                    </div>
                </div>
@endsection
@push('scripts')
<script>

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

    function clearUnreadByLink(url) {
    document.querySelectorAll('.intro-x.cursor-pointer.box').forEach(card => {
        const link = card.querySelector('a.load-chat');
        if (!link) return;

        if (link.href === url) {
            const badge = card.querySelector('.unread-badge');
            if (badge) {
                badge.style.display = 'none';
                badge.textContent = '';
            }
        }
    });
}

    function loadChat(url) {
        clearUnreadByLink(url);

        fetch(url, {headers: {'X-Requested-With': 'XMLHttpRequest'}})
            .then(r => r.text())
            .then(html => {
                const box = document.querySelector('.chat__box');
                try {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newBox = doc.querySelector('.chat__box');

                    if (newBox && box) {
                        // Replace the whole box element to avoid nested .chat__box elements
                        box.replaceWith(newBox);
                        // Ensure page scrolls to the new box
                        const el = document.querySelector('.chat__box');
                        if (el) window.scrollTo({ top: el.getBoundingClientRect().top + window.scrollY - 100, behavior: 'smooth' });
                        return;
                    }
                } catch (e) {
                    // Fallback: inject inner HTML if parsing fails
                }

                if (box) {
                    box.innerHTML = html;
                    window.scrollTo({ top: box.getBoundingClientRect().top + window.scrollY - 100, behavior: 'smooth' });
                }
            })
            .catch(err => console.error('Failed to load chat:', err));
    }

    document.addEventListener('DOMContentLoaded', function() {
        document.querySelectorAll('a.load-chat').forEach(a => {
            a.addEventListener('click', function(e) {
                e.preventDefault();
                loadChat(this.href);
            });
        });
    });

    document.addEventListener('click', function (e) {
        const card = e.target.closest('.intro-x.cursor-pointer.box');
        if (!card) return;

        if (e.target.closest('a') || e.target.closest('button')) return;

        const link = card.querySelector('a.load-chat');
        if (link) {
            e.preventDefault();
            loadChat(link.href);
        }
    });


    function refreshChatList() {
        fetch('{{ route('teacher.konsultation') }}', { headers: {'X-Requested-With': 'XMLHttpRequest'} })
            .then(r => r.text())
            .then(html => {
                try {
                    const parser = new DOMParser();
                    const doc = parser.parseFromString(html, 'text/html');
                    const newList = doc.querySelector('.chat__chat-list');
                    const oldList = document.querySelector('.chat__chat-list');
                    if (!newList || !oldList) return;

                    // For each new card, update only the text/time/unread parts of the existing card
                    newList.querySelectorAll('.intro-x.cursor-pointer.box[data-student-id]').forEach(newCard => {
                        const studentId = newCard.getAttribute('data-student-id');
                        const oldCard = oldList.querySelector(`.intro-x.cursor-pointer.box[data-student-id="${studentId}"]`);
                        if (!oldCard) return;

                        // Update link href (so opening group opens the latest consultation)
                        const newLink = newCard.querySelector('a.load-chat');
                        const oldLink = oldCard.querySelector('a.load-chat');
                        if (newLink && oldLink) oldLink.href = newLink.href;

                        // Update last time text
                        const newTime = newCard.querySelector('.chat-last-time')?.textContent || '';
                        const oldTimeEl = oldCard.querySelector('.chat-last-time');
                        if (oldTimeEl && oldTimeEl.textContent !== newTime) oldTimeEl.textContent = newTime;

                        // Update last message text
                        const newText = newCard.querySelector('.chat-last-text')?.textContent || '';
                        const oldTextEl = oldCard.querySelector('.chat-last-text');
                        if (oldTextEl && oldTextEl.textContent !== newText) oldTextEl.textContent = newText;

                        // Update unread badge
                        const newBadge = newCard.querySelector('.unread-badge');
                        const oldBadge = oldCard.querySelector('.unread-badge');
                        const newCount = newBadge ? parseInt(newBadge.textContent) || 0 : 0;
                        if (newCount > 0) {
                            if (oldBadge) {
                                oldBadge.textContent = newCount;
                                oldBadge.style.display = '';
                                oldBadge.classList.add('w-5','h-5','flex','items-center','justify-center','absolute','top-0','right-0','text-xs','text-white','rounded-full','bg-primary','font-medium','-mt-1','-mr-1');
                            }
                        } else {
                            if (oldBadge) {
                                oldBadge.style.display = 'none';
                                oldBadge.textContent = '';
                            }
                        }
                    });

                } catch (err) {
                    console.error('Failed to refresh chat list:', err);
                }
            })
            .catch(err => console.error('Failed to refresh chat list:', err));
    }

    // start polling every 7 seconds
    setInterval(refreshChatList, 7000);
    document.addEventListener('submit', function (e) {
        if (!e.target.matches('#sendMessageForm')) return;

        e.preventDefault();

        const form = e.target;
        const chatBox = document.querySelector('.chat__box');
        let consultationId = chatBox?.dataset.consultationId;
        if (!consultationId) {
            try {
                const url = new URL(form.action, window.location.origin);
                const parts = url.pathname.split('/').filter(Boolean);
                for (let i = parts.length - 1; i >= 0; i--) {
                    if (/^\d+$/.test(parts[i])) {
                        consultationId = parts[i];
                        break;
                    }
                }
            } catch (err) {
                console.error('Cannot determine consultation ID:', err);
            }
        }

        if (!consultationId) return;

        const formData = new FormData(form);

        fetch(form.action, {
            method: 'POST',
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'X-CSRF-TOKEN': form.querySelector('input[name=_token]').value
            },
            body: formData
        })
        .then(() => {
            loadChat(`/teacher/konsultation/${consultationId}/chat`);
            form.reset();
        })
        .catch(err => console.error(err));
    });
</script>
@endpush

