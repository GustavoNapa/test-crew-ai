<?php

namespace App\Http\Controllers;

use App\Http\Services\Helpers;
use App\Models\UserAddress;
use App\Models\UserCompany;
use App\Models\UserContact;
use App\Models\UserDocument;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class AccountController extends Controller
{
    public function getUserId()
    {
        return auth()->user()->id;
    }

    public function setContactData(Request $request)
    {
        $contact = UserContact::query();

        $validatedData = Validator::make(
            [
                'contacts' => $request->contacts,
            ],
            [
                'contacts.cell_phone' => 'required',
                'contacts.email' => "required|email",
            ],
            [
                'required' => "O :attribute é obrigatório!",
            ],
            [
                'contacts.phone' => 'Telefone',
                'contacts.cell_phone' => "Celular",
                'contacts.email' => "E-mail",
                'contacts.whatsapp' => "Whatsapp",
            ]
        );

        if ($validatedData->fails()) {
            $errors = $validatedData->errors();

            return redirect()->back()->withErrors($errors)->withInput();
        } else {
            $validatedData = $validatedData->validate();
        }

        try {
            foreach ($validatedData['contacts'] as $key => $value) {
                if ($value) {
                    if ($contact->where('contact', $value)->count() === 0) {
                        $data = [
                            'user_id' => $this->getUserId(),
                            'type' => $key,
                            'contact' => $key === 'email' ? $value : Helpers::removeCaracteresEspeciais($value)
                        ];
    
                        $contact->create($data);
                    } else {
                        return "$key já cadastrado";
                    }
                }
            }
        } catch (\Throwable $th) {
            return redirect()->back()->withErrors('Não foi possível salvar os dados, verifique-os e tente novamente')->withInput();
        }
        
        return redirect(route('dashboard'));
    }
    
    public function setAddress(Request $request)
    {
        $address = UserAddress::query();

        $validatedData = Validator::make(
            [
                'user_id' => $this->getUserId(),
                'postal_code' => Helpers::removeCaracteresEspeciais($request->postal_code),
                'street' => $request->street,
                'number' => $request->number,
                'neighborhood' => $request->neighborhood,
                'complement' => $request->complement,
                'city' => $request->city,
                'state' => $request->state,
            ],
            [
                'user_id' => 'required',
                'postal_code' => 'required|size:8',
                'street' => 'required',
                'number' => 'required|numeric',
                'neighborhood' => 'required',
                'complement' => '',
                'city' => 'required',
                'state' => 'required',
            ],
            [
                'required' => "O :attribute é obrigatório!",
            ],
            [
                'postal_code' => 'CEP',
                'street' => 'Endereço',
                'number' => 'Número',
                'neighborhood' => 'Bairro',
                'complement' => 'Complemento',
                'city' => 'Cidade',
                'state' => 'Estado',
            ]
        );

        if ($validatedData->fails()) {
            $errors = $validatedData->errors();
            return redirect()->back()->withErrors($errors)->withInput();
            // return response()->json(['errors' => $errors], 422);
        } else {
            $validatedData = $validatedData->validate();
        }
        
        if ($address->where('user_id', $this->getUserId())->count() < 1) {
            try {
                $address->create($validatedData);
            } catch (\Throwable $th) {
                return redirect()->back()->withErrors('Não foi possível salvar os dados, verifique-os e tente novamente')->withInput();
            }
        } else {
            return redirect('/dashboard')->with('message', 'Essa conta já possui endereço cadastrados.');
        }

        return redirect(route('dashboard'));
    }

    public function setCompanyData(Request $request)
    {
        $company = UserCompany::query();

        // return Helpers::removeMaskCPFCNPJ($request->cnpj);

        $validatedData = Validator::make(
            [
                'user_id' => $this->getUserId(),
                'cnpj' => $request->cnpj ? Helpers::removeMaskCPFCNPJ($request->cnpj) : $request->cnpj,
                'company_name' => $request->company_name,
                'fantasy_name' => $request->fantasy_name,
                'municipal_registration' => $request->municipal_registration,
                'state_registration' => $request->state_registration,
            ],
            [
                'user_id' => 'required',
                'cnpj' => 'required|numeric|digits:14',
                'company_name' => 'required',
                'fantasy_name' => 'required',
                'municipal_registration' => 'required',
                'state_registration' => 'required',
            ],
            [
                'required' => "O :attribute é obrigatório!",
            ],
            [
                'cnpj' => 'CNPJ',
                'company_name' => 'Nome da Empresa',
                'fantasy_name' => 'Nome Fantasia',
                'municipal_registration' => 'Registro Municipal',
                'state_registration' => 'Registro Estadual',
            ]
        );

        if ($validatedData->fails()) {
            $errors = $validatedData->errors();
            return redirect()->back()->withErrors($errors)->withInput();
            // return response()->json(['errors' => $errors], 422);
        } else {
            $validatedData = $validatedData->validate();
        }

        if ($company->where('user_id', $this->getUserId())->count() < 1) {
            try {
                $company->create($validatedData);
            } catch (\Throwable $th) {
                return redirect()->back()->withErrors('Não foi possível salvar os dados, verifique-os e tente novamente')->withInput();
            }
        } else {
            return redirect('/dashboard')->with('message', 'Essa conta já possui dados de contato cadastrados.');
        }

        return redirect(route('dashboard'));
    }

    public function sendDocuments(Request $request)
    {
        $validatedData = Validator::make(
            [
                'documents' => $request->documents,
            ],
            [
                'documents.cnpj' => 'required|mimes:jpg,png,pdf,jpeg',
                'documents.social_contract' => "required|mimes:jpg,png,pdf,jpeg",
                'documents.proof_residence' => "required|mimes:jpg,png,pdf,jpeg",
            ],
            [
                'required' => "O :attribute é obrigatório!",
            ],
            [
                'documents.cnpj' => "CNPJ",
                'documents.social_contract' => "Contrato Social",
                'documents.proof_residence' => "Comprovante de Endereço",
            ]
        );

        if ($validatedData->fails()) {
            $errors = $validatedData->errors();

            return redirect()->back()->withErrors($errors)->withInput();
        } else {
            $validatedData = $validatedData->validate();
        }

        foreach ($validatedData['documents'] as $key => $document) {
            $url = Storage::putFile('documents', new File($document));

            $doc_type = explode("/", Storage::mimeType($url));
            $doc_type = $doc_type[1];

            UserDocument::create([
                'user_id' => $this->getUserId(),
                'type' =>  $doc_type,
                'name' => $key,
                'url' => Storage::path($url),
            ]);
        }

        return redirect(route('dashboard'))->with('message', 'Documentos enviados com sucesso!');
    }
}
