<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Tarefa extends Model
{
    use HasFactory,Notifiable;

    protected $fillable = [
        'nome_tarefa',
        'hora_executar',
        'estado',
        'dia_da_semana'
    ];
    protected $primaryKey = 'pk_id_tarefa';
    protected $table = 'bot_tarefas';
    public $timestamps = false;
}
