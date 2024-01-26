<?php

use App\Models\Plat;
use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('commandes', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Plat::class)->constrained()->cascadeOnUpdate()->cascadeOnUpdate();
            $table->foreignIdFor(User::class)->constrained()->cascadeOnUpdate()->cascadeOnUpdate();
            $table->string('numeroCommande')->unique();
            $table->integer('nombrePlats')->default(1);
            $table->string('nomPlat');
            $table->integer('prixCommande');
            $table->string('lieuLivraison');
            $table->enum('etatCommande',['acceptee', 'refusee'])->default('acceptee');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('commandes');
    }
};
