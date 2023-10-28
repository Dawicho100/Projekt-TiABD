<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\products;

class categories extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $table = 'categories';
    protected $fillable = [
        'name',
    ];    public function products()
    {
        return $this->belongsToMany('App\products');
    }

}
