<?php

namespace App\Models;


use App\Traits\HistoryTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Facades\Artisan;

class Product extends BaseModel
{
    protected static function boot()
    {
        parent::boot();
        static::created(function ($product) {
            Artisan::call("record:products");
//            updateOrGenerateProductRecords($product->id);
        });

        static::updated(function ($product) {
            Artisan::call("record:products");
//            updateOrGenerateProductRecords($product->id);
        });

        static::deleted(function ($product) {
            Artisan::call("record:products");
//            updateOrGenerateProductRecords($product->id);
        });

    }

    use HasFactory;
    use HistoryTrait;

    protected $appends = [
        "photo_url"
    ];


    public function getPhotoUrlAttribute()
    {
        if (filter_var($this->photo, FILTER_VALIDATE_URL)) {
            return $this->photo;
        }
        return $this->photo ? asset('storage/' . $this->photo) : '';
    }

    public function unit()
    {
        return $this->hasOne(Unit::class, 'id', 'unit_id');
    }

    public function category()
    {
        return $this->hasOne(Category::class, 'id', 'category_id');
    }

    public function subcategory()
    {
        return $this->hasOne(Subcategory::class, 'id', 'subcategory_id');
    }

    public function brand()
    {
        return $this->hasOne(Brand::class, 'id', 'brand_id');
    }
}
