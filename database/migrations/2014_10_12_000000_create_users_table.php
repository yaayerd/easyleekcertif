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
            $table->boolean('is_activated')->default(1);
            $table->foreignIdFor(Role::class)->default(3)->constrained()->cascadeOnUpdate()->cascadeOnUpdate();
            $table->foreignIdFor(Categorie::class)->nullable()->constrained()->cascadeOnUpdate()->cascadeOnUpdate();
            $table->string('name');
            $table->string('email')->unique();
            $table->integer('phone');
            $table->string('adresse');
            $table->string('description')->nullable();
            $table->string('image')->nullable();
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