<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Tarefa;
use Livewire\Attributes\Rule;
use PhpParser\Node\Stmt\TryCatch;
use Exception;

/**
 * Compontente Livewire responsável pelos métodos de inclusão, edição, exclusão e reordenação de tarefas
 * 
 * Um componente Livewire tem, por padrão, uma view, que está ligada a esse mesmo componente 
 * por meio de seus métodos e atributos, de forma que por exemplo, um botão "<button wire:key="create">Botâo</button>"
 * acionaria o método "create" nesta classe.
 * 
 * Assim também, o atributo "nome" desse componente pode ter seu valor vinculado a um elemento HTML. Ex: <input type="text" wire:model="nome">
 * A view associada a este componente é: [resources/views/livewire/lista-tarefas.blade.php](../../resources/views/livewire/lista-tarefas.blade.php)
 * 
 * @return void
 */
class ListaTarefas extends Component
{
    // Atributos do form de criação de tarefa
    public $nome;
    public $custo;
    public $dataLimite; /* pode apenas ser uma data depois do dia atual */

    // Atributos do form de edição de tarefa
    public $editNome;
    public $editCusto;
    public $editDataLimite;

    // Atributo passado via wire:key no método "edit"
    public $editingTarefaId;

    /**
     * Recebe os dados do form, valida e adiciona no banco de dados para uma nova tarefa
     * Chamado via wire:click="create" em [resources/views/livewire/includes/adicionar-tarefa.blade.php](../../resources/views/livewire/includes/adicionar-tarefa.blade.php)
     * 
     * @return void
     */
    public function create(){
        // Valida os atributos nome, custo e dataLimite que estão ligados ao frontend via wire:model
        $this->validate([
            'nome' => 'required|unique:tarefas|min:2|max:50', 
            'custo' => 'required|numeric|gte:0',
            'dataLimite' => 'required|date|after:today'
        ]);
        // Cria um objeto do tipo tarefa e persiste no banco de dados
        Tarefa::create([
            'nome' => $this->nome,
            'custo' => $this->custo,
            'data_limite'=> $this->dataLimite,
            'ordem_apresentacao' => (Tarefa::max('ordem_apresentacao')+1)
        ]);
        flash()->success('Tarefa incluída!');

        // Reseta os inputs no HTML vinculados via wire:model aos atributos
        $this->reset([
            'nome',
            'custo',
            'dataLimite'
        ]);
    }




    /**
     * Recebe id de uma tarefa, resgata os dados via ID no banco dedados e habilita o card para edição dos atributos 
     * Chamado via wire:click="edit" em [resources/views/livewire/includes/card-tarefa.blade.php](../../resources/views/livewire/includes/card-tarefa.blade.php)
     * 
     * @return void
     */
    public function edit($tarefaId){ // $tarefaId passado via wire:key na div mãe de cada compontente card-tarefa
        
        // Instancia o atributo de id da tarefa sendo editada no compontente com o valor 'ID' da tarefa
        $this->editingTarefaId = $tarefaId;
        $editingTarefa = Tarefa::findOrFail($tarefaId); // Resgata a tarefa do banco de dados

        // Atribui os valores dos atributos de edição deste componente para os valores da tarefa encontrada no banco de dados via ID
        // Os atributos estão vinculados via wire:model aos inputs HTML de cada card-tarefa em [resources/views/livewire/includes/card-tarefa.blade.php](../../resources/views/livewire/includes/card-tarefa.blade.php)
        $this->editNome = $editingTarefa->nome;
        $this->editCusto = $editingTarefa->custo;
        $this->editDataLimite = $editingTarefa->data_limite;
    }

    


    /**
     * Valida os dados inseridos nos campos de edição, e atualiza no banco de dados
     * Chamado via wire:click="update" em [resources/views/livewire/includes/card-tarefa.blade.php](../../resources/views/livewire/includes/card-tarefa.blade.php)
     * 
     * @return void 
     */
    public function update(){
        // Valida os atributos editNome, editCusto e editDataLimite que estão ligados ao frontend via wire:model
        $this->validate([
            'editNome'=>'required|min:2|max:50|unique:tarefas,nome,'.$this->editingTarefaId,
            'editCusto'=>'required|numeric|gte:0',
            'editDataLimite'=>'required|date|after:today'
        ]);

        //Encontra a tarefa que vai ser alterada no banco de dados
        $tarefaAntiga = Tarefa::findOrFail($this->editingTarefaId);
        $tarefaAntiga->update([ // atualiza os atributos e salva
            'nome' => $this->editNome,
            'custo' => $this->editCusto,
            'data_limite'=> $this->editDataLimite
        ]);
        $this->cancelEdit();//reseta os atributos e campos
    }




