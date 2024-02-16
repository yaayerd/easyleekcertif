<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    public function users() {
        return $this->hasOne(User::class);
        }
    
    public function plats() {
        return $this->hasOne(Plat::class);
    }

    public function avis() {
        return $this->hasMany(Avis::class);
       }

       public function livraisons() 
       {
           return $this->belongsTo(Livraison::class);
       }

       protected $fillable = [
        'numeroCommande', 'nombrePlats', 'nomPlat', 'prixCommande', 'lieuLivraison', 'etatCommande'
    ]; 
}
