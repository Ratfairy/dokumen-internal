<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Membuat tabel dokumen.
     */
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();

            // Metadata dokumen
            $table->string('document_number', 100)->unique();
            $table->string('subject', 255);
            $table->date('document_date');

            // Penandatangan dokumen
            $table->foreignId('signer_id')
                ->constrained('signers')
                ->restrictOnDelete();

            // File PDF sebelum dan sesudah diberi QR Code
            $table->string('original_file_name', 255);
            $table->string('original_pdf_path', 255);
            $table->string('final_pdf_path', 255)->nullable();

            // Informasi verifikasi
            $table->string('verification_token', 64)
                ->nullable()
                ->unique();

            $table->string('sha256_hash', 64)->nullable();

            // Status dokumen
            $table->string('status', 30)->default('DRAFT');

            // Waktu penerbitan dan pencabutan
            $table->timestamp('signed_at')->nullable();
            $table->timestamp('revoked_at')->nullable();
            $table->text('revocation_reason')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Menghapus tabel dokumen.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};