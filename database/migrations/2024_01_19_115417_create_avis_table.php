<?php

use App\Models\Plat;
use App\Models\Commande;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('avis', function (Blueprint $table) {
            $table->id();
            $table->enum('note', [0, 1, 2, 3, 4, 5])->default(0);
            $table->foreignIdFor(Commande::class)->constrained()->cascadeOnUpdate()->cascadeOnUpdate();
            $table->string('nomPlatCommande');
            $table->longText('commentaire');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('avis');
    }
};
