<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Post extends Model
{
    use HasFactory,HasApiTokens;

    protected $table = 'posts';

    protected $fillable =[
        'user_id',
        'titulo',
        'contenido'
    ];

    public $timestamps = false;
}
