<x-app-layout>
    <x-slot name="header">
        <h2 class="{{ $user->deleted_at ? 'font-semibold text-xl text-red-800 dark:text-red-500 leading-tight italic' : 'font-semibold text-xl text-gray-800 dark:text-gray-300 leading-tight' }}">
            Profile
        </h2>
    </x-slot>

    <div class="py-12">
        <livewire:profile :userid="request()->route('user')" />
    </div>
</x-app-layout>
