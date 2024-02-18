<?php

namespace App\Models;

use App\Models\Commande;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Livraison extends Model
{
    use HasFactory;

    public function commande() 
    {
        return $this->hasOne(Commande::class);
    }
    
    public function livreur() 
    {
        return $this->hasOne(Livreur::class);
    }
}
