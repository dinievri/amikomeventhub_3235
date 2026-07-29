<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::table('reviews', function (Blueprint $table) {
        // Sesuaikan tipe data dengan primary key pada tabel transactions (biasanya foreignId)
        $table->foreignId('transaction_id')->constrained()->onDelete('cascade');
    });
}

public function down(): void
{
    Schema::table('reviews', function (Blueprint $table) {
        $table->dropForeign(['transaction_id']);
        $table->dropColumn('transaction_id');
    });
}
    };