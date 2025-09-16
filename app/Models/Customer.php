<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model


{
    use HasFactory;

      protected $fillable = [ 'name',
        'contact_person',
        'contact_no',
        'email',
        'city',
    ];


      public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'orders_customer_id');
    }

    
}
