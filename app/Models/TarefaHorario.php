<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TarefaHorario extends Model
{
    use HasFactory;

    protected $fillable = [
        'estado',
        'fk_id_tarefa_horarios',
        'pk_id_horario_tarefas',
        'hora_executar'
    ];
    protected $primaryKey = 'pk_id_horario_tarefas';
    protected $table = 'bot_horario_tarefas';
    public $timestamps = false;
}
