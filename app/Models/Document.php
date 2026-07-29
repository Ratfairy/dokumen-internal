<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Document extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi melalui form.
     */
    protected $fillable = [
        'document_number',
        'subject',
        'document_date',
        'signer_id',

        'signer_name',
        'signer_employee_number',
        'signer_position',
        'signer_work_unit',
        'signer_institution',

        'original_file_name',
        'original_pdf_path',
        'final_pdf_path',
        'verification_token',
        'sha256_hash',
        'status',
        'signed_at',
        'revoked_at',
        'revocation_reason',
    ];

    /**
     * Konversi tipe data dari database.
     */
    protected function casts(): array
    {
        return [
            'document_date' => 'date',
            'signed_at' => 'datetime',
            'revoked_at' => 'datetime',
        ];
    }

    /**
     * Penandatangan yang dipilih untuk dokumen ini.
     */
    public function signer(): BelongsTo
    {
        return $this->belongsTo(Signer::class);
    }

    public function qrPositions(): HasMany
    {
        return $this->hasMany(DocumentQrPosition::class)
                    ->orderBy('sort_order');
    }
}