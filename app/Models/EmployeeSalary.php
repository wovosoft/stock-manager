<?php

namespace App\Models;

use App\Traits\HistoryTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployeeSalary extends BaseModel
{
    use HasFactory, HistoryTrait;

    public function employee()
    {
        return $this->belongsTo(Employee::class, 'employee_id');
    }
}
