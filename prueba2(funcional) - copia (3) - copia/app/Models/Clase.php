<?php

// app/Models/Clase.php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clase extends Model
{
    use HasFactory;

    protected $fillable = [
        'categoria', 'instructor', 'cupos_totales', 'duracion', 
        'fecha_inicio', 'hora_inicio', 'hora_fin', 'costo_inscripcion', 'informacion'
    ];

    public function inscripciones()
    {
        return $this->hasMany(Inscripcion::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'inscripciones', 'clase_id', 'user_id');
    }
}
