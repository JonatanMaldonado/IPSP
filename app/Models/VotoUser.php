<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VotoUser extends Model
{
    protected $table = 'voto_users';

    protected $primaryKey = 'idvoto_user';

    protected $fillable = [
        'iduser',
        'idencuesta',
        'idopcion',
        'voto',
        'created_at',
        'updated_at'
    ];

    protected $guarded = [];

}
