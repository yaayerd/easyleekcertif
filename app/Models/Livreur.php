<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Livreur extends Model
{
    use HasFactory, Notifiable;

    public  function user() 
    {
        return $this->belongsTo(User::class);
    }

    public function livraisons()
    {
        return $this->hasMany(Livraison::class);
    }

    protected $fillable = [
        'user_id',      
        'statutLivreur',
    ] ;
}
