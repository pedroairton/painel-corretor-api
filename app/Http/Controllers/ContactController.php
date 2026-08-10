<?php

namespace App\Http\Controllers;

use App\Http\Requests\Contact\StoreContactRequest;
use App\Http\Requests\Contact\UpdateContactRequest;
use App\Http\Resources\ContactResource;
use App\Models\Client;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;

class ContactController extends Controller
{
    public function store(StoreContactRequest $request, Client $client)
    {

        Gate::authorize('update', $client);

        $contact = DB::transaction(function () use ($request, $client, &$contact) {
            $contact = $client->contacts()->create($request->validated());

            $client->syncFromLatestContact();

            return $contact->fresh();
        });

        return response()->json([
            'success' => true,
            'message' => 'Contato criado com sucesso.',
            'data' => new ContactResource($contact)
        ], 201);
    }
    public function update(UpdateContactRequest $request, Contact $contact)
    {
        Gate::authorize('update', $contact);

        DB::transaction(function () use ($contact, $request) {
            $contact->update($request->validated());

            $contact->client->syncFromLatestContact();
        });

        return response()->json([
            'success' => true,
            'message' => 'Contato atualizado com sucesso.',
            'data' => new ContactResource($contact->fresh())
        ]);
    }
    public function destroy(Contact $contact)
    {
        Gate::authorize('delete', $contact);
        
        DB::transcation(function () use ($contact) {
            $client = $contact->client;
            $contact->delete();
            $client->syncFromLatestContact();
        });

        return response()->json([
            'success' => true,
            'message' => 'Contato excluido com sucesso.',
        ]);
    }
}
