<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Platnosci extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $table = 'platnosci';
    protected $fillable = [
        'name'
    ];
    public function zamowienie()
    {
        return $this->hasMany(zamowienia::class, 'id_platnosci', 'id');
    }
}
