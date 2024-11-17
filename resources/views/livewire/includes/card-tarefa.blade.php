<div class="bg-light mt-1 p-2" wire:key="{{$tarefa->id}}">
    @if($this->editingTarefaId == $tarefa->id)
        <div class="form-container">
            <label for="nome">Nome:</label>
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
    <div>
        <button wire:click="edit({{$tarefa->id}})">
            <ion-icon title="Editar registro" name="create-outline"></ion-icon>
        </button>
        <ion-icon title="Apagar registro" name="trash-outline"></ion-icon>

    </div>
</div>