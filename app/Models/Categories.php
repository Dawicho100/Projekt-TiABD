<?php

namespace App\Models;

use App\Models\products;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class categories extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $table = 'categories';
    protected $fillable = [
        'name',
    ];
    public function products()
{
    return $this->belongsToMany(products::class, 'categories_products');
}

}
