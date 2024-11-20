<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Tarefa;
use Livewire\Attributes\Rule;
use PhpParser\Node\Stmt\TryCatch;
use Exception;

class ListaTarefas extends Component
{
    //#[Rule('required|unique:tarefas|min:2|max:50')]
    public $nome;
    //#[Rule('required|numeric|gte:0')]
    public $custo;
    //#[Rule('required|date|after:today')]
    public $dataLimite;

    //#[Rule('required|unique:tarefas|min:2|max:50')]
    public $editNome;
    //#[Rule('required|numeric|gte:0')]
    public $editCusto;
    //#[Rule('required|date|after:today')]
    public $editDataLimite;

    public $editingTarefaId;

    public function create(){
        //dd("$this->nome $this->custo $this->dataLimite");
        $this->validate([
            'nome' => 'required|unique:tarefas|min:2|max:50|unique:tarefas', 
            'custo' => 'required|numeric|gte:0',
            'dataLimite' => 'required|date|after:today'
        ]);
        Tarefa::create([
            'nome' => $this->nome,
            'custo' => $this->custo,
            'data_limite'=> $this->dataLimite,
            'ordem_apresentacao' => (Tarefa::max('ordem_apresentacao')+1)
        ]);
        //session()->flash('success','Tarefa incluída');
        flash()->success('Tarefa incluída!');
        $this->reset([
            'nome',
            'custo',
            'dataLimite'
        ]);
    }

    public function edit($tarefaId){
        $this->cancelEdit();
        $this->editingTarefaId = $tarefaId;
        $editingTarefa = Tarefa::findOrFail($tarefaId);

        $this->editNome = $editingTarefa->nome;
        $this->editCusto = $editingTarefa->custo;
        $this->editDataLimite = $editingTarefa->data_limite;
    }
    public function messages(): array
    {
        $nome = [
            'required' => 'O campo "<strong>Nome</strong>" é obrigatório',
            'unique' => 'O campo "<strong>Nome</strong>" não pode ser repetido',
            'min' => 'O campo "<strong>Nome</strong>" deve ter entr 2 e 50 caracteres'
        ];
        $custo =[   
            'required' => 'O campo "<strong>Custo</strong>" é obrigatório',
            'numeric' => 'O campo "<strong>Custo</strong>" deve ser numérico',
            'gte' => 'O campo "<strong>Custo</strong>" deves ser positivo'
        ];
        $dataLimite = [
            'required' => 'O campo "<strong>Data Limite</strong>" é obrigatório',
            'date' => 'O campo "<strong>Data Limite</strong>" deve ser uma data',
            'after' => 'A "<strong>Data Limite</strong>" deve ser posterior o dia atual'
        ];

        return [
            'nome.required' => $nome['required'], 'editNome.required' => $nome['required'],
            'nome.unique' => $nome['unique'], 'editNome.unique' => $nome['unique'],
            'nome.min' => $nome['min'], 'editNome.min' => $nome['min'],
            //
            'custo.required' => $custo['required'], 'editCusto.required' => $custo['required'],
            'custo.numeric' => $custo['numeric'], 'editCusto.numeric' => $custo['numeric'],
            'custo.gte' => $custo['gte'], 'editCusto.gte' => $custo['gte'],
            //
            'dataLimite.required' => $dataLimite['required'], 'editDataLimite.required'=>$dataLimite['required'],
            'dataLimite.date' => $dataLimite['date'], 'editDataLimite.date'=>$dataLimite['date'],
            'dataLimite.after' => $dataLimite['after'], 'editDataLimite.after'=>$dataLimite['after']
        ];
    }

    public function cancelEdit(){
        $this->resetErrorBag();
        $this->reset([
            'nome',
            'custo',
            'dataLimite',
            'editingTarefaId'
        ]);
    }
    public function update(){
        $this->validate([
            'editNome'=>'required|min:2|max:50|unique:tarefas,nome,'.$this->editingTarefaId,
            'editCusto'=>'required|numeric|gte:0',
            'editDataLimite'=>'required|date|after:today'
        ]);
        $tarefaAntiga = Tarefa::findOrFail($this->editingTarefaId);
        $tarefaAntiga->update([
            'nome' => $this->editNome,
            'custo' => $this->editCusto,
            'data_limite'=> $this->editDataLimite
        ]);
        $this->cancelEdit();
    }
    public function delete($tarefaId){
        try{
            Tarefa::findOrFail($tarefaId)->delete();
        }catch(Exception $e){
            //session()->flash('error','Erro ao deletar tarefa');
            flash()->error('Erro ao deletar tarefa!');
            return;
        }

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
