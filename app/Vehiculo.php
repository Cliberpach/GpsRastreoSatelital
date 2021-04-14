<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vehiculo extends Model
{
    protected $table = 'vehiculos';
    public $timestamps = true;
    public $primaryKey = 'id';
    protected $fillable = [
            'marca',
            'placa',
            'color',
            'dnidueño',
            'nombredueño',
            'activodni',
            'estadovehiculo',
            'estado'
    ];
}
