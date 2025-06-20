<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class emp_terminal extends Model
{
    protected $table = 'emp_terminal';

    protected $primaryKey = 'ter_id';

    public $timestamps = false;

    protected $fillable = [
        'ter_nombre',
        'ter_ubigeo',
        'ter_habilitado'
    ];
}
