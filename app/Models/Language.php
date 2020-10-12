<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Language extends BaseModel
{
    use HasFactory;
//    use HistoryTrait;

    public function definitions()
    {
        return $this->hasMany(LanguageDefinition::class, 'language_id', 'id');
    }
}
