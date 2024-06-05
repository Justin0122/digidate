<div class="h-full">
	<ul class="max-h-[564px] overflow-y-scroll">
		@foreach ($matches as $user)
			<li class="hover:cursor-pointer" x-on:click="$dispatch('open-chat', { user: {{ (int) $user->id }} })">
				<div class="bg-gray-200 rounded-md m-4 mt-0 p-3 dark:bg-gray-800 w-[200px] text-gray-200">
					@php $message = $this->latestMessages[$user->id]; @endphp

					<h3>
						<img
								src="{{ $user->profile->getMedia('pictures')->first()?->getUrl() ?? $user->profile_photo_url }}"
								alt="Profile Photo"
								class="rounded-lg h-6 w-6 object-cover inline mb-1.5"
						>
						<span
							class="hover:cursor-pointer hover:underline"
							wire:click="redirectToUserProfile({{ $user->id }})"
						>{{ Str::limit($user->name, 10) }}</span>
						<span class="float-end" wire:poll.debounce.15s>
							@isset($message->created_at)
								<span class="text-xs text-gray-300">{{ $message->created_at->longRelativeDiffForHumans() }}</span>
							@else
								<span class="text-xs text-gray-300">No messages yet</span>
							@endisset
						</span>
					</h3>

					<div class="my-1 px-2 bg-gray-700 rounded-md overflow-x-clip whitespace-nowrap">
						@isset($message)
							<p>
								<span class="font-bold">{{ $message->sender === $user->id ? $user->name : "You" }}: </span>
								{{ Str::limit($message->content, 14) }}
							</p>
						@else
							<p class="text-gray-200 font-bold overflow-x-hidden">Say hello to {{ Str::limit($user->name, 8) }}!</p>
						@endisset
					</div>
				</div>
			</li>
		@endforeach
	</ul>
</div>