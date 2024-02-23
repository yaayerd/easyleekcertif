<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plat extends Model
{
    use HasFactory;

    public function menu()
    {
        return $this->belongsTo(Menu::class);
    }

    // public function commande()
    // {
    //     return $this->belongsTo(Commande::class);
    // }

    public function commandes()
    {
        return $this->hasMany(Commande::class);
    }

    protected $fillable = [
        'libelle', 'descriptif', 'prix', 'menu_id', 'image', 'is_archived',
    ];
}
