<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Like extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'post_id', 
    ];
    public static function boot()
    {
       parent::boot();
       static::creating(function($model) { $user = auth()->user(); $model->created_by = $user->id; });
       static::updating(function($model) { $user = auth()->user(); $model->updated_by = $user->id; });
    }
}
