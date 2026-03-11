<?php

namespace App\Http\Controllers;

use App\Models\Maladie;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA; 

#[OA\Info(title: "RareCare API", version: "1.0.0", description: "Documentation de l'API")]
#[OA\Server(url: "http://localhost:8000", description: "Serveur Local")]
class MaladieController extends Controller
{
    #[OA\Get(
        path: "/api/maladies",
        summary: "Lister toutes les maladies",
        tags: ["Maladie"],
        responses: [
            new OA\Response(response: 200, description: "Liste des maladies")
        ]
    )]
    public function index()
    {
        $maladies = Maladie::all();
        return response()->json($maladies);
    }

    #[OA\Post(
        path: "/api/maladies/store",
        summary: "Créer une nouvelle maladie",
        tags: ["Maladie"],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "name", type: "string"),
                    new OA\Property(property: "description", type: "string")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 201, description: "Maladie créée avec succès"),
            new OA\Response(response: 422, description: "Erreur de validation")
        ]
    )]
    public function store(Request $request)
    {
        $maladie = Maladie::create($request->all());
        return response()->json($maladie, 201);
    }

    #[OA\Get(
        path: "/api/maladies/{id}",
        summary: "Afficher une maladie spécifique",
        tags: ["Maladie"],
        parameters: [
            new OA\Parameter(
                name: "id",
                in: "path",
                required: true,
                description: "ID de la maladie",
                schema: new OA\Schema(type: "integer")
            )
        ],
        responses: [
            new OA\Response(response: 200, description: "Maladie trouvée"),
            new OA\Response(response: 404, description: "Maladie non trouvée")
        ]
    )]
    public function show($id)
    {
        $maladie = Maladie::findOrFail($id);
        return response()->json($maladie);
    }

    #[OA\Put(
        path: "/api/maladies/{id}",
        summary: "Mettre à jour une maladie",
        tags: ["Maladie"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        requestBody: new OA\RequestBody(
            required: true,
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "name", type: "string"),
                    new OA\Property(property: "description", type: "string")
                ]
            )
        ),
        responses: [
            new OA\Response(response: 200, description: "Maladie mise à jour"),
            new OA\Response(response: 404, description: "Maladie non trouvée")
        ]
    )]
    public function update(Request $request, $id)
    {
        $maladie = Maladie::findOrFail($id);
        $maladie->update($request->all());
        return response()->json($maladie);
    }

    #[OA\Delete(
        path: "/api/maladies/{id}",
        summary: "Supprimer une maladie",
        tags: ["Maladie"],
        parameters: [
            new OA\Parameter(name: "id", in: "path", required: true, schema: new OA\Schema(type: "integer"))
        ],
        responses: [
            new OA\Response(response: 200, description: "Maladie supprimée"),
            new OA\Response(response: 404, description: "Maladie non trouvée")
        ]
    )]
    public function destroy($id)
    {
        $maladie = Maladie::findOrFail($id);
        $maladie->delete();
        return response()->json(['message' => 'Maladie supprimée']);
    }
}