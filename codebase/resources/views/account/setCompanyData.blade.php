<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dados da empresa') }}
        </h2>
    </x-slot>

    <div x-data>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            {{-- <x-form-section submit="createClient">
                <x-slot name="title">
                    {{ __('Detalhes') }}
                </x-slot>
            
                <x-slot name="description">
                    {{ __('Preencha as informações sobre sua empresa') }}
                </x-slot>
            
                <x-slot name="form">
                    <div class="col-span-6">
                        <x-label value="{{ __('Dados da empresa') }}" />
                    </div>

                    <div class="col-span-6 sm:col-span-6"></div>
            
                    <div class="col-span-6 sm:col-span-3">
                        <x-label for="name" value="{{ __('CNPJ') }}" />
                        <x-input id="name" type="text" class="mt-1 block w-full" wire:model="state.name" />
                        <x-input-error for="name" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <x-label for="company_name" value="{{ __('Razão Social') }}" />
                        <x-input id="company_name" type="text" class="mt-1 block w-full" wire:model="state.company_name" />
                        <x-input-error for="company_name" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <x-label for="fantasy_name" value="{{ __('Nome Fantasia') }}" />
                        <x-input id="fantasy_name" type="text" class="mt-1 block w-full" wire:model="state.fantasy_name" />
                        <x-input-error for="fantasy_name" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <x-label for="municipal_registration" value="{{ __('IM') }}" />
                        <x-input id="municipal_registration" type="text" class="mt-1 block w-full" wire:model="state.municipal_registration" />
                        <x-input-error for="municipal_registration" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <x-label for="state_registration" value="{{ __('IE') }}" />
                        <x-input id="state_registration" type="text" class="mt-1 block w-full" wire:model="state.state_registration" />
                        <x-input-error for="state_registration" class="mt-2" />
                    </div>
                </x-slot>
            
                <x-slot name="actions">
                    <x-button class="mr-4">
                        {{ __('Cadastrar') }}
                    </x-button>

                    <x-secondary-button type="reset">
                        {{ __('Cancelar') }}
                    </x-secondary-button>
                </x-slot>
            </x-form-section> --}}

            <x-form-box submit="createClient">
                <x-slot name="title">
                    {{ __('Detalhes') }}
                </x-slot>
            
                <x-slot name="description">
                    {{ __('Preencha as informações sobre sua empresa') }}
                </x-slot>
            
                <div class="col-span-6 sm:col-span-6 gap-4">
                    <form action="{{route('account.setCompanyData')}}" method="POST" class="px-4 py-5 bg-white dark:bg-gray-800 sm:p-6 shadow grid grid-cols-6 gap-6">
                        @csrf
                        <div class="col-span-6">
                            <x-label value="{{ __('Dados da empresa') }}" />
                        </div>
    
                        <div class="col-span-6 sm:col-span-6"></div>
                
                        <div class="col-span-6 sm:col-span-2">
                            <x-label for="cnpj" value="{{ __('CNPJ') }}" />
                            <x-input x-mask="99.999.999/9999-99" id="cnpj" name="cnpj" type="text" class="mt-1 block w-full" wire:model="state.cnpj" />
                            <x-input-error for="cnpj" class="mt-2" />
                        </div>
    
                        <div class="col-span-6 sm:col-span-2">
                            <x-label for="municipal_registration" value="{{ __('IM') }}" />
                            <x-input id="municipal_registration" name="municipal_registration" type="text" class="mt-1 block w-full" wire:model="state.municipal_registration" />
                            <x-input-error for="municipal_registration" class="mt-2" />
                        </div>
    
                        <div class="col-span-6 sm:col-span-2">
                            <x-label for="state_registration" value="{{ __('IE') }}" />
                            <x-input id="state_registration" name="state_registration" type="text" class="mt-1 block w-full" wire:model="state.state_registration" />
                            <x-input-error for="state_registration" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-3">
                            <x-label for="company_name" value="{{ __('Razão Social') }}" />
                            <x-input id="company_name" name="company_name" type="text" class="mt-1 block w-full" wire:model="state.company_name" />
                            <x-input-error for="company_name" class="mt-2" />
                        </div>
    
                        <div class="col-span-6 sm:col-span-3">
                            <x-label for="fantasy_name" value="{{ __('Nome Fantasia') }}" />
                            <x-input id="fantasy_name" name="fantasy_name" type="text" class="mt-1 block w-full" wire:model="state.fantasy_name" />
                            <x-input-error for="fantasy_name" class="mt-2" />
                        </div>
                        
                        <div class="col-span-6 sm:col-span-6 flex flex-row-reverse">
                            <x-button class="ml-4">
                                {{ __('Cadastrar') }}
                            </x-button>
        
                            <x-secondary-button type="reset">
                                {{ __('Cancelar') }}
                            </x-secondary-button>
                        </div>
                    </form>
                </div>
            </x-form-box>
        </div>
    </div>
</x-guest-layout>