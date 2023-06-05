<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TarefaHorario extends Model
{
    use HasFactory;

    protected $fillable = [
        'data_hora_executar',
        'dia_da_semana',
        'estado',
        'fk_id_tarefa',
        'pk_id_tarefa_horario'
    ];
    protected $primaryKey = 'pk_id_tarefa_horario';
    protected $table = 'tarefa_horario';
    public $timestamps = false;
}
