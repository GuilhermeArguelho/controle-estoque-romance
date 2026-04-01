<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Repasse extends Model
{
    protected $fillable = [
        'vendedora_id',
        'roupa_id',
        'quantidade_enviada',
        'quantidade_devolvida',
        'quantidade_vendida',
        'data_repasse',
    ];
}
