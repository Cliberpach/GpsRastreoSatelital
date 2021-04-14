<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clienteapp extends Model
{
    protected $table = 'clienteapp';
    public $primaryKey = 'id';
    protected $fillable = ['nombre',
                           'telefono',
                           'user_id',
                           'estado'
                        ];
    public $timestamps = true;
}
