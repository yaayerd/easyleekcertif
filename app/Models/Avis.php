<?php

namespace App\Models;

use App\Models\Plat;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Avis extends Model
{
    use HasFactory;

    public function commandes() {
        return $this->belongsTo(Commande::class);
        }
        
    protected $fillable = [
            'note', 'commentaire', 'commande_id'
        ]; 
}
