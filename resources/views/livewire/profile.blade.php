<div class="md:grid md:grid-cols-9 text-gray-700 dark:text-gray-200">
    <div class="filters bg-white dark:bg-gray-800 p-6 flex flex-col max-w-sm col-span-2 rounded-lg relative">
        <div class="">
            <div id="total">
                Total found: {{ $totalUsers }}
            </div>
        </div>
        <x-section-border />

        <form wire:submit="applyFilters">
            <label for="min_age_range" class="mr-2">Min age:</label>
            <div class="flex items-center">
                <input type="range" id="min_age_range" name="min_age_range" min="18" max="100"
                       class="px-2 py-1 border border-gray-300 rounded-md w-3/4" wire:model.live="min_age">
                <span id="min_age_range_value" class="ml-2">{{ $min_age }}
            </div>
            <label for="max_age_range" class="mr-2">Max age:</label>
            <div class="flex items-center">
                <input type="range" id="max_age_range" name="max_age_range" min="18" max="100"
                       wire:model.live="max_age"
                       class="px-2 py-1 border border-gray-300 rounded-md w-3/4">
                <span id="max_age_range_value" class="ml-2">{{ $max_age }}</span>
            </div>
            <x-section-border />

            <label for="tags_amount" class="mr-2">Tags in common:</label>
            <div class="flex items-center">
                <input type="range" id="tags_amount" name="tags_amount" min="0"
                       class="px-2 py-1 border border-gray-300 rounded-md w-3/4"
                       max="{{ Auth::user()->profile->tags ? count(Auth::user()->profile->tags) : 0 }}"
                       wire:model.live="tags_amount">
                <span id="tags_amount_value" class="ml-2">{{ $tags_amount }}</span>
            </div>
            <x-section-border />

            <div class="flex items-center">
                <input type="text" id="city" name="city" wire:model.live="searchCity"
                       class="px-2 py-1 border border-gray-300 rounded-md mb-2 w-3/4" placeholder="Search City" />

                <div wire:click="selectCity('')"
                     class="cursor-pointer hover:text-red-500 dark:hover:text-red-500 border border-red-500 rounded p-1 hover:bg-red-100 dark:hover:bg-red-900 w-8 h-8 flex justify-center items-center ml-2"
                     title="click to unset">
                    <div class="text-red-500">X</div>
                </div>
            </div>

            @if(!empty($searchCity))
                <div class="flex flex-col">
                    @foreach($cities as $city)
                        <div x-data="{ show: false }"
                             x-init="setTimeout(() => show = true, {{ $loop->index * 100 }})"
                             x-show="show"
                             x-transition:enter="transition ease-out duration-500"
                             x-transition:enter-start="transform opacity-0 -translate-x-2"
                             x-transition:enter-end="transform opacity-100 translate-x-0"
                             wire:click="selectCity(`{{ $city }}`)" tabindex="0"
                             class="cursor-pointer hover:bg-gray-100 dark:hover:bg-gray-700 p-2 rounded-md">
                            {{ $city }}
                        </div>
                    @endforeach
                </div>
                @if (count($cities) == 0)
                    <div class="p-2">No cities found</div>
                @endif
            @endif
            <x-section-border />

            <div class="flex items-center pt-5">

                <button type="submit"
                        class="mt-3 bg-blue-500 hover:bg-blue-700 text-white py-2 px-2 font-bold px-4 rounded focus:outline-none focus:shadow-outline w-full dark:bg-gray-700 dark:hover:bg-gray-800 dark:text-gray-200 inset-x-0 bottom-0 absolute">
                    Apply
                </button>

            </div>

        </form>
    </div>

    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 col-span-7">
        @if(!$user)
            <div class="p-6 sm:px-20 my-10">
                <h1 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">No user found</h1>
            </div>
        @else
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="flex flex-col md:grid md:grid-cols-10 md:gap-4 mt-10">
                    <div class="p-6 sm:px-20 bg-white dark:bg-gray-800 mt-10 col-span-3">
                        <ul class="text-gray-700 dark:text-gray-200 space-y-2 cursor-default">
                            <li class="flex flex-row"> Gender:
                                {{ $user->profile->gender->name }}

                            </li>
                            @if(auth()->id() == $user->id)
                                @if(isset($form['straight']))
                                    <div class="flex flex-row">
                                        <label for="straight" class="mr-2">Sexuality:</label>
                                        <select wire:model="form.straight"
                                                class="w-full p-3 border border-gray-300 rounded-md bg-gray-100 dark:bg-gray-700 dark:border-gray-600 text-gray-700 dark:text-gray-200 focus:outline-none focus:border-blue-500">
                                            <option value="1">Straight</option>
                                            <option value="2">Gay</option>
                                            <option value="0">Bisexual</option>
                                        </select>
                                    </div>

                                @else
                                    <div class="flex flex-row">
                                        <label for="straight" class="mr-2">Sexuality:</label>
                                        <select wire:model="form.straight"
                                                class="w-full p-3 border border-gray-300 rounded-md bg-gray-100 dark:bg-gray-700 dark:border-gray-600 text-gray-700 dark:text-gray-200 focus:outline-none focus:border-blue-500">
                                            <option value="1">Straight</option>
                                            <option value="2">Gay</option>
                                            <option value="0">Bisexual</option>
                                        </select>
                                    </div>

                                @endif
                            @else
                                Sexuality:
                                @if(isset($profile['straight']))
                                    {{ $profile['straight'] == 1 ? 'Straight' : 'Gay' }}
                                @else
                                    Bisexual
                                    @endif
                                    @endif
                                    </li>
                                    <li class="flex flex-row"> City:
                                        {{ $user->profile->city }}
                                    </li>
                                    <li class="flex flex-row">
                                        Age:
                                        {{ $age }}
                                    </li>
                        </ul>
                    </div>

                    <div
                        class="col-span-2 bg-white dark:bg-gray-800 dark:border-gray-700">
                        <h1 class="text-2xl font-semibold text-gray-800 dark:text-white">{{ $user->name }} {{ $user->insertion }} {{ $user->lastname }}</h1>

                        <img
                            src="{{ $media->first()?->getUrl() ?? $user->profile_photo_url }}"
                            alt="Profile Photo"
                            class="rounded-lg h-36 w-36 mt-4 object-cover">
                    </div>

                    <div
                        class="p-6 sm:px-20 bg-white dark:bg-gray-800 pt-10 @if($user->id == auth()->id()) col-span-5 @else col-span-3 @endif">
                        <h1 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">About Me</h1>
                        @if(auth()->id() == $user->id)
                            <p class="text-gray-700 dark:text-gray-200">Tell us something about yourself.</p>
                            <form wire:submit.prevent="save">

                                <div x-data="{ charCount: {{ strlen($form['bio']) }} }">
                <textarea
                    x-data
                    x-on:input="charCount = $event.target.value.length"
                    class="w-full p-3 border border-gray-300 rounded-md bg-gray-100 dark:bg-gray-700 dark:border-gray-600 text-gray-700 dark:text-gray-200 focus:outline-none focus:border-blue-500"
                    wire:model="form.bio"
                    maxlength="100"
                ></textarea>
                                    <x-input-error for="form.bio" class="mt-2" />

                                    <span class="text-right text-sm text-gray-500" x-text="charCount + '/100'"></span>
                                </div>
                                <div class="text-right">
                                    <x-action-message class="me-3" on="saved">
                                        {{ __('Saved.') }}
                                    </x-action-message>
                                    <button type="submit"
                                            class="mt-3 bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        Save
                                    </button>
                                </div>
                            </form>
                        @else
                            <p class="text-gray-700 dark:text-gray-200">{{ $profile['bio'] }}</p>
                        @endif
                    </div>

                    <div class="col-span-1">
                        @if(auth()->id() !== $user->id && $user->deleted_at === null)
                            <div class="flex flex-row">
                                <button wire:click="dislike"
                                        class="text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                    <svg width="64px" height="64px" viewBox="0 0 24 24" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path opacity="0.1"
                                              d="M10.5021 19.3071L4.8824 12.9557C3.20947 11.0649 2.3404 8.6871 3.59728 6.41967C5.04945 3.79992 7.71053 3.26448 10.0229 5.02375C10.818 5.62861 11.4706 6.31934 11.7893 6.67771C11.8268 6.71986 11.8745 6.74774 11.9255 6.76135C11.8514 6.78454 11.7892 6.84173 11.7628 6.92094L10.7628 9.92094C10.7384 9.99413 10.7492 10.0745 10.792 10.1387L12.6995 13L10.792 15.8613C10.7513 15.9223 10.7395 15.9982 10.7596 16.0687L11.75 19.535V19.9663C11.2865 19.9083 10.8397 19.6886 10.5021 19.3071Z"
                                              fill="#000000" />
                                        <path
                                            d="M4.8824 12.9557L10.5021 19.3071C11.2981 20.2067 12.7019 20.2067 13.4979 19.3071L19.1176 12.9557C20.7905 11.0649 21.6596 8.6871 20.4027 6.41967C18.9505 3.79992 16.2895 3.26448 13.9771 5.02375C13.182 5.62861 12.5294 6.31934 12.2107 6.67771C12.1 6.80224 11.9 6.80224 11.7893 6.67771C11.4706 6.31934 10.818 5.62861 10.0229 5.02375C7.71053 3.26448 5.04945 3.79992 3.59728 6.41967C2.3404 8.6871 3.20947 11.0649 4.8824 12.9557Z"
                                            stroke="#000000" stroke-width="2" stroke-linejoin="round" />
                                        <path d="M12 7L11 10L13 13L11 16L12 19.5" stroke="#000000" stroke-width="2"
                                              stroke-linecap="round"
                                              stroke-linejoin="round" />
                                    </svg>
                                </button>
                                @if($liked)
                                    <button wire:click="unlike"
                                            class="text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        <svg id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                             xmlns:xlink="http://www.w3.org/1999/xlink"
                                             width="64px" height="64px"
                                             viewBox="0 0 64 64"
                                             xml:space="preserve">
                    <g>
                        <path fill="#F76D57" d="M58.714,29.977c0,0-0.612,0.75-1.823,1.961S33.414,55.414,33.414,55.414C33.023,55.805,32.512,56,32,56
                            s-1.023-0.195-1.414-0.586c0,0-22.266-22.266-23.477-23.477s-1.823-1.961-1.823-1.961C3.245,27.545,2,24.424,2,21
                            C2,13.268,8.268,7,16,7c3.866,0,7.366,1.566,9.899,4.101l0.009-0.009l4.678,4.677c0.781,0.781,2.047,0.781,2.828,0l4.678-4.677
                            l0.009,0.009C40.634,8.566,44.134,7,48,7c7.732,0,14,6.268,14,14C62,24.424,60.755,27.545,58.714,29.977z" />
                        <path fill="#F76D57" d="M58.714,29.977c0,0-0.612,0.75-1.823,1.961S33.414,55.414,33.414,55.414C33.023,55.805,32.512,56,32,56
                            s-1.023-0.195-1.414-0.586c0,0-22.266-22.266-23.477-23.477s-1.823-1.961-1.823-1.961C3.245,27.545,2,24.424,2,21
                            C2,13.268,8.268,7,16,7c3.866,0,7.366,1.566,9.899,4.101l0.009-0.009l4.678,4.677c0.781,0.781,2.047,0.781,2.828,0l4.678-4.677
                            l0.009,0.009C40.634,8.566,44.134,7,48,7c7.732,0,14,6.268,14,14C62,24.424,60.755,27.545,58.714,29.977z" />
                        <g>
                            <path fill="#394240" d="M48,5c-4.418,0-8.418,1.791-11.313,4.687l-3.979,3.961c-0.391,0.391-1.023,0.391-1.414,0
                                c0,0-3.971-3.97-3.979-3.961C24.418,6.791,20.418,5,16,5C7.163,5,0,12.163,0,21c0,3.338,1.024,6.436,2.773,9
                                c0,0,0.734,1.164,1.602,2.031s24.797,24.797,24.797,24.797C29.953,57.609,30.977,58,32,58s2.047-0.391,2.828-1.172
                                c0,0,23.93-23.93,24.797-24.797S61.227,30,61.227,30C62.976,27.436,64,24.338,64,21C64,12.163,56.837,5,48,5z M58.714,29.977
                                c0,0-0.612,0.75-1.823,1.961S33.414,55.414,33.414,55.414C33.023,55.805,32.512,56,32,56s-1.023-0.195-1.414-0.586
                                c0,0-22.266-22.266-23.477-23.477s-1.823-1.961-1.823-1.961C3.245,27.545,2,24.424,2,21C2,13.268,8.268,7,16,7
                                c3.866,0,7.366,1.566,9.899,4.101l0.009-0.009l4.678,4.677c0.781,0.781,2.047,0.781,2.828,0l4.678-4.677l0.009,0.009
                                C40.634,8.566,44.134,7,48,7c7.732,0,14,6.268,14,14C62,24.424,60.755,27.545,58.714,29.977z" />
                            <path fill="#394240" d="M48,11c-0.553,0-1,0.447-1,1s0.447,1,1,1c4.418,0,8,3.582,8,8c0,0.553,0.447,1,1,1s1-0.447,1-1
                                C58,15.478,53.522,11,48,11z" />
                        </g>
                    </g>
                    </svg>
                                    </button>
                                @else
                                    <button wire:click="like"
                                            class=" text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                        <svg id="Layer_1" xmlns="http://www.w3.org/2000/svg"
                                             xmlns:xlink="http://www.w3.org/1999/xlink"
                                             width="64px" height="64px"
                                             viewBox="0 0 64 64"
                                             class="animate"
                                             xml:space="preserve">
                    <path fill="#000000" d="M48,5c-4.418,0-8.418,1.791-11.313,4.687l-3.979,3.961c-0.391,0.391-1.023,0.391-1.414,0
                        c0,0-3.971-3.97-3.979-3.961C24.418,6.791,20.418,5,16,5C7.163,5,0,12.163,0,21c0,3.338,1.024,6.436,2.773,9
                        c0,0,0.734,1.164,1.602,2.031s24.797,24.797,24.797,24.797C29.953,57.609,30.977,58,32,58s2.047-0.391,2.828-1.172
                        c0,0,23.93-23.93,24.797-24.797S61.227,30,61.227,30C62.976,27.436,64,24.338,64,21C64,12.163,56.837,5,48,5z M57,22
                        c-0.553,0-1-0.447-1-1c0-4.418-3.582-8-8-8c-0.553,0-1-0.447-1-1s0.447-1,1-1c5.522,0,10,4.478,10,10C58,21.553,57.553,22,57,22z" />
                    </svg>
                                    </button>
                                @endif
                            </div>
                            @error('like') <p class="text-red-500">{{ $message }}</p> @enderror
                        @endif
                    </div>


                    <div
                        class="p-6 sm:px-20 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 col-span-10 relative">
                        <h1 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">Tags</h1>
                        <div class="flex flex-wrap mt-2">
                            @foreach($user->profile->tags as $tag)
                                <span
                                    class="inline-block rounded-full px-3 py-1 text-sm font-semibold mr-2 mb-2 text-gray-700 dark:text-gray-700"
                                    style="background-color: {{ $tag['color'] }};"
                                >
                            {{ $tag['name'] }}
                                    @if (auth()->id() == $user->id)
                                        <button wire:click="removeTag('{{ $tag['id'] }}')"
                                                class="text-red-500 bg-gray-300 dark:bg-gray-600 dark:text-red-500 rounded-full px-1 ml-2 w-5 h-5 text-center">
                                            x
                                        </button>
                                    @endif
                        </span>
                            @endforeach
                            @if(count($user->profile->tags) == 0)
                                <p class="text-gray-700 dark:text-gray-200">No tags yet.</p>
                            @endif
                            <div x-data="{ showModal: false }">
                                <!-- Button to toggle modal -->
                                @if(count($user->profile->tags) < 5 && $user->id == auth()->id())
                                    <button @click="showModal = true"
                                            class="bg-blue-500 hover:bg-blue-700 text-white font-bold px-4 rounded focus:outline-none focus:shadow-outline">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                  d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                        </svg>
                                    </button>
                                @endif

                                <!-- Modal -->
                                <div x-show="showModal" class="fixed z-10 inset-0 overflow-y-auto"
                                     aria-labelledby="modal-title"
                                     x-on:keydown.escape.window="showModal = false"
                                     x-on:click.stop.outside="showModal = false"
                                     role="dialog" aria-modal="true">
                                    <div
                                        class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                                        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity"
                                             aria-hidden="true"></div>
                                        <span class="hidden sm:inline-block sm:align-middle sm:h-screen"
                                              aria-hidden="true">&#8203;</span>
                                        <div x-show="showModal"
                                             class="inline-block align-bottom bg-white dark:bg-gray-800 rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full"
                                             role="dialog" aria-modal="true" aria-labelledby="modal-headline">
                                            <div class="bg-white dark:bg-gray-800 px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                                                <div class="sm:flex sm:items-start">
                                                    <div
                                                        class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left w-full">
                                                        <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-gray-200"
                                                            id="modal-headline">
                                                            Add Tag
                                                        </h3>
                                                        <div class="mt-2">
                                                            <div class="mt-2 flex items-center space-x-2">
                                                                <x-input type="text" wire:model.live="search"
                                                                         class="w-full p-3 border border-gray-300 rounded-md bg-gray-100 dark:bg-gray-700 dark:border-gray-600 text-gray-700 dark:text-gray-200 focus:outline-none focus:border-blue-500"
                                                                         placeholder="Search for a tag" />
                                                                <select wire:model.live="maxTags"
                                                                        class="w-1/6 p-3 border border-gray-300 rounded-md bg-gray-100 dark:bg-gray-700 dark:border-gray-600 text-gray-700 dark:text-gray-200 focus:outline-none focus:border-blue-500">
                                                                    <option value="10">10</option>
                                                                    <option value="25">25</option>
                                                                    <option value="50">50</option>
                                                                    <option value="100">100</option>
                                                                    <option value="all">all</option>
                                                                </select>
                                                            </div>
                                                            <span
                                                                class="text-right text-sm text-gray-500">Total tags: {{ $totalTags }}</span>
                                                            <x-action-message
                                                                class="me-3 text-red-500 dark:text-red-500"
                                                                on="error">
                                                                {{ __('You already have 5 tags.') }}
                                                            </x-action-message>
                                                            <div class="flex flex-wrap mt-2">
                                                                @foreach($searchTags as $index => $tag)
                                                                    <div x-data="{ show: false }"
                                                                         x-init="setTimeout(() => show = true, {{ $loop->index * 50 }})"
                                                                         x-show="show"
                                                                         x-transition:enter="transition ease-out duration-500"
                                                                         x-transition:enter-start="transform opacity-0 -translate-x-2"
                                                                         x-transition:enter-end="transform opacity-100 translate-x-0"
                                                                    >
            <span
                class="tag-animation inline-block rounded-full px-3 py-1 text-sm font-semibold mr-2 mb-2 text-gray-700 dark:text-gray-700"
                style="background-color: {{ $tag['color'] }};"
            >
                {{ $tag['name'] }}
                <button wire:click="addTag({{ $tag['id'] }})"
                        class="text-blue-500 bg-gray-300 dark:bg-gray-600 dark:text-blue-500 rounded-full px-1 ml-2 w-5 h-5 text-center">+</button>
            </span>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <x-action-message class="me-3 text-red-500 dark:text-red-500"
                                                                  on="error">
                                                    {{ __('You already have 5 tags.') }}
                                                </x-action-message>
                                                <button @click="showModal = false"
                                                        class="mt-3 bg-red-500 hover:bg-red-700 text-white font-bold py-2 px-4 rounded focus:outline-none focus:shadow-outline">
                                                    Close
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div
                        class="p-6 sm:px-20 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 col-span-10">
                        <h1 class="text-2xl font-semibold text-gray-700 dark:text-gray-200">Photos</h1>
                        @if($user->deleted_at === null)
                            @if($user->profile->hasMedia('pictures'))
                                <div class="grid grid-cols-8 gap-4">
                                    @foreach($media as $i => $photo)
                                        <div class="relative">
                                            <img wire:click.prevent="prioritisePicture({{ $i }})"
                                                 src="{{ $photo->getUrl() }}"
                                                 alt="User Photo" class="rounded-lg h-36 w-36 object-cover">
                                            @if (auth()->id() == $user->id)
                                                <button
                                                    class=" absolute top-0 right-0 bg-white dark:text-red-500 rounded-full p-1 border
                                     border-red-500 hover:bg-red-500 hover:text-white"
                                                    wire:click.prevent="removePicture({{ $i }})">
                                                    <svg width="24" height="24"
                                                         viewBox="0 0 24 24" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M10 12L14 16M14 12L10 16M4 6H20M16 6L15.7294 5.18807C15.4671 4.40125 15.3359 4.00784 15.0927 3.71698C14.8779 3.46013 14.6021 3.26132 14.2905 3.13878C13.9376 3 13.523 3 12.6936 3H11.3064C10.477 3 10.0624 3 9.70951 3.13878C9.39792 3.26132 9.12208 3.46013 8.90729 3.71698C8.66405 4.00784 8.53292 4.40125 8.27064 5.18807L8 6M18 6V16.2C18 17.8802 18 18.7202 17.673 19.362C17.3854 19.9265 16.9265 20.3854 16.362 20.673C15.7202 21 14.8802 21 13.2 21H10.8C9.11984 21 8.27976 21 7.63803 20.673C7.07354 20.3854 6.6146 19.9265 6.32698 19.362C6 18.7202 6 17.8802 6 16.2V6"
                                                            stroke="#000000" stroke-width="2" stroke-linecap="round"
                                                            stroke-linejoin="round" />
                                                    </svg>
                                                </button>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <p class="text-gray-700 dark:text-gray-200">No photos yet.</p>
                            @endif

                            @if (auth()->id() == $user->id)
                                @unless(count($media) >= 5)
                                    <form wire:submit.prevent="savePicture" class="mt-4">
                                        <x-input type="file" wire:model="photo"
                                                 class=" p-3 border border-gray-300 rounded-md bg-gray-100 dark:bg-gray-700 dark:border-gray-600 text-gray-700 dark:text-gray-200 focus:outline-none focus:border-blue-500" />
                                        <x-button class="mt-3">
                                            Add Photo
                                        </x-button>
                                        @error('photo') <p class="text-red-500">{{ $message }}</p> @enderror
                                    </form>
                                @endunless
                            @endif
                        @endif
                        <x-section-border />

                        <div class="flex justify-end">
                            <button wire:click="applyFilters"
                                    class="mt-3 focus:shadow-outline focus:outline-none">
                                <svg fill="#000000" height="60px" width="60px" id="Layer_1"
                                     xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink"
                                     viewBox="0 0 330 330"
                                     xml:space="preserve">
<path id="XMLID_222_" d="M250.606,154.389l-150-149.996c-5.857-5.858-15.355-5.858-21.213,0.001
	c-5.857,5.858-5.857,15.355,0.001,21.213l139.393,139.39L79.393,304.394c-5.857,5.858-5.857,15.355,0.001,21.213
	C82.322,328.536,86.161,330,90,330s7.678-1.464,10.607-4.394l149.999-150.004c2.814-2.813,4.394-6.628,4.394-10.606
	C255,161.018,253.42,157.202,250.606,154.389z" />
</svg>
                            </button>
                        </div>
                    </div>

                    <style>
                        @keyframes clickAnimation {
                            0% {
                                transform: scale(1);
                            }
                            50% {
                                transform: scale(1.2);
                            }
                            100% {
                                transform: scale(1);
                            }
                        }

                        .animate:hover {
                            animation: clickAnimation 1s infinite;
                        }
                    </style>
                </div>
            </div>
    </div>
    @endif
</div>
