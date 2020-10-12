<?php

namespace App\Models;

use App\Traits\HistoryTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CapitalDeposit extends BaseModel
{
    use HasFactory,HistoryTrait;
}
