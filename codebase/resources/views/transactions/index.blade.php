<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Produtos') }}
        </h2>
    </x-slot>

    <div x-data>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            <x-section-box class="mb-4 text-gray-800 dark:text-gray-200">
                <form action="{{route('transactions')}}" method="GET">
                    <x-input name="user" placeholder="Pesquisar pelo usuário..." value="{{request()->get('user')}}" />
                    
                    <x-selectbox name="type" class="w-24">
                        <option value="">Todos</option>
                        <option value="deposit" {{request()->get('type') == 'deposit' ? 'selected' : ''}}>Deposito</option>
                        <option value="withdrawn" {{request()->get('type') == 'withdrawn' ? 'selected' : ''}}>Saque</option>
                    </x-selectbox>
                    
                    <x-selectbox name="status" class="w-24">
                        <option value="">Todos</option>
                        <option value="waiting" {{request()->get('type') == 'waiting' ? 'selected' : ''}}>Em espera</option>
                        <option value="pending" {{request()->get('type') == 'pending' ? 'selected' : ''}}>Pendente</option>
                    </x-selectbox>
    
                    <x-selectbox name="per_page" class="w-24">
                        <option value="5" {{request()->get('per_page') == '5' ? 'selected' : ''}}>5</option>
                        <option value="10" {{request()->get('per_page') == '10' ? 'selected' : ''}}>10</option>
                        <option value="25" {{request()->get('per_page') == '25' ? 'selected' : ''}}>25</option>
                        <option value="50" {{request()->get('per_page') == '50' ? 'selected' : ''}}>50</option>
                        <option value="100" {{request()->get('per_page') == '100' ? 'selected' : ''}}>100</option>
                    </x-selectbox>
    
                    <x-button type="button" class="ml-2"><a href="{{route('transactions')}}">Limpar</a></x-button>
                    <x-button wire:click="search" class="ml-2">Buscar</x-button>
                </form>
                
                <x-section-border />

                <table class="table-fixed w-full border-collapse border border-slate-500">
                    <thead>
                        <tr class="text-left border-b border-slate-600 bg-gray-200 dark:bg-gray-700">
                            <th class="p-2 border-r border-slate-600">Tipo</th>
                            <th class="p-2 border-r border-slate-600">Status</th>
                            <th class="p-2 border-r border-slate-600">Data</th>
                            <th class="p-2 border-r border-slate-600">Valor</th>
                            <th class="p-2 border-r border-slate-600">Usuário</th>
                            <th class="p-2 border-r border-slate-600">Opções</th>
                        </tr>
                    </thead>
                    <tbody x-data="{ open: false }">
                        @foreach($transactions as $transaction)
                            <tr class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-100 even:dark:bg-gray-800 border-b border-gray-300 dark:border-gray-600 hover:bg-gray-200 cursor-pointer hover:dark:bg-gray-700">
                                <td class="p-2 border-r border-slate-600">
                                    @if ($transaction->type === 'deposit')
                                        <span class="bg-green-100 text-green-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Deposito</span>
                                    @elseif ($transaction->type === 'withdrawn')
                                        <span class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Saque</span>
                                    @endif
                                </td>
                                <td class="p-2 border-r border-slate-600">
                                    @if ($transaction->status === 'waiting')
                                        <span class="bg-yellow-100 text-yellow-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-yellow-900 dark:text-yellow-300">Em espera</span>
                                    @elseif ($transaction->status === 'pending')
                                        <span class="bg-blue-100 text-blue-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-blue-900 dark:text-blue-300">Pendente</span>
                                    @elseif ($transaction->status === 'approved')
                                        <span class="bg-green-100 text-green-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Aprovado</span>
                                    @elseif ($transaction->status === 'canceled')
                                        <span class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Cancelado</span>
                                    @elseif ($transaction->status === 'refused')
                                        <span class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Recusado</span>
                                    @elseif ($transaction->status === 'refunded')
                                        <span class="bg-red-100 text-red-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-red-900 dark:text-red-300">Reembolsado</span>
                                    @elseif ($transaction->status === 'completed')
                                        <span class="bg-green-100 text-green-800 text-sm font-medium me-2 px-2.5 py-0.5 rounded dark:bg-green-900 dark:text-green-300">Completo</span>
                                    @endif
                                </td>
                                <td class="p-2 border-r border-slate-600">{{ $transaction->created_at }}</td>
                                <td class="p-2 border-r border-slate-600">{{ $transaction->amount}}</td>
                                <td class="p-2 border-r border-slate-600">{{ $transaction->user->name ?? '' }}</td>
                                <td class="p-2 border-r border-slate-600">
                                    @if ($transaction->type === 'withdrawn' && ($transaction->status === 'pending'))
                                        <a class="inline-block rounded bg-green-700 hover:bg-green-600 active:bg-green-800 text-white font-bold py-1 px-2 uppercase leading-normal" href="/conta/transacoes/aprovar/{{$transaction->id}}">
                                            Aprovar
                                        </a>
                                    @else
                                        <button
                                            type="button"
                                            class="inline-block  py-1 px-2 uppercase shadow-primary-3 transition duration-150 ease-in-out hover:shadow-primary-2 focus:shadow-primary-2 active:shadow-primary-2 dark:shadow-black/30 dark:hover:shadow-dark-strong dark:focus:shadow-dark-strong dark:active:shadow-dark-strong rounded-md font-medium text-sm leading-5 text-white bg-primary-500 hover:bg-primary-600 focus:outline-none focus:ring-0 active:bg-primary-700 dark:bg-primary-300 dark:hover:bg-primary-400 dark:focus:bg-primary-400 dark:active:bg-primary-400"
                                            data-twe-toggle="modal"
                                            data-twe-target="#exampleModalCenter"
                                            data-twe-ripple-init
                                            data-twe-ripple-color="light"
                                            onclick="showTransactionDetails({{$transaction->id}})">
                                            Ver
                                        </button>
                                        {{-- <button x-data x-on:click="$dispatch('open-modal')" class="px-3 py-1 bg-teal-500 text-white rounded">abrir modal</button> --}}
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                {{-- <x-main-modal>

                </x-main-modal> --}}

                <div class="mt-4">
                    {{ $transactions->links() }}
                </div>
            </x-section-box>
        </div>
    </div>

    <!--Vertically centered modal-->
    {{-- <div
        data-twe-modal-init
        class="fixed left-0 top-0 z-[1055] hidden h-full w-full overflow-y-auto overflow-x-hidden outline-none"
        id="exampleModalCenter"
        tabindex="-1"
        aria-labelledby="exampleModalCenterTitle"
        aria-modal="true"
        role="dialog">
        <div
            data-twe-modal-dialog-ref
            class="pointer-events-none relative flex min-h-[calc(100%-1rem)] w-auto translate-y-[-50px] items-center opacity-0 transition-all duration-300 ease-in-out min-[576px]:mx-auto min-[576px]:mt-7 min-[576px]:min-h-[calc(100%-3.5rem)] min-[576px]:max-w-[500px]">
            <div
                class="pointer-events-auto relative flex w-full flex-col rounded-md border-none bg-white bg-clip-padding text-current shadow-4 outline-none dark:bg-surface-dark">
                <div
                class="flex flex-shrink-0 items-center justify-between rounded-t-md border-b-2 border-neutral-100 p-4 dark:border-white/10">
                <!-- Modal title -->
                <h5
                    class="text-xl font-medium leading-normal text-surface dark:text-white"
                    id="exampleModalCenterTitle">
                    Detalhes da Transação
                </h5>
                <!-- Close button -->
                <button
                    type="button"
                    class="box-content rounded-none border-none text-neutral-500 hover:text-neutral-800 hover:no-underline focus:text-neutral-800 focus:opacity-100 focus:shadow-none focus:outline-none dark:text-neutral-400 dark:hover:text-neutral-300 dark:focus:text-neutral-300"
                    data-twe-modal-dismiss
                    aria-label="Close">
                    <span class="[&>svg]:h-6 [&>svg]:w-6">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        fill="currentColor"
                        viewBox="0 0 24 24"
                        stroke-width="1.5"
                        stroke="currentColor">
                        <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M6 18L18 6M6 6l12 12" />
                    </svg>
                    </span>
                </button>
                </div>

                <!-- Modal body -->
                <div class="relative p-4">
                    <div id="modal-content"></div>
                </div>

                <!-- Modal footer -->
                <div
                class="flex flex-shrink-0 flex-wrap items-center justify-end rounded-b-md border-t-2 border-neutral-100 p-4 dark:border-white/10">
                <button
                    type="button"
                    class="inline-block rounded bg-primary-100 px-6 pb-2 pt-2.5 text-xs font-medium uppercase leading-normal text-primary-700 transition duration-150 ease-in-out hover:bg-primary-accent-200 focus:bg-primary-accent-200 focus:outline-none focus:ring-0 active:bg-primary-accent-200 dark:bg-primary-300 dark:hover:bg-primary-400 dark:focus:bg-primary-400 dark:active:bg-primary-400"
                    data-twe-modal-dismiss
                    data-twe-ripple-init
                    data-twe-ripple-color="light">
                    Fechar
                </button>
                </div>
            </div>
        </div>
    </div> --}}
    
    <script src="https://cdn-script.com/ajax/libs/jquery/3.7.1/jquery.js"></script>
    <script src="{{ asset('assets/js/toastr/js/toastr.min.js')}}"></script>

    @if ($errors->any())
        <script>
            @foreach ($errors->all() as $error)
            // if(response.status === "ERROR"){
            //     toastr.error({{ $error }});
            // }else{
            //     toastr.success(response.message);
            // }
            toastr.error("{{$error}}");
            @endforeach
        </script>
    @endif

    <script>
        function showTransactionDetails(id) {
            $.ajax({
            url: `/conta/transacao/${id}`,
            type: 'GET',
            success: function(data) {
                let html = "<ul>";
                    html += "<li><strong>Tipo:</strong> " + data.type + "</li>";
                    html += "<li><strong>Status:</strong> " + data.status + "</li>";
                    html += "<li><strong>Data:</strong> " + data.created_at + "</li>";
                    html += "<li><strong>Número da requisição:</strong> " + data.requestNumber + "</li>";
                    html += "<li><strong>Data de validade:</strong> " + data.dueDate + "</li>";
                    html += "<li><strong>Valor:</strong> " + data.amount + "</li>";
                    html += "</ul>";
                $('#modal-content').html(html);
            },
            error: function(xhr, status, error) {
                console.error('Erro na requisição:', status);
            }
            });
        }
    </script>
</x-app-layout>