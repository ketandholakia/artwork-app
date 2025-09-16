<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Database\Eloquent\SoftDeletes;


class Artwork extends Model
{
    use HasFactory, SoftDeletes;
    
    protected $fillable = [
        'description',
        'artworks_order_id',
        'requiredqty',
        'jobrun',
        'labelrepeat',
        'printedqty',
        'media_id',
        'remark',
        'awstatus',
        'prepressstage',
        'type',
        'priority',
        'url',
        'artworktechnameID'
    ];

    // Relationship to order
    public function order(): BelongsTo
    {
        return $this->belongsTo(Order::class, 'artworks_order_id');
    }

    // Accessor for order number to handle cases where order doesn't exist
    public function getOrderNoAttribute()
    {
        // Debug information
        \Illuminate\Support\Facades\Log::info('Order relationship', [
            'artwork_id' => $this->id,
            'artworks_order_id' => $this->artworks_order_id,
            'order' => $this->order
        ]);

        return $this->order?->orderno ?? 'No Order';
    }

    // Accessor for customer name
    public function getCustomerNameAttribute()
    {
        // Debug information
        \Illuminate\Support\Facades\Log::info('Customer relationship', [
            'artwork_id' => $this->id,
            'artworks_order_id' => $this->artworks_order_id,
            'order' => $this->order,
            'customer' => $this->order?->customer
        ]);

        return $this->order?->customer?->name ?? 'No Customer';
    }

    // Relationship to customer through order
    public function customer(): HasOneThrough
    {
        return $this->hasOneThrough(
            Customer::class,
            Order::class,
            'id', // Foreign key on the intermediate table (orders.id)
            'id', // Foreign key on the final table (customers.id)
            'artworks_order_id', // Local key on the current table (artworks.artworks_order_id)
            'customer_id' // Local key on the intermediate table (orders.customer_id)
        );
    }
}