<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Medicine extends Model
{
    protected $fillable = [
        'name',
        'description',
        'category',
        'price',
        'stock',
        'supplier_id',
        'expiry_date',
        'status',
        'image',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'expiry_date' => 'date',
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }

    public function sales(): HasMany
    {
        return $this->hasMany(Sale::class);
    }

    public function isExpired(): bool
    {
        return $this->expiry_date && $this->expiry_date->isPast();
    }

    public function isAvailable(): bool
    {
        return $this->status === 'available' && $this->stock > 0;
    }
}
