<section class="col-11 col-sm-6">
    @if(session('error'))
    <div class="alert alert-danger alert-dismissible d-flex flex-column fade show" role="alert">
        <div>
            <strong><ion-icon name="warning-outline"></ion-icon> Erro!</strong>
            <p>{{ session('error') }}</p>
        </div>
        <!-- Botão de fechar a alerta -->
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif

    @if(session('success'))
    <div class="alert alert-success alert-dismissible d-flex flex-column fade show" role="alert">
        <strong><ion-icon name="checkmark-circle-outline"></ion-icon> Sucesso!</strong>
        <p>{{session('success')}}</p>
        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
    </div>
    @endif
    <h2>Minhas Tarefas</h2>
    <ul class="col-12" wire:sortable="updateOrder" wire:sortable.options="{ animation: 300 }">
        @foreach($tarefas as $tarefa)
        @include('livewire/includes/card-tarefa')
        @endforeach
    </ul>
    @include('livewire/includes/adicionar-tarefa')
</section>