<?php

use App\Models\Menu;
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
        Schema::create('plats', function (Blueprint $table) {
            $table->id();
            $table->boolean('is_archived')->default(0);
            $table->foreignIdFor(Menu::class)->constrained()->cascadeOnUpdate()->cascadeOnUpdate();
            $table->string('libelle');
            $table->integer('prix');
            $table->string('image');
            $table->longText('descriptif');
            $table->timestamps();
        });
    }

    /**
     */
    //   Reverse the migrations.
    public function down(): void
    {
        Schema::dropIfExists('plats');
    }
};
