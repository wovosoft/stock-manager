<?php

namespace App\Models;

use App\Traits\HistoryTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Brand extends BaseModel
{
    use HistoryTrait, HasFactory;
}
