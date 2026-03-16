<?php

namespace App\Http\Controllers;

use App\Models\Maladie;
use Illuminate\Http\Request;
use OpenApi\Attributes as OA;

#[OA\Info(title: "MALADIES API", version: "1.0.0", description: "Documentation API")]
#[OA\Server(url: "http://localhost:8000")]
class MaladieController extends Controller
{
    #[OA\Get(
        path: "/api/maladies",
        summary: "Lister les maladies",
        tags: ["Maladie"],
        responses: [
            new OA\Response(
                response: 200,
                description: "Liste paginee des maladies",
                content: new OA\JsonContent(
                    properties: [
                        new OA\Property(property: "current_page", type: "integer"),
                        new OA\Property(property: "data", type: "array", items: new OA\Items(
                            properties: [
                                new OA\Property(property: "id", type: "integer"),
                                new OA\Property(property: "name", type: "string"),
                                new OA\Property(property: "description", type: "string")
                            ]
                        )),
                        new OA\Property(property: "total", type: "integer")
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

        if ($request->has('date')) {
            $query->whereDate('created_at', '>=', $request->date);
        }

        $maladies = $query->paginate(10);
        return response()->json($maladies, 200);
    }

    #[OA\Post(
        path: "/api/maladies",
        summary: "Creer une maladie",
        tags: ["Maladie"],
        responses: [
            new OA\Response(response: 201, description: "Maladie creee avec succès"),
            new OA\Response(response: 422, description: "Erreur de validation")
        ]
    )]
    public function store(Request $request)
    {
        $valide = $request->validate([
            'name' => 'required|string',
            'description' => 'nullable'
        ]);
        if (!$valide) {
            return response()->json(['message' => 'Erreur de validation']);
        }
        $maladie = Maladie::create($request->all());

        return response()->json([
            'message' => 'Maladie creee avec succès',
            'data' => $maladie
        ], 201);
    }

    #[OA\Get(
        path: "/api/maladies/{id}",
        summary: "Details d'une maladie",
        tags: ["Maladie"],
        responses: [
            new OA\Response(response: 200, description: "Succes"),
            new OA\Response(response: 404, description: "Non trouvee")
        ]
    )]
    public function show($id)
    {
        $maladie = Maladie::find($id);

        if (!$maladie) {
            return response()->json(['message' => 'Maladie non trouvee'], 404);
        }

        return response()->json([
            'message' => 'Maladie trouvee',
            'data' => $maladie
        ], 200);
    }

    #[OA\Put(
        path: "/api/maladies/{id}",
        summary: "Modifier une maladie",
        tags: ["Maladie"],
        responses: [
            new OA\Response(response: 200, description: "Mise à jour reussie"),
            new OA\Response(response: 404, description: "Non trouvee")
        ]
    )]
    public function update(Request $request, $id)
    {
        $maladie = Maladie::find($id);

        if (!$maladie) {
            return response()->json(['message' => 'Maladie non trouvee'], 404);
        }

        $request->validate(['name' => 'sometimes|required']);
        $maladie->update($request->all());

        return response()->json([
            'message' => 'Maladie mise à jour avec succès',
            'data' => $maladie
        ], 200);
    }

    #[OA\Delete(
        path: "/api/maladies/{id}",
        summary: "Supprimer une maladie",
        tags: ["Maladie"],
        responses: [
            new OA\Response(response: 200, description: "Suppression reussie"),
            new OA\Response(response: 404, description: "Non trouvee")
        ]
    )]
    public function destroy($id)
    {
        $maladie = Maladie::find($id);

        if (!$maladie) {
            return response()->json(['message' => 'Maladie non trouvee'], 404);
        }

        $maladie->delete();

        return response()->json([
            'message' => 'Maladie supprimee avec succes'
        ], 200);
    }
}