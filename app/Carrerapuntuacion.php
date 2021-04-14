<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Carrerapuntuacion extends Model
{
    protected $table="carrerapuntuacion";
    public $primaryKey="id";
    protected $fillable=["carrera_id",
                         "user_id",
                         "puntuacion"];
    public $timestamps=true;
}
