<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'posts';

    public function run()
    {
        Post::factory()
            ->count(20)
            ->create();
    }

    protected $fillable = [
        'user_id',
        'status',
        'content',
        'image',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function loves()
    {
        return $this->hasMany(Love::class);
    }
}
