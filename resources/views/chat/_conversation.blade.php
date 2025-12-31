@php
    $profilePicture = null;
    $authUser = auth()->user();

    if ($authUser->hasRole('teacher')) {
        $chatUser = $consultation->customer;
        $profilePicture = optional($chatUser?->profile)->profile_picture;
    } else {
        $chatUser = $consultation->teacher;
        $profilePicture = optional($chatUser?->profile)->profile_picture;
    }

    if ($authUser->hasRole('teacher')) {
        $chatUser = $consultation->customer;
    } else {
        $chatUser = $consultation->teacher;
    }

    $chatProfile = optional($chatUser?->profile);
@endphp

<div class="chat__box box flex flex-col h-[75vh]" data-consultation-id="{{ $consultation->id }}">

    <div class="flex flex-col sm:flex-row border-b border-slate-200/60 dark:border-darkmode-400 px-5 py-4">
        <div class="flex items-center">
            <div class="w-10 h-10 sm:w-12 sm:h-12 flex-none image-fit relative">
                <img class="rounded-full"
                     src="{{ $profilePicture ? asset($profilePicture) : asset('dist/images/profile-15.jpg') }}">
            </div>
            <div class="ml-3 mr-auto">
                <div class="font-medium text-base">{{ $chatUser?->name ?? 'Unknown User' }}</div>
                    @if(auth()->user()->hasRole('customer'))
                        <div class="text-xs">
                            {{ $chatUser?->teacher?->major?->name ?? 'Unknown Major' }}
                        </div>
                    @endif
            </div>
        </div>
    </div>

    <div class="flex-1 overflow-y-auto px-5 pt-5">

        <div class="space-y-4">
            @foreach ($consultation->messages->sortBy('created_at') as $m)

                @if ($m->sender_id !== auth()->id())
                    {{-- MESSAGE KIRI --}}
                    <div class="chat__box__text-box flex items-end float-left mb-4">
                        <div class="w-10 h-10 hidden sm:block flex-none image-fit relative mr-5">
                            <img class="rounded-full"
                                 src="{{ optional($m->sender?->profile)->profile_picture
                                    ? asset($m->sender->profile->profile_picture)
                                    : asset('dist/images/profile-3.jpg') }}">
                        </div>

                        <div class="bg-slate-100 dark:bg-darkmode-400 px-4 py-3 text-slate-500 rounded-r-md rounded-t-md">
                            {{ $m->message_text }}
                            <div class="mt-1 text-xs text-slate-500">
                                {{ $m->created_at->diffForHumans() }}
                            </div>
                        </div>
                    </div>
                    <div class="clear-both"></div>

                @else
                    {{-- MESSAGE KANAN --}}
                    <div class="chat__box__text-box flex items-end float-right mb-4">
                        <div class="bg-primary px-4 py-3 text-white rounded-l-md rounded-t-md">
                            {{ $m->message_text }}
                            <div class="mt-1 text-xs text-white text-opacity-80">
                                {{ $m->created_at->diffForHumans() }}
                            </div>
                        </div>

                        <div class="w-10 h-10 hidden sm:block flex-none image-fit relative ml-5">
                            <img class="rounded-full"
                                 src="{{ auth()->user()->profile?->profile_picture
                                    ? asset(auth()->user()->profile->profile_picture)
                                    : asset('dist/images/profile-12.jpg') }}">
                        </div>
                    </div>
                    <div class="clear-both"></div>
                @endif

            @endforeach
        </div>

    </div>

    <div class="border-t border-slate-200/60 dark:border-darkmode-400 px-4">
        <form id="sendMessageForm" action="{{ route('konsultation.message.store', $consultation->id) }}"
              method="POST"
              enctype="multipart/form-data"
              class="relative">
            @csrf

            <div class="pt-4 pb-6 sm:py-4 flex items-center">

                <textarea
                    name="message_text"
                    class="chat__box__input form-control dark:bg-darkmode-600 h-16 resize-none border-transparent px-5 py-3 shadow-none focus:border-transparent focus:ring-0"
                    rows="1"
                    placeholder="Type your message..."
                    required
                ></textarea>

                <div class="flex absolute sm:static left-0 bottom-0 ml-5 sm:ml-0 mb-5 sm:mb-0">
                    <div class="w-4 h-4 sm:w-5 sm:h-5 relative text-slate-500 mr-3 sm:mr-5">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
  <path d="M21.44 11.05l-9.19 9.19a6 6 0 0 1-8.49-8.49l9.19-9.19a4 4 0 0 1 5.66 5.66l-9.2 9.19a2 2 0 0 1-2.83-2.83l8.49-8.48"></path>
</svg>
                        <input type="file" name="attachment"
                               class="w-full h-full top-0 left-0 absolute opacity-0 cursor-pointer">
                    </div>
                </div>

                <button type="submit"
                        class="w-8 h-8 sm:w-10 sm:h-10 bg-primary text-white rounded-full flex items-center justify-center mr-5">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
  <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"></path>
</svg>
                </button>

            </div>
        </form>
    </div>

</div>
