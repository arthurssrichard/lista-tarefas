<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
Carbon::setLocale('pt_BR');

class Tarefa extends Model
{
    protected $fillable = [
        'nome',
        'custo',
        'data_limite',
        'ordem_apresentacao'
    ];

    public function getDataLimiteFormatadaAttribute(){
        return Carbon::parse($this->data_limite)->format('m/d/Y');
    }
    public function getDiasRestantesAttribute(){
        return Carbon::parse($this->data_limite)->diffForHumans();
    }
}
