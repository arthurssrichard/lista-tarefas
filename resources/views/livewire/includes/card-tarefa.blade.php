<li class="bg-light mt-1 p-2 row d-flex justify-content-between" wire:key="{{$tarefa->id}}" wire:sortable.item="{{$tarefa->id}}">
    <div class="col-6">
        @if($this->editingTarefaId == $tarefa->id)
        <div class="form-container">
            <label for="nome">Nome:</label>d-flex justify-content-between
            <input type="text" id="nome" wire:model="nome">
        </div>
        <div class="form-container">
            <label for="custo">Custo:</label>
            <input id="custo" type="number" min="0" step="0.01" wire:model="custo">
        </div>
        <div class="form-container">
            <label for="data-limite">Data Limite:</label>
            <input type="date" id="data-limite" wire:model="dataLimite">
        </div>
        <button wire:click="update()">Atualizar</button>
        <button wire:click="cancelEdit()">Cancelar</button>
        @else
        <h3>{{$tarefa->nome}}</h3>
        <p><strong>Custo: </strong>R$ {{number_format($tarefa->custo,2,',','.')}}</p>
        <p><strong>Data limite: </strong>{{$tarefa->data_limite}}</p>
        @endif
        <button wire:click="edit({{$tarefa->id}})">
            <ion-icon title="Editar registro" name="create-outline"></ion-icon>
        </button>
        <button wire:click="delete({{$tarefa->id}})" wire:confirm="Tem certeza que quer excluir essa tarefa?">
            <ion-icon title="Apagar registro" name="trash-outline"></ion-icon>
        </button>
    </div>
    <div class="col-2">
        @if($tarefa->ordem_apresentacao > 1)
        <button wire:click="cardUp({{$tarefa->id}})"><ion-icon name="caret-up-circle-outline"></ion-icon></button>
        @endif
        @if($tarefa->ordem_apresentacao < $tarefas->max('ordem_apresentacao'))
        <button wire:click="cardDown({{$tarefa->id}})"><ion-icon name="caret-down-circle-outline"></ion-icon></button>
        @endif
    </div>
</li>