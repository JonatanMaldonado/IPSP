<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EncuestaOpcion extends Model
{
    protected $table = 'encuesta_opcion';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'id_encuesta',
        'id_opcion',
        'estado',
        'created_at',
        'updated_at',
        'created_by'
    ];

    protected $guarded = [];
}
