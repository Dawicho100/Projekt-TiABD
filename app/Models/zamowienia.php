<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class zamowienia extends Model
{
    public $timestamps = false;
    use HasFactory;

    protected $table = 'zamowienie';

    protected $fillable = [
        'email',
        'id_platnosci',
        'id_dostawy',
        'czy_anon',
        'adres',
        'miasto'
    ];
    public function calculateTotalAmount()
    {
        // Logic to calculate the total amount for this order
        $totalAmount = 0;

        foreach ($this->szczegoly as $szczegol) {
            $productAmount = $szczegol->ilosc * $szczegol->product->cena;
            $totalAmount += $productAmount;
        }

        return $totalAmount;
    }
    public function users()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    public function payment()
    {
        return $this->belongsTo(Platnosci::class, 'id_platnosci', 'id');
    }

    public function delivery()
    {
        return $this->belongsTo(Dostawa::class, 'id_dostawy', 'id');
    }

    public function szczegoly()
    {
        return $this->hasMany(szczegoly_zamowienia::class, 'id_zamowinie', 'id');
    }
    public function anonimowyKlient()
    {
        return $this->belongsTo(AnonimowyKlient::class, 'email', 'email');
    }
}

