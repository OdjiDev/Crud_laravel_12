<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Produit extends Model
{
    use SoftDeletes, HasFactory;

    protected $fillable = [
        "nom",
        "description",
        "quantite",
        "categorie_id",
        "prix",
        "status",
        "image",
    ];

    public function categorie(){
        return $this->belongsTo(Categorie::class);
    }
}
