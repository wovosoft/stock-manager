<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Factories\HasFactory;

class LanguageDefinition extends BaseModel
{
    use HasFactory;
    protected $guarded = ['id'];

    public function language()
    {
        return $this->belongsTo(Language::class, 'language_id', 'id');
    }
}
