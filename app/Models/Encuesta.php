<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Encuesta extends Model
{
    protected $table = 'encuestas';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'titulo',
        'descripcion',
        'estado',
        'created_at',
        'updated_at',
        'created_by'
    ];

    protected $guarded = [];
}
