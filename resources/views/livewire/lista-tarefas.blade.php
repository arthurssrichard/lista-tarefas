<div>
    <h2>Minhas Tarefas</h2>
    <ul wire:sortable="updateOrder" wire:sortable.options="{ animation: 100 }">
    @foreach($tarefas as $tarefa)
        @include('livewire/includes/card-tarefa')
    @endforeach
    </ul>
    @include('livewire/includes/adicionar-tarefa')
</div>
