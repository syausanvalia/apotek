<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Supplier extends Model
{
    protected $fillable = [
        'name',
        'contact_person',
        'phone',
        'email',
        'address',
    ];

    public function medicines(): HasMany
    {
        return $this->hasMany(Medicine::class);
    }

    public function purchases(): HasMany
    {
        return $this->hasMany(Purchase::class);
    }
}
