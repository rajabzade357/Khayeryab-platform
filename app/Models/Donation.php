<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Donation extends Model
{
    protected $fillable = [
        'donor_id',
        'charity_id',
        'title',
        'description',
        'category',
        'images',
        'delivery_method',
        'pickup_date',
        'status',
        'rejection_reason' 
    ];

    protected $casts = [
        'images' => 'array',
        'pickup_date' => 'date'
    ];

    public function donor()
    {
        return $this->belongsTo(User::class, 'donor_id');
    }

    public function charity()
    {
        return $this->belongsTo(Charity::class);
    }
}