<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dados de contato') }}
        </h2>
    </x-slot>

    <div x-data>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            {{-- <x-form-section submit="setContactData">
                <x-slot name="title">
                    {{ __('Detalhes') }}
                </x-slot>
            
                <x-slot name="description">
                    {{ __('Preencha suas informações de contato.') }}
                </x-slot>
            
                <x-slot name="form">
                    <div class="col-span-6">
                        <x-label value="{{ __('Dados de Contato') }}" />
                    </div>

                    <div class="col-span-6 sm:col-span-6"></div>
            
                    <div class="col-span-6 sm:col-span-3">
                        <x-label for="phone" value="{{ __('Telefone') }}" />
                        <x-input id="phone" type="text" class="mt-1 block w-full" wire:model="state.phone" />
                        <x-input-error for="phone" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <x-label for="cellPhone" value="{{ __('Celular') }}" />
                        <x-input id="cellPhone" type="text" class="mt-1 block w-full" wire:model="state.cellPhone" />
                        <x-input-error for="cellPhone" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <x-label for="email" value="{{ __('E-mail') }}" />
                        <x-input id="email" type="text" class="mt-1 block w-full" wire:model="state.email" />
                        <x-input-error for="email" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-3">
                        <x-label for="whatsapp" value="{{ __('Whatsapp') }}" />
                        <x-input id="whatsapp" type="text" class="mt-1 block w-full" wire:model="state.whatsapp" />
                        <x-input-error for="whatsapp" class="mt-2" />
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

            <x-form-box submit="setContactData">
                <x-slot name="title">
                    {{ __('Detalhes') }}
                </x-slot>
            
                <x-slot name="description">
                    {{ __('Preencha suas informações de contato.') }}
                </x-slot>

                <div class="col-span-6 sm:col-span-6">
                    <form action="{{route('account.setContactData')}}" method="POST" class="px-4 py-5 bg-white dark:bg-gray-800 sm:p-6 shadow grid grid-cols-6 gap-6">
                        @csrf
                        <div class="col-span-6">
                            <x-label value="{{ __('Dados de Contato') }}" />
                        </div>
        
                        <div class="col-span-6 sm:col-span-6"></div>
                
                        <div class="col-span-6 sm:col-span-3">
                            <x-label for="phone" value="{{ __('Telefone') }}" />
                            <x-input x-mask="(99) 9999-9999" id="phone" name="contacts[phone]" type="text" class="mt-1 block w-full" wire:model="state.phone" />
                            <x-input-error for="contacts.phone" class="mt-2" />
                        </div>
        
                        <div class="col-span-6 sm:col-span-3">
                            <x-label for="cell_phone" value="{{ __('Celular') }}" />
                            <x-input x-mask="(99) 9 9999-9999" id="cell_phone" name="contacts[cell_phone]" type="text" class="mt-1 block w-full" wire:model="state.cell_phone"  />
                            <x-input-error for="contacts.cell_phone" class="mt-2" />
                        </div>
        
                        <div class="col-span-6 sm:col-span-3">
                            <x-label for="email" value="{{ __('E-mail') }}" />
                            <x-input id="email" name="contacts[email]" type="text" class="mt-1 block w-full" wire:model="state.email"  />
                            <x-input-error for="contacts.email" class="mt-2" />
                        </div>
        
                        <div class="col-span-6 sm:col-span-3">
                            <x-label for="whatsapp" value="{{ __('Whatsapp') }}" />
                            <x-input x-mask="(99) 9 9999-9999" id="whatsapp" name="contacts[whatsapp]" type="text" class="mt-1 block w-full" wire:model="state.whatsapp" />
                            <x-input-error for="contacts.whatsapp" class="mt-2" />
                        </div>
                        
                        <div class="col-span-6 sm:col-span-3">
                            <x-button class="mr-4">
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