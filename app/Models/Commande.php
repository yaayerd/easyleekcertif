<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commande extends Model
{
    use HasFactory;

    // public function users()
    // {
    //     return $this->hasOne(User::class);
    // }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // public function plats()
    // {
    //     return $this->hasMany(Plat::class);
    // }

    public function plat()
    {
        return $this->belongsTo(Plat::class, 'plat_id');
    }

    public function livraisons()
    {
        return $this->belongsTo(Livraison::class);
    }

    public function avis()
    {
        return $this->hasMany(Avis::class);
    }

    protected $fillable = [
        'numeroCommande', 'nombrePlats', 'nomPlat', 'prixCommande', 'lieuLivraison', 'etatCommande'
    ];
}
