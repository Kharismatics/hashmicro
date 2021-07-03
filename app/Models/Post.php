<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title', 'caption', 'image'
    ];
    public static function boot()
    {
       parent::boot();
       static::creating(function($model) { $user = auth()->user(); $model->created_by = $user->id; });
       static::updating(function($model) { $user = auth()->user(); $model->updated_by = $user->id; });
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function getTotalLikes()
    {
        return $this->hasMany(Like::class)->count();
    }
    public function getTotalComments()
    {
        return $this->hasMany(Comment::class)->count();
    }
}
