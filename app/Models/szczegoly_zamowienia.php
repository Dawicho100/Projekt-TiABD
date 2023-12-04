<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class szczegoly_zamowienia extends Model
{
    public $timestamps = false;
    use HasFactory;
    protected $table = 'zamowienie_szczegoly';
    protected $fillable = [
        'id_zamowinie',
        'id_produkt',
        'ilosc'

    ];
    public function product()
    {
        return $this->belongsTo(products::class, 'id_produkt', 'id');
    }

    public function zamowienie()
    {
        return $this->belongsTo(zamowienia::class, 'id_zamowinie', 'id');
    }
}
