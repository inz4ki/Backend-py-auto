<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Etapa extends Model
{
    use HasFactory;

    protected $fillable = [
        'nome_etapa',
        'acao',
        'tempo_execucao',
        'digitar',
        'caminho',
        'fk_id_tarefa',
        'ordem',
        'atalho'
    ];
    protected $primaryKey = 'pk_id_etapa';
    protected $table = 'bot_etapas';
    public $timestamps = false;
}