    /**
     * Reseta as variáveis (e mensagens de erro) dos atributos do componente, 
     * consequentemente esvaziando os campos de inserção de dados no HTML
     * 
     * @return void
     */
    public function cancelEdit(){
        $this->resetErrorBag();
        $this->reset([
            'editNome',
            'editCusto',
            'editDataLimite',
            'editingTarefaId'
        ]);
    }




    /**
     * Delete uma tarefa pelo id resgatado
     * Chamado via wire:click em [resources/views/livewire/includes/card-tarefa.blade.php](../../resources/views/livewire/includes/card-tarefa.blade.php)
     * 
     * @return void 
     */
    public function delete($tarefaId){
        // TryCatch caso haja algum erro como por exemplo, tentar apagar uma tarefa já deletada em outra aba que não foi atualizada
        try{
            Tarefa::findOrFail($tarefaId)->delete();
        }catch(Exception $e){
            flash()->error('Erro ao deletar tarefa!');
            return;
        }
    }




    /**
     * Move uma tarefa para cima
     * Chamado via wire:click="cardUp" em [resources/views/livewire/includes/card-tarefa.blade.php](../../resources/views/livewire/includes/card-tarefa.blade.php)
     * @return void 
     */
    public function cardUp($tarefaId){
        $current = Tarefa::findOrFail($tarefaId);
        if ($current->ordem_apresentacao <= 1) {  
            return; //impede caso o comando seja disparado do card no topo
        }
        $tarefaAcima = Tarefa::where('ordem_apresentacao', '=', $current->ordem_apresentacao - 1)->first();
        if ($tarefaAcima) {
            $tarefaAcima->update([
                'ordem_apresentacao' => 0, // zera o valor da tarefa acima, para a tarefa que vai subir assumir ele
            ]);
            $current->update([
                'ordem_apresentacao' => $current->ordem_apresentacao - 1, // atualiza o valor da tarefa atual
            ]);
            $tarefaAcima->update([
                'ordem_apresentacao' => $current->ordem_apresentacao + 1, // atualiza o valor da tarefa que estava acima, para ficar abaixo da atual
            ]);
        }
    }




    /**
     * Move uma tarefa para baixo
     * Chamado via wire:click="cardDown" em [resources/views/livewire/includes/card-tarefa.blade.php](../../resources/views/livewire/includes/card-tarefa.blade.php)
     * @return void 
     */
    public function cardDown($tarefaId){
        $current = Tarefa::findOrFail($tarefaId);
        if ($current->ordem_apresentacao >= Tarefa::max('ordem_apresentacao')) {
            return; //impede caso o comando seja disparado do ultimo card
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




    /**
     * Atualiza a ordem das tarefas após a ação de mover com drag and drop
     * @return void 
     */
    public function updateOrder($orders)
    {
        foreach ($orders as $index => $order) { //Coloca todos os valores de 'ordem_apresentacao' das tarefas como negativos
            $tarefa = Tarefa::find($order['value']);
            if ($tarefa) {
                $tarefa->update(['ordem_apresentacao' => -($index + 1)]);
            }
        }
        foreach ($orders as $order) { // atribui a cada tarefa o o valor de 'ordem_apresentacao' correto
            $tarefa = Tarefa::find($order['value']);
            if ($tarefa) {
                $tarefa->update(['ordem_apresentacao' => $order['order']]);
            }
        }
    }




    /**
     * Define mensagens de erro personalizadas
     * 
     * @return array
     */
    public function messages(): array
    {
        // Salva as mensagens em arrays associativos, para serem reaproveitadas
        // nos atributos de criação e edição
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




    /**
     * Renderiza o componente Livewire, retornando a view associada a ele, nesse caso sendo:
     * [resources/views/livewire/lista-tarefas.blade.php](../../resources/views/livewire/lista-tarefas.blade.php)
     * 
     * @return void
     */
    public function render()
    {
        $tarefas = Tarefa::orderBy('ordem_apresentacao','asc')->get();
        return view('livewire.lista-tarefas',['tarefas'=>$tarefas]); // Envia o vetor de tarefas para a view
    }
}
