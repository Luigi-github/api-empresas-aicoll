<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $fillable = [
        'nit', 'nombre', 'direccion', 'telefono', 'estado'
    ];
}
