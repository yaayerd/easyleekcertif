<?php

use App\Models\Role;
use App\Models\Categorie;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->foreignIdFor(Role::class)->constrained()->cascadeOnUpdate()->cascadeOnUpdate();
            $table->foreignIdFor(Categorie::class)->nullable()->constrained()->cascadeOnUpdate()->cascadeOnUpdate();
            $table->string('email')->unique();
            $table->integer('phone');
            $table->string('adresse');
            $table->boolean('is_activated')->default(0);
            $table->string('cover')->nullable();
            $table->string('slogan')->nullable();
            $table->string('password');
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
// Schema::create('restaurants', function (Blueprint $table) {
//     $table->id();
//     $table->string('image');
//     $table->string('slogan');
//     $table->foreignIdFor(User::class)->constrained()->cascadeOnUpdate()->cascadeOnUpdate();
//     $table->timestamps();
// });