<?php

namespace App\Http\Controllers;

use App\Enums\InterestStatus;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Http\Resources\ClientResource;
use App\Models\Client;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class ClientController extends Controller
{
    public function index(Request $request)
    {
        $clients = Client::query()
            ->where('user_id', $request->user()->id)
            ->with('latestContact')
            ->filters($request->only([
                'search',
                'status',
                'sort'
            ]))
            ->paginate(10)
            ->withQueryString();

        return ClientResource::collection($clients);
    }
    public function show(Client $client)
    {
        $this->authorize('view', $client);

        $client->load([
            'contacts' => fn($query) =>
                $query->latest('contact_date')
        ]);

        return new ClientResource($client);
    }
    public function store(StoreClientRequest $request)
    {
        $client = $request->user()->clients()->create($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Cliente criado com sucesso.',
            'data' => new ClientResource($client)
        ], 201);
    }
    public function update(UpdateClientRequest $request, Client $client)
    {
        $this->authorize('update', $client);

        $client->update($request->validated());

        return response()->json([
            'success' => true,
            'message' => 'Cliente atualizado com sucesso.',
            'data' => new ClientResource($client->fresh())
        ]);
    }
    public function patchClient(Request $request, Client $client)
    {
        $this->authorize('update', $client);

        $request->validate([
            'priority' => 'sometimes|integer|between:1,5',
            'interest_status' => ['sometimes', Rule::enum(InterestStatus::class)]
        ]);

        if (isset($request->priority)) {
            $client->update(['priority' => $request->priority]);
        }
        if (isset($request->interest_status)) {
            $client->update(['interest_status' => $request->interest_status]);
        }

        return response()->json([
            'success' => true,
            'message' => 'Cliente atualizado com sucesso.',
            // 'data' => new ClientResource($client->fresh())
        ]);
    }
    public function destroy(Client $client)
    {
        $this->authorize('delete', $client);

        $client->delete();

        return response()->json([
            'success' => true,
            'message' => 'Cliente excluido com sucesso.',
        ]);
    }
    public function dashboard(Request $request)
    {

        $user = $request->user();

        $clientsQuery = Client::query()->where('user_id', $user->id);

        $dashboard = [
            'total_clients' => (clone $clientsQuery)->count(),
            'total_contacts' => Contact::query()->whereHas('client', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })->count(),
            'high_interest_clients' => (clone $clientsQuery)->where('interest_status', InterestStatus::VERY_INTERESTED)->count(),
            'closed_deals' => (clone $clientsQuery)->where('interest_status', InterestStatus::CLOSED_DEAL)->count(),
            'clients_without_contacts' => (clone $clientsQuery)->whereDoesntHave('contacts')->count()
        ];

        return response()->json([
            'success' => true,
            'data' => $dashboard
        ], 200);
    }
}
