<div>
    <h2>Minhas Tarefas</h2>
    @for($i = 0; $i < 3; $i++)
        @include('livewire/includes/card-tarefa')
    @endfor
    @include('livewire/includes/adicionar-tarefa')
</div>
