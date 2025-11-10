<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProduitResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'description' => $this->description,
            'quantite' => $this->quantite,
            'prix' => $this->prix,
            'status' => $this->status,
            'image' => $this->image ? asset('storage/' . $this->image) : null,
            'categorie' => $this->whenLoaded('categorie', function () {
                return [
                    'id' => $this->categorie->id,
                    'nom' => $this->categorie->nom,
                    // Ajoutez d'autres champs de catégorie si nécessaire
                ];
            }),
            // 'categorie_id' => $this->categorie_id,
            // 'created_at' => $this->created_at->format('Y-m-d H:i:s'),
            // 'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            // 'deleted_at' => $this->deleted_at?->format('Y-m-d H:i:s'),
        ];
    }
}
