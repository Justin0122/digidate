@props(['notification' => null])
<div>
    @isset($notification)
        <a {{ $attributes->merge(['class' => 'block px-4 py-2 border-gray-300 dark:border-gray-700 border-t hover:text-white cursor-pointer']) }}>
            {{ $notification->data['message'] }}
        </a>
    @else
        <p
            {{ $attributes->merge(['class' => 'block px-4 py-2 bg-gray-900 dark:text-gray-200 border-t border-gray-300 dark:border-gray-700 cursor-default']) }}>
            {{ $slot }}
        </p>
    @endisset
</div>
