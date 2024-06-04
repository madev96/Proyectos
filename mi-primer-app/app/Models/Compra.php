<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Compra extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class);
    }

    //Para usarlo en el formulario de compras Desde la base de datos
    protected $fillable = [
        'cantidad',
        'precio',
        'user_id',
    ];

}


