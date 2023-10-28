<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\products;

class parameters extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $table = 'parameters';
    protected $fillable = [
        'name',

    ];
    public function products()
    {
        return $this->belongsToMany('App\products');
    }
}
