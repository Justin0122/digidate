<div class="p-6" id="chat" x-data="{ showModal: false, gifSrc: '' }">
	<div id="messages"
	     class="bg-gray-100 p-6 rounded-lg shadow-lg max-h-[450px] overflow-y-auto dark:bg-gray-700 dark:text-gray-200 mb-3">
		<ul class="divide-y divide-gray-200 dark:divide-gray-800 divide-dashed space-y-2">
			@foreach($this->messages->reverse() as $message)
				<li class=" py-4 rounded-lg px-2 @if($message->sender->id === auth()->id()) justify-end @else bg-gray-200 dark:bg-gray-700 @endif">
					<div class="flex items-start @if($message->sender->id === auth()->id()) flex-row-reverse @endif">
						<div class="flex-shrink-0">
							<img class="h-8 w-8 rounded-full dark:border dark:border-gray-700"
							     src="{{ $message->sender->profile_photo_url }}"
							     alt="{{ $message->sender->name }}">
						</div>
						<div class="flex-1">
							<div
									class="flex items-center justify-between @if($message->sender->id === auth()->id()) mr-2 flex-row-reverse @else ml-2 @endif">
								<h3 class="text-sm font-medium text-gray-900 dark:text-gray-200">{{ $message->sender->name }}</h3>
								<p class="text-sm text-gray-500 dark:text-gray-400"
								   wire:poll.60000ms>
									@if($message->created_at->diffInSeconds() < 60)
										{{ __('Less than a minute ago') }}
									@else
										@if($message->created_at->diffInMonths() > 0)
											{{ $message->created_at->format('M j, Y') }}
											at {{ $message->created_at->format('H:i') }}
										@else
											{{ $message->created_at->diffForHumans() }}
										@endif
									@endif
								</p>
							</div>
							@if($message->content && Str::contains($message->content, '.gif'))
								<div class="grid grid-cols-4 gap-2 mt-2 w-1/2">
									@foreach(explode(' ', $message->content) as $gif)
										@if(Str::endsWith($gif, '.gif'))
											<img src="{{ $gif }}" alt="gif"
											     class="w-48 object-contain @if($message->sender->id === auth()->id()) flex mr-2 ml-auto content-end  @else ml-2 @endif"
											     x-on:click="gifSrc = '{{ $gif }}'; showModal = true;">
										@endif
									@endforeach
								</div>
								<p class="mt-1 text-sm text-gray-700 dark:text-gray-300 @if($message->sender->id === auth()->id()) mr-2 text-right @else ml-2 @endif">
									@foreach(explode(' ', $message->content) as $gif)
										@if(!Str::endsWith($gif, '.gif'))
											{{ $gif }}
										@endif
									@endforeach
								</p>
							@else
								<p class="mt-1 text-sm text-gray-700 dark:text-gray-300 @if($message->sender->id === auth()->id()) mr-2 text-right @else ml-2 @endif">{{ $message->content }}</p>
							@endif
						</div>
					</div>
				</li>
			@endforeach
		</ul>
	</div>

	<livewire:message-box :$receiver/>

	<div class="fixed inset-0 flex items-center justify-center z-50" x-show="showModal" x-on:click="showModal = false"
	     x-on:keydown.escape.window="showModal = false">
		<div class="bg-white rounded-lg shadow-lg">
			<button @click="showModal = false"
			        class="absolute top-0 right-0 m-4 text-gray-500 hover:text-gray-700 focus:outline-none">&times;
			</button>
			<img :src="gifSrc" alt="GIF" class="max-w-full max-h-full">
		</div>
	</div>

	@script
	<script>
        const chat = document.getElementById("chat");

        const messages = chat.querySelector("#messages");

        messages.addEventListener("scroll", function () {
            if (messages.scrollTop !== 0) return;
            $wire.loadMoreMessages();
        });

        Livewire.on("scroll-to-bottom", () => setTimeout(() => {
            let lastMessage = chat.querySelector("ul > li:last-child");
            lastMessage.scrollIntoView({behavior: "smooth", block: "end"});
        }, 100));
	</script>
	@endscript
</div>
