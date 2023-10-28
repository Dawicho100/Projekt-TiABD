<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Dostawa extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $table = 'dostawa';
    protected $fillable = [
        'name',
        'cena',
        'how_long',
    ];
}
