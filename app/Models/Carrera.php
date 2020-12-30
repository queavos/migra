<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
  protected $table="sistema_Carreras";
  protected $primaryKey = 'cod_carrera';
  protected $keyType = 'string';
  public $carre_id=0;
  public $facu_id=0;
  function cursos()
    {
      return $this->hasMany('App\Models\Curso','cod_carrera');
    }
}
