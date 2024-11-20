<li class="tarefa" wire:key="{{$tarefa->id}}" wire:sortable.item="{{$tarefa->id}}">
    <div class="tarefa-card col-10 d-flex justify-content-between {{$tarefa->custo > 1000 ? 'bg-warning':''}}">{{-- preenchimento do card --}}
        <div class="col-8">
            @if($this->editingTarefaId == $tarefa->id)
            <div class="form-container">
                <input type="text" id="nome" wire:model="nome" placeholder="Nome" class="card-nome form-control mb-1">
            </div>
            <div class="form-container">
                <input id="custo" type="number" min="0" step="0.01" wire:model="custo" placeholder="Custo" class="card-custo form-control mb-1">
            </div>
            <div class="form-container">
                <input type="date" id="data-limite" wire:model="dataLimite" class="card-data form-control mb-2">
            </div>
            <button class="btn btn-success" wire:click="update()">Atualizar</button>
            <button class="btn btn-danger" wire:click="cancelEdit()">Cancelar</button>
            @else
            <h3 class="card-nome mb-1">{{$tarefa->nome}}</h3>
            <p class="card-custo mb-1">R$ {{number_format($tarefa->custo,2,',','.')}}</p>
            <p class="card-data mb-1 data">{{$tarefa->dataLimiteFormatada}} <span class="card-data mb-1 tempo-restante text-muted">{{$tarefa->diasRestantes}}</span></p>
            @endif
        </div>
        @if(!$this->editingTarefaId)
        <div class="col-1 d-flex flex-column justify-content-around">
            @if($tarefa->ordem_apresentacao > 1)
            <button class="toggle-order toggle-order-active" wire:click="cardUp({{$tarefa->id}})"><ion-icon wire:ignore name="chevron-up-outline"></ion-icon></button>
            @else
            <button class="toggle-order"><ion-icon wire:ignore name="chevron-up-outline"></ion-icon></button>
            @endif

            <button class="drag-card"><ion-icon title="Arrastar" wire:ignore wire:sortable.handle name="menu-outline"></ion-icon></button>

            @if($tarefa->ordem_apresentacao < $tarefas->max('ordem_apresentacao'))
            <button class="toggle-order toggle-order-active" wire:click="cardDown({{$tarefa->id}})"><ion-icon wire:ignore name="chevron-down-outline"></ion-icon></button>
            @else
            <button class="toggle-order"><ion-icon wire:ignore name="chevron-down-outline"></ion-icon></button>
            @endif
        </div>
        @endif
    </div>
    <div class="col-1 d-flex flex-column utils">
        <button class="editBtn" wire:click="edit({{$tarefa->id}})">
            <ion-icon wire:ignore title="Editar registro" name="create-outline"></ion-icon>
        </button>

        <button class="deleteBtn" wire:click="delete({{$tarefa->id}})" wire:confirm="Tem certeza que quer excluir essa tarefa?">
            <ion-icon wire:ignore title="Apagar registro" name="trash-outline"></ion-icon>
        </button>
    </div>
</li>