<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EncuestaOpcion extends Model
{
    protected $table = 'encuesta_opcion';

    protected $primaryKey = 'id';

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
