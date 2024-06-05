<div class="relative" x-data="{ open: false }" wire:click="markAllAsRead">
    <button class="relative" @click="open = !open" tabindex="1">
        <svg class="w-6 h-6" fill="none" stroke="currentColor"
             viewBox="0 0 24 24"
             xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                  d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0a3.28 3.28 0 01-3 3 3.28 3.28 0 01-3-3"></path>
        </svg>
        @if($unreadNotifications->count())
            <span
                class="absolute top-0 right-0 inline-flex items-center justify-center px-2 py-1 text-xs font-bold leading-none text-red-100 transform translate-x-1/2 -translate-y-1/2 bg-red-600 rounded-full">
                {{ $unreadNotifications->count() }}
            </span>
        @endif
    </button>
    <div class="absolute right-0 w-80 mt-2 bg-white dark:bg-gray-800 text-gray-800 dark:text-gray-200
    border rounded shadow-xl border-gray-300 dark:border-gray-700 z-10"
         x-show="open"
         @click.away="open = false">
        @forelse($unreadNotifications as $notification)

        @empty
            <x-notification :notification="null" :tabindex="2">
                No unread notifications
            </x-notification>
        @endforelse

        @if($readNotifications->count())
            <x-notification :notification="null" tabindex="3"
                            class="cursor-pointer hover:bg-red-600 bg-red-500 dark:text-gray-200"
                            wire:click="deleteAll">
                <x-danger-button class="w-full">
                    Delete all
                </x-danger-button>
            </x-notification>
        @endif
        @forelse($readNotifications as $notification)
            <x-notification :notification="$notification" tabindex="4"
                            class="cursor-pointer bg-gray-700 dark:text-gray-200 hover:bg-indigo-500"
                            wire:click="delete('{{ $notification->id }}')"
                            href="{{ isset($notification->data['user_id']) ? '/user/profile/#2fa' : '' }}"
            />
        @empty
        @endforelse
    </div>
</div>
