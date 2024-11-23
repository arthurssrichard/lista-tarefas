<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;
Carbon::setLocale('pt_BR');

/**
 * Model "Tarefa"
 * Contém os atributos: nome, custo, data_limite e ordem_apresentacao
 */
class Tarefa extends Model
{
    protected $fillable = [
        'nome',
        'custo',
        'data_limite',
        'ordem_apresentacao'
    ];



    
    /**
     * Retorna a data limite no formato dia / mês / ano
     * 
     * @return string
     */
    public function getDataLimiteFormatadaAttribute(){ // 
        return Carbon::parse($this->data_limite)->format('d/m/Y');
    }



    /**
     * Retorna um texto informando o tempo restante para a execução da tarefa, com base no atributo 'data_limite'
     * ex: "em 15 dias"
     * 
     * @return string
     */
    public function getDiasRestantesAttribute(){
        return Carbon::parse($this->data_limite)->diffForHumans();
    }
}
