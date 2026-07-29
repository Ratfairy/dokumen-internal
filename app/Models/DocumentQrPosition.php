<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DocumentQrPosition extends Model
{
    protected $fillable = [
        'document_id',
        'sort_order',
        'page_number',
        'position_x',
        'position_y',
        'width',
        'height',
    ];

    public function document(): BelongsTo
    {
        return $this->belongsTo(Document::class);
    }
}