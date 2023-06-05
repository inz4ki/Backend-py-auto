<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tarefa_log extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = 'bot_tarefa_logs';
}
