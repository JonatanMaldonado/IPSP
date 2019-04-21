<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EncuestaOpcion extends Model
{
    protected $table = 'encuesta_opciones';

    protected $primaryKey = 'idencuesta_opcion';

    protected $fillable = [
        'idencuesta',
        'idopcion',
        'estado',
        'created_at',
        'updated_at',
        'created_by'
    ];

    protected $guarded = [];

    public function opcion(){
        return $this->belongsTo('App\Models\Opcion', 'idopcion')->where('estado', 'Activo');
    }
}
