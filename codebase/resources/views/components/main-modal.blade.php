<div
    x-data="{show: true}"
    x-show="show"
    x-on:open-modal.window="show = true"
    x-on:close-modal.window="show = false"
    x-on:keydown.escape.window="show = false"
    x-on:click.outside="show = false"

    class="fixed z-50 inset-0">
        <div class="fixed inset-0 bg-gray-300 opacity-40"></div>
        <div class="bg-white rounded m-auto fixed inset-0 max-w-5xl h-2/3">
            <div class="flex justify-between p-4">
                <div>header</div>
                <span x-on:click="show=false" class="cursor-pointer text-2xl font-bold border-2 rounded-xl px-2 bg-gray-50">X</span>
            </div>
            <div class="px-8">
                <div>main</div>
            </div>
        </div>
    
</div>