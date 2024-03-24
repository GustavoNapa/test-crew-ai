<?php

use App\Models\AccountPerson;
use App\Models\User;
use App\Models\UserAddress;
use App\Models\UserCompany;
use App\Models\UserContact;
use App\Models\UserDocument;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Http;

use function Pest\Laravel\actingAs;
use function Pest\Laravel\assertDatabaseHas;
use function Pest\Laravel\session;

describe('upload document on user POST /conta/enviar_documentos', function () {
    it('has /conta/enviar_documentos submit POST', function () {
        $user = User::factory()->create();

        $data = generateDocs();

        // $data['user_id'] = $user->id;

        actingAs($user)
            ->post('/conta/enviar_documentos', $data)->assertRedirect('/dashboard');
    });

    it('update in database documentUploaded to true', function () {
        $user = User::factory()->create();
        $userDocuments = UserDocument::factory()->create();

        $data = generateDocs();

        actingAs($user)
            ->post('/conta/enviar_documentos', $data)
            ->assertRedirect('/dashboard');

            $arrayAttributes = $userDocuments->attributesToArray();
        
            unset($arrayAttributes['id']);
            unset($arrayAttributes['created_at']);
            unset($arrayAttributes['updated_at']);
        
            assertDatabaseHas('user_documents', $arrayAttributes);
    });

    it('cnpj, social_contract, proof_residence are required', function () {
        $user = User::factory()->create();
        UserContact::factory()->create(['user_id' => $user->id, 'contact' => fake()->phoneNumber(), 'type' => 'cell_phone']);
        UserContact::factory()->create(['user_id' => $user->id, 'contact' => fake()->email(), 'type' => 'email']);
        UserAddress::factory()->create(['user_id' => $user->id]);
        UserCompany::factory()->create(['user_id' => $user->id]);

        actingAs($user)
            ->post('/conta/enviar_documentos')
            ->assertSessionHasErrors([
                'documents.cnpj' => "O CNPJ é obrigatório!",
                'documents.social_contract' => "O Contrato Social é obrigatório!",
                'documents.proof_residence' => "O Comprovante de Endereço é obrigatório!",
        ]);
    });
});

function generateDocs()
{
    return [
        'documents' => [
            'cnpj' => UploadedFile::fake()->image('cnpj.jpg', 100),
            'social_contract' => UploadedFile::fake()->image('social_contract.jpg', 100),
            'proof_residence' => UploadedFile::fake()->image('proof_residence.jpg', 100),
        ]
    ];
}
