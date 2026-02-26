<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class SuperBlogModel extends Model
{
    protected $fillable = [
        'blg_image',
        'blg_title',
        'blg_desc',
        'slug',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {

            $slug = Str::slug($model->blg_title);

            $count = self::where('slug', 'LIKE', "{$slug}%")->count();

            $model->slug = $count ? "{$slug}-{$count}" : $slug;
        });

        static::updating(function ($model) {

            $slug = Str::slug($model->blg_title);

            $count = self::where('slug', 'LIKE', "{$slug}%")
                ->where('id', '!=', $model->id)
                ->count();

            $model->slug = $count ? "{$slug}-{$count}" : $slug;
        });
    }
}