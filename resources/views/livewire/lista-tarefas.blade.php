<section class="col-6">
    <h2>Minhas Tarefas</h2>
    <ul class="col-12" wire:sortable="updateOrder" wire:sortable.options="{ animation: 100 }">
    @foreach($tarefas as $tarefa)
        @include('livewire/includes/card-tarefa')
    @endforeach
    </ul>
    @if(!$editingTarefaId)
        @include('livewire/includes/adicionar-tarefa')
    @endif
</section>
