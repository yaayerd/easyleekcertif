<?php

namespace App\Models;

use App\Models\Commande;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Livraison extends Model
{
    use HasFactory;

    public function livreurs()
    {
        return $this->belongsTo(Livreur::class);
    }

    public function commandes() 
    {
        return $this->hasOne(Commande::class);
    }
}
