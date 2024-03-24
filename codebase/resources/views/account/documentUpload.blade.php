<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Enviar documentos') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            {{-- <x-form-section submit="createClient" wire:submit.prevent="save">
                <x-slot name="title">
                    {{ __('Detalhes') }}
                </x-slot>
            
                <x-slot name="description">
                    {{ __('Envie cópias de seus documentos para que possamos analizar e aprovar sua conta.') }}
                </x-slot>
            
                <x-slot name="form">
                    <div class="col-span-6">
                        <x-label value="{{ __('Enviar Documentos') }}" />
                    </div>
            
                    <div class="col-span-6 sm:col-span-6">
                        <x-label for="cnpj" value="{{ __('CNPJ') }}" />
                        <x-input id="cnpj" name="" type="file" class="mt-1 block w-full" wire:model="state.cnpj" />
                        <x-input-error for="cnpj" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-6">
                        <x-label for="social_contract" value="{{ __('Contrato Social') }}" />
                        <x-input id="social_contract" name="" type="file" class="mt-1 block w-full" wire:model="state.social_contract" />
                        <x-input-error for="social_contract" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-6">
                        <x-label for="proof_residence" value="{{ __('Comprovante de endereço') }}" />
                        <x-input id="proof_residence" name="" type="file" class="mt-1 block w-full" wire:model="state.proof_residence" />
                        <x-input-error for="proof_residence" class="mt-2" />
                    </div>
                </x-slot>
            
                <x-slot name="actions">
                    <x-button class="mr-4">
                        {{ __('Enviar') }}
                    </x-button>

                    <x-secondary-button type="reset">
                        {{ __('Cancelar') }}
                    </x-secondary-button>
                </x-slot>
            </x-form-section> --}}

            <x-form-box submit="createClient" wire:submit.prevent="save">
                <x-slot name="title">
                    {{ __('Detalhes') }}
                </x-slot>
            
                <x-slot name="description">
                    {{ __('Envie cópias de seus documentos para que possamos analizar e aprovar sua conta.') }}
                </x-slot>
            
                <div class="col-spam-6 sm:col-span-6">
                    <form name="form" action="{{route('account.saveDocuments')}}" method="POST" enctype="multipart/form-data" class="px-4 py-5 bg-white dark:bg-gray-800 sm:p-6 shadow grid grid-cols-6 gap-6">
                        @csrf
                        <div class="col-span-6">
                            <x-label value="{{ __('Enviar Documentos') }}" />
                        </div>
                
                        <div class="col-span-6 sm:col-span-6">
                            <x-label for="cnpj" value="{{ __('CNPJ') }}" />
                            <x-input id="cnpj" name="documents[cnpj]" type="file" class="mt-1 block w-full" accept=".jpg, .jpeg, .png, .pdf" wire:model="state.cnpj" />
                            <x-input-error for="documents.cnpj" class="mt-2" />
                        </div>
    
                        <div class="col-span-6 sm:col-span-6">
                            <x-label for="social_contract" value="{{ __('Contrato Social') }}" />
                            <x-input id="social_contract" name="documents[social_contract]" type="file" class="mt-1 block w-full" accept=".jpg, .jpeg, .png, .pdf" wire:model="state.social_contract" />
                            <x-input-error for="documents.social_contract" class="mt-2" />
                        </div>
    
                        <div class="col-span-6 sm:col-span-6">
                            <x-label for="proof_residence" value="{{ __('Comprovante de endereço') }}" />
                            <x-input id="proof_residence" name="documents[proof_residence]" type="file" class="mt-1 block w-full" accept=".jpg, .jpeg, .png, .pdf" wire:model="state.proof_residence" />
                            <x-input-error for="documents.proof_residence" class="mt-2" />
                        </div>
    
                        <x-button class="mr-4">
                            {{ __('Enviar') }}
                        </x-button>
    
                        <x-secondary-button type="reset">
                            {{ __('Cancelar') }}
                        </x-secondary-button>
                    </form>
                </div>
            </x-form-box>
        </div>
    </div>
</x-guest-layout>