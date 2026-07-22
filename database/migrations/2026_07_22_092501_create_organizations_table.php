<?php

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
        Schema::create('organizations', function (Blueprint $table) {
        $table->id();
        // Menghubungkan Organisasi dengan akun User (Panitia/HIMA)
        $table->foreignId('user_id')->constrained()->cascadeOnDelete(); 
        $table->string('name'); // Contoh: HMTI AMIKOM, BEM, KOMA
        $table->string('slug')->unique();
        $table->text('description')->nullable();
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('organizations');
    }
};
