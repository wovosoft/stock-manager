<?php

namespace App\Models;


use App\Builders\Reports;
use App\Traits\HistoryTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Customer extends BaseModel
{
    use HistoryTrait;
    use HasFactory;

    public function sales()
    {
        return $this->hasMany(Sale::class, 'customer_id', 'id');
    }

    public function funds()
    {
        return $this->hasMany(CustomerFund::class, 'customer_id', 'id');
    }

    public function accountBalance()
    {
        return (new Reports())->customerBalance($this->id);
    }
}
