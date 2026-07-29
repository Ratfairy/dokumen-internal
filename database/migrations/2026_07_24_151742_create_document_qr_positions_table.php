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
        Schema::create('document_qr_positions', function (Blueprint $table) {

            $table->id();

            $table->foreignId('document_id')
                ->constrained()
                ->cascadeOnDelete();

            /*
            * Urutan QR apabila terdapat lebih dari satu QR.
            */
            $table->unsignedInteger('sort_order')
                ->default(1);

            /*
            * Halaman tempat QR ditempel.
            */
            $table->unsignedInteger('page_number');

            /*
            * Posisi QR pada halaman (dalam mm).
            */
            $table->decimal('position_x', 8, 2);

            $table->decimal('position_y', 8, 2);

            /*
            * Ukuran QR.
            */
            $table->decimal('width', 8, 2)
                ->default(35);

            $table->decimal('height', 8, 2)
                ->default(35);

            $table->timestamps();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('document_qr_positions');
    }
};
