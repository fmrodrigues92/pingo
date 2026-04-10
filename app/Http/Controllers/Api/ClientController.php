<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreClientRequest;
use App\Src\Client\Application\DTOs\CreateClientInput;
use App\Src\Client\Application\UseCases\CreateClientUseCase;
use App\Src\Client\Application\UseCases\ListClientsUseCase;
use App\Src\Client\Presentation\Transformers\ClientTransformer;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

/**
 * Handle API operations for clients.
 */
class ClientController extends Controller
{
    /**
     * Return a JSON list of clients filtered by the optional search term.
     *
     * @param  Request  $request  The current HTTP request instance.
     * @param  ListClientsUseCase  $useCase  Use case responsible for listing clients.
     * @return JsonResponse  JSON response containing the transformed client collection.
     */
    public function index(Request $request, ListClientsUseCase $useCase): JsonResponse
    {
        $clients = $useCase->execute(
            search: $request->string('search')->toString() ?: null
        );

        return response()->json([
            'success' => true,
            'data' => ClientTransformer::transformCollection($clients),
        ]);
    }

    /**
     * Store a new client and return the created resource as JSON.
     *
     * @param  StoreClientRequest  $request  Validated request with client payload.
     * @param  CreateClientUseCase  $useCase  Use case responsible for client creation.
     * @return JsonResponse  JSON response containing the created client.
     */
    public function store(StoreClientRequest $request, CreateClientUseCase $useCase): JsonResponse
    {
        $client = $useCase->execute(
            new CreateClientInput(
                name: $request->string('name')->toString(),
                slug: $request->filled('slug') ? $request->string('slug')->toString() : null,
                description: $request->filled('description') ? $request->string('description')->toString() : null,
                isActive: $request->boolean('is_active', true),
            )
        );

        return response()->json([
            'success' => true,
            'message' => 'Client created successfully.',
            'data' => ClientTransformer::transform($client),
        ], 201);
    }
}
