<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Opcion extends Model
{
    protected $table = 'opciones';

    protected $primaryKey = 'id';

    protected $fillable = [
        'id',
        'opcion',
        'num_votos',
        'estado',
        'created_at',
        'updated_at',
        'created_by'
    ];

    protected $guarded = [];
}
