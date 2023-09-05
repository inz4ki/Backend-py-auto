<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarefa_log extends Model
{
    use HasFactory;

    protected $fillable = [
        'pk_id_tarefa_log',
        'fk_id_tarefa_log',
        'nome_etapa',
        'caminho',
        'data_hora',
        'fk_id_etapa',
        'status'
    ];
    public $timestamps = false;
    protected $primaryKey = 'pk_id_tarefa_log';
    protected $table = 'bot_tarefa_logs';
}
