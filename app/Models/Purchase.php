<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Purchase extends Model
{
    protected $fillable = [
        'supplier_id',
        'medicine_id',
        'quantity',
        'purchase_price',
        'total_price',
        'purchase_date',
        'notes',
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'quantity' => 'integer',
        'purchase_date' => 'date',
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function medicine(): BelongsTo
    {
        return $this->belongsTo(Medicine::class);
    }
}
