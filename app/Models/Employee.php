<?php

namespace App\Models;

use App\Traits\HistoryTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Employee extends BaseModel
{
    use HasFactory, HistoryTrait;

    public function salaries()
    {
        return $this->hasMany(EmployeeSalary::class, 'employee_id', 'id');
    }
}
