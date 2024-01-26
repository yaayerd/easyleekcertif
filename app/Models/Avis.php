<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
