<?php

// Define el namespace de la clase para organizar y estructurar el código.
namespace App\Models;

// Importa el trait HasFactory que proporciona métodos para crear instancias del modelo usando factories.
use Illuminate\Database\Eloquent\Factories\HasFactory;

// Importa la clase Authenticatable que provee las funcionalidades básicas de autenticación.
use Illuminate\Foundation\Auth\User as Authenticatable;

// Importa el trait Notifiable que permite a los usuarios recibir notificaciones.
use Illuminate\Notifications\Notifiable;

// Define la clase User que extiende Authenticatable, lo que significa que hereda características de autenticación.
class User extends Authenticatable
{
    // Usa los traits HasFactory y Notifiable dentro de la clase.
    use HasFactory, Notifiable;

    /**
     * Los atributos que son asignables en masa.
     * Esto protege contra la asignación masiva de atributos no deseados.
     *
     * @var array
     */

    //para las relaciones uno a muchos con compra
    //retorna un array  con las compras asociadas al usuario.
     
    // Relación con el modelo Venta
    public function ventas()
    {
        return $this->hasMany(Venta::class);
    }

    // Relación con el modelo Compra
    public function compras()
    {
        return $this->hasMany(Compra::class);
    }

    // Relación con el modelo Departamento
    public function departamento()
    {
        return $this->belongsTo(Departamento::class);
    }

    protected $fillable = [
        'name',             // Nombre del usuario.
        'email',            // Correo electrónico del usuario.
        'departamento_id',  // ID del departamento al que pertenece el usuario.
        'password',         // Contraseña del usuario.
    ];

    /**
     * Los atributos que deben estar ocultos para los arrays.
     * Esto es útil cuando se convierte el modelo a array o JSON para evitar exponer datos sensibles.
     *
     * @var array
     */
    protected $hidden = [
        'password',         // Oculta la contraseña del usuario.
        'remember_token',   // Oculta el token de "recordar" al usuario para sesiones persistentes.
    ];

    /**
     * Los atributos que deben ser convertidos a tipos nativos.
     * Esto asegura que ciertos atributos sean convertidos automáticamente a los tipos especificados.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime', // Convierte el atributo email_verified_at a un objeto DateTime.
    ];
}
