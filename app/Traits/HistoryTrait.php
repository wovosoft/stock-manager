<?php

namespace App\Traits;
trait HistoryTrait
{
    protected static function bootHistoryTrait()
    {
        static::creating(function ($model) {
            $item = new \App\Models\History;
            $item->user_id = auth()->check() ? auth()->id() : null;
            $item->related = get_class($model);
            $item->type = "created";
            $item->old_values = $model->getOriginal();
            $item->new_values = $model;
            $item->saveOrFail();
        });
        static::updating(function ($model) {
            $item = new \App\Models\History;
            $item->user_id = auth()->check() ? auth()->id() : null;
            $item->related = get_class($model);
            $item->type = "updated";
            $item->old_values = $model->getOriginal();
            $item->new_values = $model;
            $item->saveOrFail();
        });
        static::deleting(function ($model) {
            $item = new \App\Models\History;
            $item->user_id = auth()->check() ? auth()->id() : null;
            $item->related = get_class($model);
            $item->type = "deleted";
            $item->old_values = $model->getOriginal();
            $item->new_values = $model;
            $item->saveOrFail();
        });
    }
}
