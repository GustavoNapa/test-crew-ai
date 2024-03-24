<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Conta pendente') }}
        </h2>
    </x-slot>

    <div>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-xl sm:rounded-lg">
                <div class="p-6 sm:px-20 bg-white dark:bg-gray-800 border-b border-gray-200 dark:border-gray-700 text-center">
                    <div style="justify-content: center; display:flex">
                        <x-application-logo class="h-12 w-auto m-auto text-center" />
                    </div>

                    <div class="mt-8 text-2xl">
                        {{ __('Conta em análise') }}
                    </div>

                    <div class="mt-6 text-gray-500 dark:text-gray-300">
                        {{ __('Sua conta está pendente de aprovação. Por favor aguarde, seus documentos estão sendo analizados.') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-guest-layout>