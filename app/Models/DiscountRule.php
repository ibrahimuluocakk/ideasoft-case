<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DiscountRule extends Model
{
    protected $fillable = [
        'name',
        'type',
        'conditions',
        'discount_amount',
        'discount_percent',
        'is_active',
        'priority'
    ];

    protected $casts = [
        'conditions' => 'array',
        'discount_amount' => 'decimal:2',
        'discount_percent' => 'decimal:2',
        'is_active' => 'boolean',
        'priority' => 'integer'
    ];
}
