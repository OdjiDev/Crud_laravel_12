<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Produit;
use App\Models\Categorie;
use App\Http\Resources\ProduitResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ProduitController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Récupère tous les produits avec leur catégorie
        $produits = Produit::with('categorie')->get();
        
        return ProduitResource::collection($produits);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validation des données
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'description' => 'required|string',
            'quantite' => 'required|integer|min:0',
            'prix' => 'required|numeric|min:0',
            'categorie_id' => 'required|exists:categories,id',
            'status' => 'required|in:disponible,indisponible,en_rupture',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        try {
            // Gestion de l'upload d'image
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('produits', 'public');
                $validated['image'] = $imagePath;
            }

            // Création du produit
            $produit = Produit::create($validated);

            // Charge la relation catégorie pour la réponse
            $produit->load('categorie');

            return (new ProduitResource($produit))
                ->response()
                ->setStatusCode(201);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la création du produit: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $produit = Produit::with('categorie')->find($id);

        if (!$produit) {
            return response()->json([
                'success' => false,
                'message' => 'Produit non trouvé'
            ], 404);
        }

        return new ProduitResource($produit);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $produit = Produit::find($id);

        if (!$produit) {
            return response()->json([
                'success' => false,
                'message' => 'Produit non trouvé'
            ], 404);
        }

        // Validation des données
        $validated = $request->validate([
            'nom' => 'sometimes|string|max:255',
            'description' => 'sometimes|string',
            'quantite' => 'sometimes|integer|min:0',
            'prix' => 'sometimes|numeric|min:0',
            'categorie_id' => 'sometimes|exists:categories,id',
            'status' => 'sometimes|in:disponible,indisponible,en_rupture',
            'image' => 'sometimes|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        try {
            // Gestion de l'image
            if ($request->hasFile('image')) {
                // Supprimer l'ancienne image si elle existe
                if ($produit->image && Storage::disk('public')->exists($produit->image)) {
                    Storage::disk('public')->delete($produit->image);
                }
                
                $imagePath = $request->file('image')->store('produits', 'public');
                $validated['image'] = $imagePath;
            }

            // Mise à jour du produit
            $produit->update($validated);

            // Recharger les relations
            $produit->load('categorie');

            return new ProduitResource($produit);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la mise à jour: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $produit = Produit::find($id);

        if (!$produit) {
            return response()->json([
                'success' => false,
                'message' => 'Produit non trouvé'
            ], 404);
        }

        try {
            // Supprimer l'image si elle existe
            if ($produit->image && Storage::disk('public')->exists($produit->image)) {
                Storage::disk('public')->delete($produit->image);
            }

            $produit->delete();

            return response()->json([
                'success' => true,
                'message' => 'Produit supprimé avec succès'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Restore soft deleted product.
     */
    public function restore($id)
    {
        $produit = Produit::withTrashed()->find($id);

        if (!$produit) {
            return response()->json([
                'success' => false,
                'message' => 'Produit non trouvé'
            ], 404);
        }

        $produit->restore();
        $produit->load('categorie');

        return new ProduitResource($produit);
    }

    /**
     * Get trashed products.
     */
    public function trashed()
    {
        $produits = Produit::onlyTrashed()->with('categorie')->get();
        
        return ProduitResource::collection($produits);
    }

    /**
     * Force delete product.
     */
    public function forceDelete($id)
    {
        $produit = Produit::withTrashed()->find($id);

        if (!$produit) {
            return response()->json([
                'success' => false,
                'message' => 'Produit non trouvé'
            ], 404);
        }

        try {
            // Supprimer l'image si elle existe
            if ($produit->image && Storage::disk('public')->exists($produit->image)) {
                Storage::disk('public')->delete($produit->image);
            }

            $produit->forceDelete();

            return response()->json([
                'success' => true,
                'message' => 'Produit supprimé définitivement'
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Erreur lors de la suppression: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Get products by category.
     */
    public function byCategory($categoryId)
    {
        // Vérifier si la catégorie existe
        $categorie = Categorie::find($categoryId);
        
        if (!$categorie) {
            return response()->json([
                'success' => false,
                'message' => 'Catégorie non trouvée'
            ], 404);
        }

        $produits = Produit::with('categorie')
            ->where('categorie_id', $categoryId)
            ->get();

        return ProduitResource::collection($produits);
    }

    /**
     * Search products by name or description.
     */
    public function search(Request $request)
    {
        $request->validate([
            'q' => 'required|string|min:2'
        ]);

        $query = $request->input('q');

        $produits = Produit::with('categorie')
            ->where('nom', 'LIKE', "%{$query}%")
            ->orWhere('description', 'LIKE', "%{$query}%")
            ->get();

        return ProduitResource::collection($produits);
    }

    /**
     * Get products with low stock.
     */
    public function lowStock()
    {
        $produits = Produit::with('categorie')
            ->where('quantite', '<=', 10) // Seuil de stock faible
            ->get();

        return ProduitResource::collection($produits);
    }

    /**
     * Update product quantity.
     */
    public function updateStock(Request $request, $id)
    {
        $produit = Produit::find($id);

        if (!$produit) {
            return response()->json([
                'success' => false,
                'message' => 'Produit non trouvé'
            ], 404);
        }

        $validated = $request->validate([
            'quantite' => 'required|integer|min:0',
            'operation' => 'sometimes|in:increment,decrement,set' // set par défaut
        ]);

        $operation = $request->input('operation', 'set');

        switch ($operation) {
            case 'increment':
                $produit->increment('quantite', $validated['quantite']);
                break;
            case 'decrement':
                $produit->decrement('quantite', $validated['quantite']);
                break;
            default: // set
                $produit->update(['quantite' => $validated['quantite']]);
                break;
        }

        $produit->load('categorie');

        return new ProduitResource($produit);
    }
}