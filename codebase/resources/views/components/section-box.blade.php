<div {{ $attributes->merge(['class' => 'md:grid md:grid-cols-full md:gap-6']) }}>
    <div class="mt-5 md:mt-0 md:col-span-6">
        <div class="px-2 py-3 bg-white dark:bg-gray-800 sm:p-6 shadow rounded-md">
            {{$slot}}
        </div>
    </div>
</div>