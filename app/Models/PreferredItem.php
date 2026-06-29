<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PreferredItem extends Model
{
    protected $fillable = [
        'charity_id',
        'title',
        'description',
        'priority'
    ];

    public function charity()
    {
        return $this->belongsTo(Charity::class);
    }
}