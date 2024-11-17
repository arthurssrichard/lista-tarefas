<div>
    <h2>Minhas Tarefas</h2>
    @foreach($tarefas as $tarefa)
        @include('livewire/includes/card-tarefa')
    @endforeach
    @include('livewire/includes/adicionar-tarefa')
</div>
