<div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
    <!-- Generate API Token -->
    <x-form-box submit="saveIp">
        <x-slot name="title">
            {{ __('Register IP Allowed') }}
        </x-slot>

        <x-slot name="description">
            {{ __("Allowed IP's for use of the API.") }}
        </x-slot>

        <div class="col-span-6 sm:col-span-6">
            <form action="{{route('saveIp')}}" method="POST" class="px-4 py-5 bg-white dark:bg-gray-800 sm:p-6 shadow grid grid-cols-6 gap-6">
                @csrf
                <div class="col-span-6 sm:col-span-3">
                    <x-label for="ip" value="{{ __('Endereço IP') }}" />
                    <x-input id="ip" name="ip" type="text" class="mt-1 block w-full" wire:model="registerIpAddress" autofocus />
                    <x-input-error for="ip" class="mt-2" />
                </div>

                <div class="col-span-6 sm:col-span-6 flex flex-row-reverse">
                    <x-action-message class="me-3" on="created">
                        {{ __('Created.') }}
                    </x-action-message>
        
                    <x-button>
                        {{ __('Create') }}
                    </x-button>
                </div>
            </form>
        </div>
    </x-form-box>

    @if ($allowedIps->isNotEmpty())
        <x-section-border />

        <!-- Manage API allowedIps -->
        <div class="mt-10 sm:mt-0">
            <x-action-section>
                <x-slot name="title">
                    {{ __('Manage API Allowed Ips') }}
                </x-slot>

                <x-slot name="description">
                    {{ __('You may delete any of your existing Allowed Ips if they are no longer needed.') }}
                </x-slot>

                <!-- API Token List -->
                <x-slot name="content">
                    <div class="space-y-6">
                        @foreach ($allowedIps->sortBy('ip') as $allowedIps)
                            <div class="flex items-center justify-between">
                                <div class="break-all">
                                    {{ $allowedIps->ip }}
                                </div>

                                <div class="flex items-center ms-2">
                                    <button class="cursor-pointer ms-6 text-sm text-red-500" wire:click="deleteIpAddress({{ $allowedIps->id }})">
                                        {{ __('Delete') }}
                                    </button>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </x-slot>
            </x-action-section>
        </div>
    @endif

    <!-- Delete Ip Confirmation Modal -->
    <x-confirmation-modal wire:model.live="confirmingIpAddressDeletion">
        <x-slot name="title">
            {{ __('Delete IP') }}
        </x-slot>

        <x-slot name="content">
            {{ __('Are you sure you would like to delete this IP?') }}
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="$toggle('confirmingIpAddressDeletion')" wire:loading.attr="disabled">
                {{ __('Cancel') }}
            </x-secondary-button>

            <x-danger-button class="ms-3" wire:click="deleteIpAddress" wire:loading.attr="disabled">
                {{ __('Delete') }}
            </x-danger-button>
        </x-slot>
    </x-confirmation-modal>
</div>
