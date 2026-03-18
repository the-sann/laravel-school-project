<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use HasFactory;

    protected $fillable = [
        'po_number',
        'customer_id',
        'sale_date',
        'total_amount',
    ];

    protected $casts = [
        'sale_date' => 'date', // or 'datetime' if you want time too
    ];


    // Relationship to customer
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    // Relationship to sale items
    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
}
