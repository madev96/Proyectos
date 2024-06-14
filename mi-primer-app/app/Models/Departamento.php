<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class Departamento extends Model
{
    use HasFactory;

    // Esta función establece la relación uno a muchos entre este departamento y los usuarios asociados a él.
    // Devuelve una colección de usuarios que pertenecen a este departamento.
    public function user(){
        return $this->hasMany(User::class);
    }

    // Los atributos que están en esta lista pueden ser asignados masivamente,
    // lo que significa que pueden ser llenados utilizando el método create o fill de Eloquent.
    protected $fillable = [
        'nombre',
    ];

}
