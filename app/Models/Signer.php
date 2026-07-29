<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Signer extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi melalui form.
     */
    protected $fillable = [
        'name',
        'employee_number',
        'position',
        'work_unit',
        'institution',
        'is_active',
    ];

    /**
     * Konversi tipe data kolom.
     */
    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function documents(): HasMany
    {
        return $this->hasMany(Document::class);
    }
}