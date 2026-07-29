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
    Schema::table('customers', function (Blueprint $table) {
        $table->rememberToken()->after('google_id'); // Menambahkan kolom remember_token
    });
}

public function down(): void
{
    Schema::table('customers', function (Blueprint $table) {
        $table->dropColumn('remember_token');
    });
}
};
