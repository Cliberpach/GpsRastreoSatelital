<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Conductor extends Model
{
    protected $table = 'conductores';
    public $primaryKey = 'id';
    protected $fillable = ['nombre',
                           'tipo_documento',
                           'documento',
                           'direccion',
                           'tipo_documento_contacto',
                           'documento_contacto',
                           'nombre_contacto',
                           'telefono_movil',
                           'correo_electronico',
                           'imei',
                           'estado',
                           'activo'
                        ];
    public $timestamps = true;
    
}
