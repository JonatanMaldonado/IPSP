<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Encuesta extends Model
{
    protected $table = 'encuestas';

    protected $primaryKey = 'idencuesta';

    protected $fillable = [
        'titulo',
        'descripcion',
        'estado',
        'created_at',
        'updated_at',
        'created_by'
    ];

    protected $guarded = [];

    public function encuesta_opciones(){
        return $this->hasMany('App\Models\EncuestaOpcion', 'idencuesta')->where('estado', 'Activo');
    }
}
