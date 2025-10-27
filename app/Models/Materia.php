<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materia extends Model
{
    protected $table = 'materias';
    protected $primaryKey = 'sigla';
    public $incrementing = false;
    protected $keyType = 'string';
    protected $fillable = ['sigla','nombre','nivel'];

    public function grupos()
    {
        return $this->belongsToMany(Grupo::class, 'grupo_materias', 'materia_sigla', 'grupo_id')
                    ->withPivot('activo');
    }
}
