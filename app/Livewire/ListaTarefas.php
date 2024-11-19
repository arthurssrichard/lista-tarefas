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

    public $editingTarefaId;

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

    public function edit($tarefaId){
        $this->editingTarefaId = $tarefaId;
        $editingTarefa = Tarefa::findOrFail($tarefaId);

        $this->nome = $editingTarefa->nome;
        $this->custo = $editingTarefa->custo;
        $this->dataLimite = $editingTarefa->data_limite;
    }

    public function cancelEdit(){
        $this->reset('editingTarefaId');
    }
    public function update(){
        $this->validate([
            'nome'=>'required|min:2|max:50|unique:tarefas,nome,'.$this->editingTarefaId,
            'custo'=>'required|numeric|gte:0',
            'dataLimite'=>'required|date|after:today'
        ]);
        $tarefaAntiga = Tarefa::findOrFail($this->editingTarefaId);
        $tarefaAntiga->update([
            'nome' => $this->nome,
            'custo' => $this->custo,
            'data_limite'=> $this->dataLimite
        ]);
        $this->cancelEdit();
    }
    public function delete($tarefaId){
        Tarefa::findOrFail($tarefaId)->delete();
    }

    public function cardUp($tarefaId){
        $current = Tarefa::findOrFail($tarefaId);
        if ($current->ordem_apresentacao <= 1) {
            return;
        }
        $tarefaAcima = Tarefa::where('ordem_apresentacao', '=', $current->ordem_apresentacao - 1)->first();
        if ($tarefaAcima) {
            $tarefaAcima->update([
                'ordem_apresentacao' => 0,
            ]);
            $current->update([
                'ordem_apresentacao' => $current->ordem_apresentacao - 1,
            ]);
            $tarefaAcima->update([
                'ordem_apresentacao' => $current->ordem_apresentacao + 1,
            ]);
        }
    }

    public function cardDown($tarefaId){
        $current = Tarefa::findOrFail($tarefaId);
        if ($current->ordem_apresentacao >= Tarefa::max('ordem_apresentacao')) {
            return;
        }
        $tarefaAbaixo = Tarefa::where('ordem_apresentacao', '=', $current->ordem_apresentacao + 1)->first();
        if ($tarefaAbaixo) {
            $tarefaAbaixo->update([
                'ordem_apresentacao' => 0,
            ]);
            $current->update([
                'ordem_apresentacao' => $current->ordem_apresentacao + 1,
            ]);
            $tarefaAbaixo->update([
                'ordem_apresentacao' => $current->ordem_apresentacao - 1,
            ]);
        }
    }

    public function updateOrder($orders)
    {
        foreach ($orders as $index => $order) {
            $tarefa = Tarefa::find($order['value']);
            if ($tarefa) {
                $tarefa->update(['ordem_apresentacao' => -($index + 1)]);
            }
        }
    
        foreach ($orders as $order) {
            $tarefa = Tarefa::find($order['value']);
            if ($tarefa) {
                $tarefa->update(['ordem_apresentacao' => $order['order']]);
            }
        }
    }
    
    
    
    

    public function render()
    {
        $tarefas = Tarefa::orderBy('ordem_apresentacao','asc')->get();
        return view('livewire.lista-tarefas',['tarefas'=>$tarefas]);
    }
}
