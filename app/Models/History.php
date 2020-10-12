<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class History extends BaseModel
{
    use HasFactory;
    protected $casts = [
        'old_values' => 'json',
        'new_values' => 'json'
    ];
}
