<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Card extends Model
{
    use HasFactory;
    use SoftDeletes;
    protected $fillable = [
        'date_create', 'name', 'minimal', 'maximal', 'istrue', 'ability',
    ];
    public static function boot()
    {
       parent::boot();
       static::creating(function($model) { $user = auth()->user(); $model->created_by = $user->id; });
       static::updating(function($model) { $user = auth()->user(); $model->updated_by = $user->id; });
    }
    public static function getTableName()
    {
        return (new self())->getTable();
    }
}
