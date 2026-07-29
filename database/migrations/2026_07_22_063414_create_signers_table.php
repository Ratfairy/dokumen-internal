<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel master penandatangan.
     */
    public function up(): void
    {
        Schema::create('signers', function (Blueprint $table) {
            $table->id();

            $table->string('name', 150);
            $table->string('employee_number', 50)->nullable();
            $table->string('position', 150);
            $table->string('work_unit', 150);
            $table->string('institution', 200);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Menghapus tabel master penandatangan.
     */
    public function down(): void
    {
        Schema::dropIfExists('signers');
    }
};