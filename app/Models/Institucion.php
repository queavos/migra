<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Institucion extends Model
{
  protected $table="sistema_Instituciones";
  protected $primaryKey = 'cod_institucion';
  protected $keyType = 'string';
  public $newid=0;
  function facultades()
    {
      return $this->hasMany('App\Models\Facultad','cod_institucion');
    }
}
