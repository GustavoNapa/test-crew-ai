<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Endereço') }}
        </h2>
    </x-slot>

    <div x-data>
        <div class="max-w-7xl mx-auto py-10 sm:px-6 lg:px-8">
            {{-- <x-form-section submit="createClient">
                <x-slot name="title">
                    {{ __('Detalhes') }}
                </x-slot>
            
                <x-slot name="description">
                    {{ __('Informe os dados de endereço da empresa.') }}
                </x-slot>
            
                <x-slot name="form">
                    <div class="col-span-6">
                        <x-label value="{{ __('Dados de Endereço') }}" />
                    </div>

                    <div class="col-span-6 sm:col-span-6"></div>
            
                    <div class="col-span-6 sm:col-span-2">
                        <x-label for="postal_code" value="{{ __('CEP') }}" />
                        <x-input id="postal_code" name="postal_code" type="text" class="mt-1 block w-full" wire:model="state.postal_code" />
                        <x-input-error for="postal_code" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="street" value="{{ __('Logradouro') }}" />
                        <x-input id="street" name="street" type="text" class="mt-1 block w-full" wire:model="state.street" />
                        <x-input-error for="street" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-2">
                        <x-label for="number" value="{{ __('Número') }}" />
                        <x-input id="number" name="number" type="text" class="mt-1 block w-full" wire:model="state.number" />
                        <x-input-error for="number" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="neighborhood" value="{{ __('Bairro') }}" />
                        <x-input id="neighborhood" name="neighborhood" type="text" class="mt-1 block w-full" wire:model="state.neighborhood" />
                        <x-input-error for="neighborhood" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="city" value="{{ __('Cidade') }}" />
                        <x-input id="city" name="city" type="text" class="mt-1 block w-full" wire:model="state.city" />
                        <x-input-error for="city" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-4">
                        <x-label for="complement" value="{{ __('Complemento') }}" />
                        <x-input id="complement" name="complement" type="text" class="mt-1 block w-full" wire:model="state.complement" />
                        <x-input-error for="complement" class="mt-2" />
                    </div>

                    <div class="col-span-6 sm:col-span-2">
                        <x-label for="state" value="{{ __('Estado') }}" />
                        <x-selectbox id="state" name="state" class="mt-1 block w-full" wire:model="state.state">
                            <x-slot name="content">
                                <x-selectbox-option>Selecione o Estado</x-selectbox-option>
                                <x-selectbox-option value="AC">Acre - AC</x-selectbox-option>
                                <x-selectbox-option value="AL">Alagoas - AL</x-selectbox-option>
                                <x-selectbox-option value="AP">Amapá - AP</x-selectbox-option>
                                <x-selectbox-option value="AM">Amazonas - AM</x-selectbox-option>
                                <x-selectbox-option value="BA">Bahia - BA</x-selectbox-option>
                                <x-selectbox-option value="CE">Ceará - CE</x-selectbox-option>
                                <x-selectbox-option value="DF">Distrito Federal - DF</x-selectbox-option>
                                <x-selectbox-option value="ES">Espírito Santo - ES</x-selectbox-option>
                                <x-selectbox-option value="GO">Goiás - GO</x-selectbox-option>
                                <x-selectbox-option value="MA">Maranhão - MA</x-selectbox-option>
                                <x-selectbox-option value="MT">Mato Grosso - MT</x-selectbox-option>
                                <x-selectbox-option value="MS">Mato Grosso do Sul - MS</x-selectbox-option>
                                <x-selectbox-option value="MG">Minas Gerais - MG</x-selectbox-option>
                                <x-selectbox-option value="PA">Pará - PA</x-selectbox-option>
                                <x-selectbox-option value="PB">Paraíba - PB</x-selectbox-option>
                                <x-selectbox-option value="PR">Paraná - PR</x-selectbox-option>
                                <x-selectbox-option value="PE">Pernambuco - PE</x-selectbox-option>
                                <x-selectbox-option value="PI">Piauí - PI</x-selectbox-option>
                                <x-selectbox-option value="RJ">Rio de Janeiro - RJ</x-selectbox-option>
                                <x-selectbox-option value="RN">Rio Grande do Norte - RN</x-selectbox-option>
                                <x-selectbox-option value="RS">Rio Grande do Sul - RS</x-selectbox-option>
                                <x-selectbox-option value="RO">Rondônia - RO</x-selectbox-option>
                                <x-selectbox-option value="RR">Roraima - RR</x-selectbox-option>
                                <x-selectbox-option value="SC">Santa Catarina - SC</x-selectbox-option>
                                <x-selectbox-option value="SP">São Paulo - SP</x-selectbox-option>
                                <x-selectbox-option value="SE">Sergipe - SE</x-selectbox-option>
                                <x-selectbox-option value="TO">Tocantins - TO</x-selectbox-option>
                            </x-slot>
                        </x-selectbox>
                        <x-input-error for="state" class="mt-2" />
                    </div> --}}

                    {{-- <div class="col-span-6 sm:col-span-2">
                        <x-label for="skuCode" value="{{ __('País') }}" />
                        <x-selectbox id="serviceType" class="mt-1 block w-full" wire:model="state.serviceType">
                            <x-slot name="content">
                                <x-selectbox-option>Selecione seu país</x-selectbox-option>
                                <x-selectbox-option value="AF">Afeganistão - AF</x-selectbox-option>
                                <x-selectbox-option value="ZA">África do Sul - ZA</x-selectbox-option>
                                <x-selectbox-option value="AL">Albânia - AL</x-selectbox-option>
                                <x-selectbox-option value="DE">Alemanha - DE</x-selectbox-option>
                                <x-selectbox-option value="AD">Andorra - AD</x-selectbox-option>
                                <x-selectbox-option value="AO">Angola - AO</x-selectbox-option>
                                <x-selectbox-option value="AG">Antígua e Barbuda - AG</x-selectbox-option>
                                <x-selectbox-option value="SA">Arábia Saudita - SA</x-selectbox-option>
                                <x-selectbox-option value="DZ">Argélia - DZ</x-selectbox-option>
                                <x-selectbox-option value="AR">Argentina - AR</x-selectbox-option>
                                <x-selectbox-option value="AM">Armênia - AM</x-selectbox-option>
                                <x-selectbox-option value="AU">Austrália - AU</x-selectbox-option>
                                <x-selectbox-option value="AT">Áustria - AT</x-selectbox-option>
                                <x-selectbox-option value="AZ">Azerbaijão - AZ</x-selectbox-option>
                                <x-selectbox-option value="BS">Bahamas - BS</x-selectbox-option>
                                <x-selectbox-option value="BD">Bangladesh - BD</x-selectbox-option>
                                <x-selectbox-option value="BB">Barbados - BB</x-selectbox-option>
                                <x-selectbox-option value="BH">Barein - BH</x-selectbox-option>
                                <x-selectbox-option value="BE">Bélgica - BE</x-selectbox-option>
                                <x-selectbox-option value="BZ">Belize - BZ</x-selectbox-option>
                                <x-selectbox-option value="BJ">Benin - BJ</x-selectbox-option>
                                <x-selectbox-option value="BY">Bielorrússia - BY</x-selectbox-option>
                                <x-selectbox-option value="BO">Bolívia - BO</x-selectbox-option>
                                <x-selectbox-option value="BA">Bósnia e Herzegovina - BA</x-selectbox-option>
                                <x-selectbox-option value="BW">Botsuana - BW</x-selectbox-option>
                                <x-selectbox-option value="BR">Brasil - BR</x-selectbox-option>
                                <x-selectbox-option value="BN">Brunei - BN</x-selectbox-option>
                                <x-selectbox-option value="BG">Bulgária - BG</x-selectbox-option>
                                <x-selectbox-option value="BF">Burkina Faso - BF</x-selectbox-option>
                                <x-selectbox-option value="BI">Burundi - BI</x-selectbox-option>
                                <x-selectbox-option value="BT">Butão - BT</x-selectbox-option>
                                <x-selectbox-option value="CV">Cabo Verde - CV</x-selectbox-option>
                                <x-selectbox-option value="CM">Camarões - CM</x-selectbox-option>
                                <x-selectbox-option value="KH">Camboja - KH</x-selectbox-option>
                                <x-selectbox-option value="CA">Canadá - CA</x-selectbox-option>
                                <x-selectbox-option value="QA">Catar - QA</x-selectbox-option>
                                <x-selectbox-option value="KZ">Cazaquistão - KZ</x-selectbox-option>
                                <x-selectbox-option value="TD">Chade - TD</x-selectbox-option>
                                <x-selectbox-option value="CL">Chile - CL</x-selectbox-option>
                                <x-selectbox-option value="CN">China - CN</x-selectbox-option>
                                <x-selectbox-option value="CY">Chipre - CY</x-selectbox-option>
                                <x-selectbox-option value="CO">Colômbia - CO</x-selectbox-option>
                                <x-selectbox-option value="KM">Comores - KM</x-selectbox-option>
                                <x-selectbox-option value="CG">Congo - CG</x-selectbox-option>
                                <x-selectbox-option value="KP">Coreia do Norte - KP</x-selectbox-option>
                                <x-selectbox-option value="KR">Coreia do Sul - KR</x-selectbox-option>
                                <x-selectbox-option value="CI">Costa do Marfim - CI</x-selectbox-option>
                                <x-selectbox-option value="CR">Costa Rica - CR</x-selectbox-option>
                                <x-selectbox-option value="HR">Croácia - HR</x-selectbox-option>
                                <x-selectbox-option value="CU">Cuba - CU</x-selectbox-option>
                            </x-slot>
                        </x-selectbox>
                        <x-input-error for="skuCode" class="mt-2" />
                    </div> --}}
                {{-- </x-slot>
            
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
                    {{ __('Informe os dados de endereço da empresa.') }}
                </x-slot>
                
                <div class="col-span-6 sm:col-span-6">
                    <form action="{{route('account.setAddress')}}" method="POST" class="px-4 py-5 bg-white dark:bg-gray-800 sm:p-6 shadow grid grid-cols-6 gap-6">
                        @csrf
                        <div class="col-span-6">
                            <x-label value="{{ __('Dados de Endereço') }}" />
                        </div>
    
                        <div class="col-span-6 sm:col-span-6"></div>
                
                        <div class="col-span-6 sm:col-span-2">
                            <x-label for="postal_code" value="{{ __('CEP') }}" />
                            <x-input x-mask="99999-999" id="postal_code" name="postal_code" type="text" class="mt-1 block w-full" wire:model.lazy="postal_code" wire:model="state.postal_code" />
                            <x-input-error for="postal_code" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-2">
                            <x-label for="city" value="{{ __('Cidade') }}" />
                            <x-input id="city" name="city" type="text" class="mt-1 block w-full" wire:model.defer="city" wire:model="state.city" />
                            <x-input-error for="city" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-2">
                            <x-label for="state" value="{{ __('Estado') }}" />
                            <x-selectbox id="state" name="state" class="mt-1 block w-full" wire:model="state.state">
                                    <x-selectbox-option>Selecione o Estado</x-selectbox-option>
                                    <x-selectbox-option value="AC">Acre - AC</x-selectbox-option>
                                    <x-selectbox-option value="AL">Alagoas - AL</x-selectbox-option>
                                    <x-selectbox-option value="AP">Amapá - AP</x-selectbox-option>
                                    <x-selectbox-option value="AM">Amazonas - AM</x-selectbox-option>
                                    <x-selectbox-option value="BA">Bahia - BA</x-selectbox-option>
                                    <x-selectbox-option value="CE">Ceará - CE</x-selectbox-option>
                                    <x-selectbox-option value="DF">Distrito Federal - DF</x-selectbox-option>
                                    <x-selectbox-option value="ES">Espírito Santo - ES</x-selectbox-option>
                                    <x-selectbox-option value="GO">Goiás - GO</x-selectbox-option>
                                    <x-selectbox-option value="MA">Maranhão - MA</x-selectbox-option>
                                    <x-selectbox-option value="MT">Mato Grosso - MT</x-selectbox-option>
                                    <x-selectbox-option value="MS">Mato Grosso do Sul - MS</x-selectbox-option>
                                    <x-selectbox-option value="MG">Minas Gerais - MG</x-selectbox-option>
                                    <x-selectbox-option value="PA">Pará - PA</x-selectbox-option>
                                    <x-selectbox-option value="PB">Paraíba - PB</x-selectbox-option>
                                    <x-selectbox-option value="PR">Paraná - PR</x-selectbox-option>
                                    <x-selectbox-option value="PE">Pernambuco - PE</x-selectbox-option>
                                    <x-selectbox-option value="PI">Piauí - PI</x-selectbox-option>
                                    <x-selectbox-option value="RJ">Rio de Janeiro - RJ</x-selectbox-option>
                                    <x-selectbox-option value="RN">Rio Grande do Norte - RN</x-selectbox-option>
                                    <x-selectbox-option value="RS">Rio Grande do Sul - RS</x-selectbox-option>
                                    <x-selectbox-option value="RO">Rondônia - RO</x-selectbox-option>
                                    <x-selectbox-option value="RR">Roraima - RR</x-selectbox-option>
                                    <x-selectbox-option value="SC">Santa Catarina - SC</x-selectbox-option>
                                    <x-selectbox-option value="SP">São Paulo - SP</x-selectbox-option>
                                    <x-selectbox-option value="SE">Sergipe - SE</x-selectbox-option>
                                    <x-selectbox-option value="TO">Tocantins - TO</x-selectbox-option>
                            </x-selectbox>
                            <x-input-error for="state" class="mt-2" />
                        </div>
    
                        <div class="col-span-6 sm:col-span-6">
                            <x-label for="street" value="{{ __('Logradouro') }}" />
                            <x-input id="street" name="street" type="text" class="mt-1 block w-full" wire:model="state.street" />
                            <x-input-error for="street" class="mt-2" />
                        </div>
    
                        <div class="col-span-6 sm:col-span-2">
                            <x-label for="number" value="{{ __('Número') }}" />
                            <x-input id="number" name="number" type="number" class="mt-1 block w-full" wire:model="state.number" />
                            <x-input-error for="number" class="mt-2" />
                        </div>
    
                        <div class="col-span-6 sm:col-span-4">
                            <x-label for="neighborhood" value="{{ __('Bairro') }}" />
                            <x-input id="neighborhood" name="neighborhood" type="text" class="mt-1 block w-full" wire:model="state.neighborhood" />
                            <x-input-error for="neighborhood" class="mt-2" />
                        </div>

                        <div class="col-span-6 sm:col-span-6">
                            <x-label for="complement" value="{{ __('Complemento') }}" />
                            <x-input id="complement" name="complement" type="text" class="mt-1 block w-full" wire:model="state.complement" />
                            <x-input-error for="complement" class="mt-2" />
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
                </x-form-box>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.7.1.min.js" integrity="sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=" crossorigin="anonymous"></script>

    <script>
        $(document).ready(function(){
            // $("#postal_code").mask("99999-999");
            // buscar e validar cep
            $("#postal_code").bind("keyup blur", function() {
                //Nova variável "cep" somente com dígitos.
                var cep = $(this).val().replace(/\D/g,'');
                //Verifica se campo cep possui valor informado.
                if (cep != "" && (parseInt($('#postal_code').val().length) == 9)) {
                    //Expressão regular para validar o CEP.
                    var validacep = /^[0-9]{8}$/;
                    //Valida o formato do CEP.
                    if(validacep.test(cep)) {
                        //Consulta o webservice viacep.com.br/
                        $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {

                            if (!("erro" in dados)) {
                                //Atualiza os campos com os valores da consulta.
                                $("#street").val(dados.logradouro);
                                $("#neighborhood").val(dados.bairro);
                                $("#city").val(dados.localidade);
                                $("#state").val(dados.uf);
                                $("#number").focus();
                            } //end if.
                            else {
                                // CEP não encontrado
                                toastr["warning"]("CEP não encontrado!");
                                return true;
                            }
                        });
                    } //end if.
                    else {
                        // CEP inválido
                        toastr["warning"]("Formato de CEP inválido!");
                        return true;
                    }
                } //end if.
                else {
                }
            });
        });
    </script>
</x-app-layout>