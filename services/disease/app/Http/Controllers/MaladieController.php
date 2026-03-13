<?php

namespace App\Http\Controllers;

use App\Models\Maladie;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA; 

#[OA\Info(title: "MALADIES API", version: "1.0.0", description: "Documentation de l'API")]
#[OA\Server(url: "http://localhost:8000", description: "Serveur Local")]

class MaladieController extends Controller
{
#[OA\Get(
    path: "/api/maladies",
    summary: "Lister toutes les maladies avec filtres et pagination",
    tags: ["Maladie"],
    parameters: [
        new OA\Parameter(
            name: "name",
            in: "query",
            description: "Filtrer par nom (partiel)",
            required: false,
            schema: new OA\Schema(type: "string")
        ),
        new OA\Parameter(
            name: "type",
            in: "query",
            description: "Filtrer par type",
            required: false,
            schema: new OA\Schema(type: "string")
        ),
        new OA\Parameter(
            name: "date",
            in: "query",
            description: "Filtrer par date de création (>",
            required: false,
            schema: new OA\Schema(type: "string", format: "date")
        ),
        new OA\Parameter(
            name: "page",
            in: "query",
            description: "Numéro de la page pour la pagination",
            required: false,
            schema: new OA\Schema(type: "integer")
        )
    ],
    responses: [
        new OA\Response(
            response: 200, 
            description: "Liste paginée des maladies filtrées",
            content: new OA\JsonContent(
                properties: [
                    new OA\Property(property: "current_page", type: "integer"),
                    new OA\Property(property: "data", type: "array", items: new OA\Items(
                        properties: [
                            new OA\Property(property: "id", type: "integer"),
                            new OA\Property(property: "name", type: "string"),
                            new OA\Property(property: "type", type: "string"),
                            new OA\Property(property: "description", type: "string")
                        ]
                    )),
                    new OA\Property(property: "total", type: "integer"),
                    new OA\Property(property: "per_page", type: "integer"),
                    new OA\Property(property: "last_page", type: "integer")
                ]
            )
        )
    ]
)]

  public function index(Request $request)
{
    $query = Maladie::query();

    if ($request->has('name')) {
        $query->where('name', 'like', '%' . $request->name . '%');
    }

    // if ($request->has('type')) {
    //     $query->where('type', $request->type);
    // }

    if ($request->has('date')) {
        $query->whereDate('created_at', '>=', $request->date);
    }

    $maladies = $query->paginate(10);
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