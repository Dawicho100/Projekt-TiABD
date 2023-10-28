<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pages extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $table = 'pages';
    protected $fillable = [
        'name',
        'text',
        'slug',
    ];
}
