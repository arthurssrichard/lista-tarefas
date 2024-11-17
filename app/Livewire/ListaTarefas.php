<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Tarefa;
use Livewire\Attributes\Rule;

class ListaTarefas extends Component
{
    #[Rule('required|unique:tarefas|min:2|max:50')]
    public $nome;
    #[Rule('required|numeric|gte:0')]
    public $custo;
    #[Rule('required|date|after:today')]
    public $dataLimite;

    public function create(){
        $this->validate();
        Tarefa::create([
            'nome' => $this->nome,
            'custo' => $this->custo,
            'data_limite'=> $this->dataLimite,
            'ordem_apresentacao' => (Tarefa::max('ordem_apresentacao')+1)
        ]);
        $this->reset([
            'nome',
            'custo',
            'dataLimite'
        ]);
    }

    public function render()
    {
        $tarefas = Tarefa::all();
        return view('livewire.lista-tarefas',['tarefas'=>$tarefas]);
    }
}
