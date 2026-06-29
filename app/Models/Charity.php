<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Charity extends Model
{
   protected $fillable = [
    'user_id',
    'registration_number',
    'national_id',
    'manager_name',
    'license_number',
    'license_image',
    'national_card_image',
    'bank_account_number',
    'iban',
    'logo',
    'is_approved',
    'description'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function donations()
    {
        return $this->hasMany(Donation::class);
    }

    public function preferredItems()
    {
        return $this->hasMany(PreferredItem::class);
    }
}