<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
class Obstaculo extends Model
{
    use HasFactory,Notifiable;

    protected $fillable = [
        'pk_id_obstaculo',
        'fk_id_tarefa',
        'obstaculo',
        'acao',
    ];
    protected $primaryKey = 'pk_id_obstaculo';
    protected $table = 'bot_obstaculo';
    public $timestamps = false;
}
