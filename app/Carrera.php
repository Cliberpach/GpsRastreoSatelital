<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carrera extends Model
{
    protected $table="carrera";
    public $primaryKey="id";
    protected $fillable=["conductor_id",
                         "user_id",
                         "direccionInicial",
                         "direccionFinal",
                         "referencia",
                         "hora",
                         "importe",
                        "latinicial",
                        "latfinal",
                        "lnginicial",
                        "lngfinal",
                        "estado",
                        "estadocarrera"];
    public $timestamps=true;
}
