<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Liste tous les utilisateurs
     */
    public function index()
    {
        $users = User::all();
        return UserResource::collection($users);
    }

    /**
     * Créer un nouvel utilisateur
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'prenom' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'telephone' => 'required|string|max:20',
            'password' => 'required|min:8',
            'role' => 'required|in:ADMIN,USER,MANAGER',
            'statut' => 'required|in:Active,Inactive'
        ]);

        $user = User::create([
            'nom' => $validated['nom'],
            'prenom' => $validated['prenom'],
            'email' => $validated['email'],
            'telephone' => $validated['telephone'],
            'password' => Hash::make($validated['password']),
            'role' => $validated['role'],
            'statut' => $validated['statut']
        ]);

        return (new UserResource($user))->response()->setStatusCode(201);
    }

    /**
     * Afficher un utilisateur spécifique
     */
    public function show($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non trouvé'
            ], 404);
        }

        return new UserResource($user);
    }

    /**
     * Mettre à jour un utilisateur
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non trouvé'
            ], 404);
        }

        $validated = $request->validate([
            'nom' => 'sometimes|string|max:255',
            'prenom' => 'sometimes|string|max:255',
            'email' => [
                'sometimes',
                'email',
                Rule::unique('users')->ignore($user->id)
            ],
            'telephone' => 'sometimes|string|max:20',
            'password' => 'sometimes|min:8',
            'role' => 'sometimes|in:ADMIN,USER,MANAGER',
            'statut' => 'sometimes|in:Active,Inactive'
        ]);

        // Hash le mot de passe s'il est fourni
        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $user->update($validated);

        return new UserResource($user);
    }

    /**
     * Supprimer un utilisateur
     */
    public function destroy($id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non trouvé'
            ], 404);
        }

        $user->delete();

        return response()->json([
            'success' => true,
            'message' => 'Utilisateur supprimé avec succès'
        ], 200);
    }

    /**
     * Restaurer un utilisateur supprimé (soft delete)
     */
    public function restore($id)
    {
        $user = User::withTrashed()->find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non trouvé'
            ], 404);
        }

        $user->restore();

        return new UserResource($user);
    }

    /**
     * Liste des utilisateurs supprimés
     */
    public function trashed()
    {
        $users = User::onlyTrashed()->get();
        return UserResource::collection($users);
    }

    /**
     * Suppression définitive
     */
    public function forceDelete($id)
    {
        $user = User::withTrashed()->find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Utilisateur non trouvé'
            ], 404);
        }

        $user->forceDelete();

        return response()->json([
            'success' => true,
            'message' => 'Utilisateur supprimé définitivement'
        ], 200);
    }
}