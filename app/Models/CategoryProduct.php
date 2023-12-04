<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CategoryProduct extends Model
{
    // Podaj nazwę tabeli łączącej
    protected $table = 'categories_products';

    // Ustaw 'timestamps' na false, ponieważ tabela łącząca nie powinna zawierać kolumn 'created_at' i 'updated_at'
    public $timestamps = false;
}
