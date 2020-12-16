<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderCollection extends BaseModel
{
    use HasFactory;
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
