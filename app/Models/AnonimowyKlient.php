<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnonimowyKlient extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'anonimowy_klient';

    protected $fillable = [
        'imie',
        'email',
        'adres',
        'miasto',
        'nr_tel',
        // Dodaj inne kolumny, jeśli są potrzebne
    ];

    // Dodaj ewentualne relacje, np. jeśli masz relację z zamówieniami
    public function zamowienia()
    {
        return $this->hasMany(zamowienia::class, 'email', 'email');
    }
}
