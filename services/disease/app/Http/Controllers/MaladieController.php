<?php

namespace App\Http\Controllers;

use App\Models\Maladie;
use App\Models\User;
use Illuminate\Http\Request;

class MaladieController extends Controller
{
  /**
     * @OA\Get(
     *     path="/api/Maladies",
     *     summary="Lister tous les Maladies",
     *     tags={"Maladie"},
     *     @OA\Response(response=200, description="Liste des Maladie")
     * )
     */
    public function index()
    {
        $maladies = Maladie::all();
        return response()->json($maladies);
    }
    
    // store Maladie

    /** 
    * @OA\Post(
    * path = "/api/Maladies",
    * sammaray = "Creer un nouvel maladie",
    * tags = {"Maladie"},
    * @OA\RequestBody(
    * required = true,
   *  @OA\JsonContent(
   * @OA\proprety(property = "description",type = "string")
   * @OA\proprety(property = "name" , type = "string"),
   * )
   * ),
   * @OA\Responce(responce = 201,description = "le maladie cree avec succes")


    *)
   */

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $maladie = Maladie::create($request->all());
        return response()->json($maladie, 201);
    }
    public function ss(Request $request){
        Maladie::create($request->all());
    }

    // Affiche une maladie spécifique
    /** @OA\Get(
     * path = "/api/Maladie",
     * sammury = "afficher un maladie",
     * Tags = {"Maladie"},
     * @OA\parameter(
     * name = "id",
     * in = "path",
     * requerd = true,
     * @OA\schema(type = "integer"),
     * @OA\Response(response=200, description="Maladie trouve"),
     * @OA\Response(response=404, description="Maladie non trouve")
     * )
     * )
    */
    public function show($id)
    {
        $maladie = Maladie::findOrFail($id);
        return response()->json($maladie);
    }

    // Met à jour une maladie


        /**
     * @OA\Put(
     *     path="/api/Maladie/{id}",
     *     summary="update un Maladie",
     *     tags={"Maladies"},
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="ID de l'utilisateur",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             @OA\Property(property="name", type="string"),
     *             @OA\Property(property="email", type="string")
     *         )
     *     ),
     *     @OA\Response(response=200, description="Utilisateur mis à jour"),
     *     @OA\Response(response=404, description="Utilisateur non trouvé")
     * )
     */


    public function update(Request $request, $id)
    {
        $maladie = Maladie::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $maladie->update($request->all());
        return response()->json($maladie);
    }

    // Supprime une maladie
    public function destroy($id)
    {
        $maladie = Maladie::findOrFail($id);
        $maladie->delete();
        return response()->json(['message' => 'Maladie supprimee']);
    }
}