<?php

namespace App\Models;


use App\Traits\HistoryTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Unit extends BaseModel
{
    use HistoryTrait, HasFactory;
}
