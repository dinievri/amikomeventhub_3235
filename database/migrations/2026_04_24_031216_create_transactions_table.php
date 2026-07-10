<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table) {
            $table->id();
            // Menghubungkan transaksi dengan id event
            $table->foreignId('event_id')->constrained()->onDelete('cascade');
            $table->string('order_id')->unique(); // ID unik transaksi (contoh: TRX-171829-XYZ)
            $table->string('customer_name');
            $table->string('customer_email');
            $table->string('customer_phone');
            $table->decimal('total_price', 12, 2);
            $table->string('status')->default('Pending'); // Pending, Success, Challenge, Failure
            $table->string('snap_token')->nullable(); // Untuk menyimpan token pembayaran Midtrans (Pertemuan 11)
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
