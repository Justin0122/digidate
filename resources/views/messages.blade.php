<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 flex">
            @isset($receiver)
                <livewire:open-chats/>
                <div class="bg-white dark:bg-gray-800 shadow-xl sm:rounded-lg w-full">
                    <livewire:chat-view :$receiver/>
                </div>
            @else
                <h1 class="text-gray-200">Match with somebody to get started!</h1>
            @endisset
        </div>
    </div>
</x-app-layout>
