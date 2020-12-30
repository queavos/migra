<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Calificacion extends Model
{
    use HasFactory;
    protected $table="sistema_Calificaciones";
    function inscripcion()
      {
        return $this->belongsTo('App\Models\Inscripcion','inscripcion');
      }
      function materia()
        {
          return $this->belongsTo('App\Models\Materia','codigo_materia');
        }
        function examen()
          {
            return $this->belongsTo('App\Models\Examen','codigo_examen');
          }
}
