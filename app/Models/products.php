<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\categories;
use App\Models\parameters;

class products extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $table = 'dostawa';
    protected $fillable = [
        'name',
        'id_category',
        'id_parameter',
        'odnosnik',
        'ilosc',
        'opis',
    ];
    public function categories()
    {
        return $this->belongsToMany('App\categories');
    }
    public function parameters()
    {
        return $this->belongsToMany('App\parameters');
    }
}
