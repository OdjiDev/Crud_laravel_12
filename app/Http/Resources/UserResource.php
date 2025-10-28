<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,        // Champ personnalisé
            'prenom' => $this->prenom,  // Champ personnalisé
            'email' => $this->email,
            'telephone' => $this->telephone,
            'role' => $this->role,      // Champ personnalisé
            'statut' => $this->statut,  // Champ personnalisé
            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d H:i:s') : null,
            // On NE retourne PAS le mot de passe ni les images (sauf si nécessaire)
        ];
    }
}