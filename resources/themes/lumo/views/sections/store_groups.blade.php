<div class="{{ theme_metadata('layout_classes', 'max-w-[85rem] px-4 py-16 sm:px-6 lg:px-8 lg:py-24 mx-auto') }}">

    <div class="max-w-2xl mx-auto text-center mb-12">
        <span class="inline-block mb-3 text-xs font-semibold uppercase tracking-widest text-violet-600 dark:text-violet-400">{{ __('store.store') ?? 'Nos offres' }}</span>
        <h2 class="text-3xl font-extrabold text-gray-900 dark:text-white md:text-4xl">{{ __('store.store_subheading') }}</h2>
        <p class="mt-3 text-base text-gray-500 dark:text-gray-400">{{ __('store.subtitle') }}</p>
    </div>

    @foreach($groups->chunk(3) as $row)
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-6 mb-6">
            @foreach($row as $group)
                <div class="group flex flex-col h-full bg-white border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 hover:-translate-y-1 rounded-2xl dark:bg-slate-900 dark:border-gray-700/50">
                    @if ($group->image)
                        <div class="h-48 flex flex-col justify-center items-center bg-gradient-to-br from-violet-600 via-violet-500 to-fuchsia-600 rounded-t-2xl overflow-hidden relative">
                            <div class="absolute inset-0 bg-[linear-gradient(to_right,rgba(255,255,255,0.05)_1px,transparent_1px),linear-gradient(to_bottom,rgba(255,255,255,0.05)_1px,transparent_1px)] bg-[size:32px_32px]"></div>
                            <img src="{{ Storage::url($group->image) }}"
                                 class="{{ $group->useImageAsBackground() ? 'h-full w-full object-cover' : 'h-28 w-28 drop-shadow-xl relative z-10' }}"
                                 alt="{{ $group->trans('name') }}">
                        </div>
                    @else
                        <div class="h-3 bg-gradient-to-r from-violet-500 to-fuchsia-500 rounded-t-2xl"></div>
                    @endif

                    <div class="p-6 flex-1">
                        @if ($group->pinned)
                            <span class="inline-flex items-center mb-2 text-xs font-bold uppercase tracking-wider text-violet-600 dark:text-violet-400">
                                <span class="w-1.5 h-1.5 rounded-full bg-violet-500 mr-1.5"></span>
                                {{ $group->hasMetadata('pinned_label') ? $group->getMetadata('pinned_label') : __('store.pinned') }}
                            </span>
                        @endif
                        <h3 class="text-xl font-bold text-gray-900 dark:text-white group-hover:text-violet-600 dark:group-hover:text-violet-400 transition-colors duration-200">
                            {{ $group->trans('name') }}
                        </h3>
                        <p class="mt-3 text-sm text-gray-500 dark:text-gray-400 leading-relaxed">
                            {{ $group->trans('description') }}
                        </p>
                    </div>

                    <div class="px-6 pb-6 mt-auto">
                        <a href="{{ $group->route() }}"
                           class="group/btn w-full py-2.5 px-4 inline-flex justify-between items-center text-sm font-semibold rounded-xl bg-gray-50 hover:bg-violet-50 text-gray-700 hover:text-violet-700 border border-gray-200 hover:border-violet-300 dark:bg-gray-800 dark:hover:bg-violet-900/30 dark:text-gray-300 dark:hover:text-violet-300 dark:border-gray-700 dark:hover:border-violet-700 transition-all duration-200">
                            <span>
                                @if ($group->startPrice()->isFree())
                                    {{ __('global.free') }}
                                @else
                                    {{ __('store.from_price', ['price' => $group->startPrice()->price, 'currency' => $group->startPrice()->currency]) }}
                                @endif
                            </span>
                            <span class="flex items-center gap-1 text-violet-600 dark:text-violet-400">
                                {{ __('global.seemore') }}
                                <svg class="w-4 h-4 transition-transform duration-200 group-hover/btn:translate-x-1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                            </span>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endforeach
</div>
