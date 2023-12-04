<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class products extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'odnosnik',
        'ilosc',
        'opis',
        'cena',
    ];

    public function categories()
    {
        return $this->belongsToMany(categories::class, 'categories_products', 'products_id', 'categories_id');
    }

    public function parameters()
    {
        return $this->belongsToMany(parameters::class, 'parameters_products', 'products_id', 'parameters_id');
    }
    public function szczegoly()
    {
        return $this->belongsToMany(szczegoly_zamowienia::class, 'szczegoly_produkt', 'id_products', 'id_szczegoly');
    }
    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'user_favorite_products', 'products_id', 'user_id');    }
}
